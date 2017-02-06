<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Klient;

class ClientController extends Controller {

    public function addClient(Request $request){
    	$validator = Validator::make($request->all(), [
            'emri' => 'required',
	        'mbiemri' => 'required',
	        'email' => 'required|email|unique:client',
	        'password' => 'required'
        ]);
    	if(!$validator->fails()){
    		$client = new Klient;
    		$client->emri = $request->emri;
    		$client->mbiemri = $request->mbiemri;
    		$client->email = $request->email;
    		$client->password = $request->password;
    		$client->save();
    		return Response([
    			'success' =>true,
                'client' => json_encode($client),
			    'error' => "Klienti u shtua me sukses"
			], 200);

    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Te dhenat jane te pasakta"
			], 401);
    	}
    }
    public function getClient(Request $request,$client_id){
    	$client = Klient::find($client_id);
    	if(isset($client)){
    		return Response([
    			'success' =>true,
    			'client_id' => $client->id,
    			'emri' => $client->emri,
    			'mbiemri' => $client->mbiemri,
    			'email' => $client ->email
    		],200);
    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Klienti nuk u gjend"
			], 404);
    	}
    }
    public function updateClient(Request $request){
    	if (isset($request->email)) {
	    	$email = $request->email;
	    	$client = Klient::where('email','=',$email)->first();
	    	if(isset($client)){
	    		if(isset($request->emri) && isset($request->mbiemri)){
	    			$client->emri = $request->emri;
	    			$client->mbiemri = $request->mbiemri;
	    			$client->save();
	    			return Response([
		    			'success' =>true,
					    'message' => "Klienti u ndryshua me sukses"
					], 200);
	    		}else{
	    			return Response([
		    			'success' =>false,
					    'error' => "Te dhenat jane te pasakta"
					], 401);
	    		}
	    	}else{
	    		return Response([
	    			'success' =>false,
				    'error' => "Klienti nuk u gjend"
				], 404);
	    	}
    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Te dhenat jane te pasakta"
			], 401);
    	}
    }
    public function deleteClient(Request $request, $client_id){
		$client = Klient::find($client_id);
    	if(isset($client)){
            DB::delete('delete from pagese where porosi_id IN (select id from porosi where client_id = '.$client_id.' )');
            DB::delete('delete from porosi where client_id = '.$client_id);
		    $client ->delete();
		    return Response([
    			'success' =>true,
			    'message' => "Klienti u fshi me sukses"
			], 200);
	    }else{
    		return Response([
    			'success' =>false,
			    'error' => "Klienti nuk u gjend"
			], 404);
    	}
    }
}
