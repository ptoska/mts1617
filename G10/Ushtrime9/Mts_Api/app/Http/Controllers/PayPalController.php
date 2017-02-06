<?php 
namespace App\Http\Controllers;
use Netshell\Paypal\Paypal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Porosi;
use App\Pagese;

class PayPalController extends Controller {
 	private $_apiContext;
 	private $paypal;

    public function __construct()
    {
    	$this->paypal = new Paypal;
        $this->_apiContext = $this->paypal->apiContext('ARdTsbSJgLWLmNPsEofQED22YI47z9sqoFhcHZbU8sgH4oznf7pjS8j3oOZrEUColBfoyCstsaoUZoC4','EC0CuriHNokrPejvOEbs5qIFQtSAdeeocWDNjsl-WJ0IBQnH91K4jd4QvyNHjsuhg1sIpfVQSDOFjHG4');

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));
    }

    public function getLink(Request $request, $porosi_id){
    	$porosi = Porosi::find($porosi_id);
    	if(isset($porosi) && 1*$porosi->status == 2){
	    	$payer = $this->paypal->Payer();
		    $payer->setPaymentMethod('paypal');

		    $amount = $this->paypal->Amount();
		    $amount->setCurrency('USD');
		    $amount->setTotal(1*$request->amount); 

		    $transaction = $this->paypal->Transaction();
		    $transaction->setAmount($amount);
		    $transaction->setDescription('Testimi i paypal');

		    $redirectUrls = $this->paypal->RedirectUrls();
		    $redirectUrls->setReturnUrl('http://localhost:8000/api/v1/paypal/confirm?porosi_id='.$porosi_id.'&vlera='.(1*$request->amount));
		    $redirectUrls->setCancelUrl('http://localhost:8000/api/v1/paypal/cancel?porosi_id='.$porosi_id);

		    $payment = $this->paypal->Payment();
		    $payment->setIntent('sale');
		    $payment->setPayer($payer);
		    $payment->setRedirectUrls($redirectUrls);
		    $payment->setTransactions(array($transaction));

		    $response = $payment->create($this->_apiContext);
		    $redirectUrl = $response->links[1]->href;
		    return Response([
    			'success' =>true,
			    'url' => $redirectUrl
			], 200);
		}else{
			if(isset($porosi->status) && $porosi->status == 1){
				return Response([
	    			'success' =>false,
				    'error' => "Porosia eshte paguar"
				], 403);
			}elseif(isset($porosi->status) && $porosi->status == 0){
				return Response([
	    			'success' =>false,
				    'error' => "Porosia eshte anulluar"
				], 403);

			}else{
				return Response([
	    			'success' =>false,
				    'error' => "Porosia nuk u gjend"
				], 404);
			}
		}
    }
    public function confirmPagese(Request $request){
    	$id = $request->get('paymentId');
	    $token = $request->get('token');
	    $payer_id = $request->get('PayerID');

	    $payment = $this->paypal->getById($id, $this->_apiContext);

	    $paymentExecution = $this->paypal->PaymentExecution();

	    $paymentExecution->setPayerId($payer_id);
	    $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

		$validator = Validator::make($request->all(), [
	        'porosi_id' => 'required',
	        'vlera' => 'required'
	    ]);
	    if(!$validator->fails()){
	    	$porosi = Porosi::find($request->get('porosi_id'));
	    	if(isset($porosi)){
	    		$pagese = new Pagese;
	    		$pagese->porosi_id = $request->get('porosi_id');
	    		$pagese->transaction_id = $request->get('paymentId');
	    		$pagese->vlera = $request->get('vlera');
	    		$pagese->save();
	    		$porosi->status = 1;
	    		$porosi->save();
	    		return Response([
	    			'success' =>true,
				    'error' => "Pagesa u shtua me sukses"
				], 200);
	    	}else{
	    		return Response([
	    			'success' =>false,
				    'error' => "Porosia nuk ekziston"
				], 404);
	    	}
    		

    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Te dhenat jane te pasakta"
			], 401);
    	}

    }
    public function cancelPagese(Request $request){
    	$porosi = Porosi::find($request->get('porosi_id'));
    	$porosi->status=0;
    	$porosi->save();
    	return Response([
			'success' =>false,
		    'error' => "Pagesa u anullua nga klienti"
		], 402);
    }

}
