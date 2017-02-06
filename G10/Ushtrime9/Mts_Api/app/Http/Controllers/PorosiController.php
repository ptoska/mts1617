<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Porosi;
use App\Klient;
use DB;

class PorosiController extends Controller {
	public function addPorosi(Request $request)
	{
		$validator = Validator::make($request->all(), [
	        'client_id' => 'required',
	        'pershkrimi' => 'required',
	        'product_id' => 'required'
	    ]);
	    if(!$validator->fails()){
	    	$client = Klient::find($request->client_id);
	    	if(isset($client)){
	    		$porosi = new Porosi;
	    		$porosi->client_id = $request->client_id;
	    		$porosi->pershkrimi = $request->pershkrimi;
	    		$porosi->product_id = $request->product_id;
	    		$porosi->status = 2;
	    		$porosi->save();
	    		return Response([
	    			'success' =>true,
	    			'porosi' => json_encode($porosi),
				    'error' => "Porosia u shtua me sukses"
				], 200);
	    	}else{
	    		return Response([
	    			'success' =>false,
				    'error' => "Klienti Nuk ekziston"
				], 404);
	    	}
    		

    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Te dhenat jane te pasakta"
			], 401);
    	}
	}
	public function getPorosi(Request $request,$porosi_id)
	{
		$porosi = Porosi::find($porosi_id);
    	if(isset($porosi)){
    		return Response([
    			'success' =>true,
    			'porosi_id' => $porosi->id,
    			'client_id' => $porosi->client_id,
    			'pershkrimi' => $porosi->pershkrimi,
    			'status' => $porosi->status,
    			'product_id' => $porosi->product_id
    		],200);
    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Porosia nuk u gjend"
			], 404);
    	}
	}
	public function updatePorosi(Request $request,$porosi_id)
	{
		$porosi = Porosi::find($porosi_id);
		if(isset($porosi)){
			if(isset($request->status)){
				$porosi->status = $request->status;
				$porosi->save();
				return Response([
	    			'success' =>true,
				    'message' => "Porosia u modifikua me sukses"
				], 200);	
			}else{
				return Response([
    				'success' =>false,
				    'error' => "Mund te modifikoni vetem statusin e porosise"
				], 406);
			}
    	}else{
    		return Response([
    			'success' =>false,
			    'error' => "Porosia nuk u gjend"
			], 404);
    	}
	}
	public function deletePorosi(Request $request,$porosi_id)
	{
		$porosi = Porosi::find($porosi_id);
    	if(isset($porosi)){
    		DB::table('pagese')->where('porosi_id', '=', $porosi_id)->delete();
		    $porosi ->delete();
		    return Response([
    			'success' =>true,
			    'message' => "Porosia u fshi me sukses"
			], 200);
	    }else{
    		return Response([
    			'success' =>false,
			    'error' => "Porosia nuk u gjend"
			], 404);
    	}
	}

}
