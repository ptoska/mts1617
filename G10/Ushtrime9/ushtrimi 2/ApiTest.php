<?php
require 'vendor/autoload.php';
class ApiTest extends PHPUnit_Framework_TestCase
{
	private $client_id;
	private $porosi_id;
	private $client_email;

	public function testAddClient(){
		$data = array("emri"=>"test","mbiemri"=>'client',"email"=>'test@client.com',"password"=>'test321');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/client/add');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		if($data->success == true){
			$client = json_decode($data->client);
			$this->client_id = $client->id;
		}
		sleep(1);
	}
	public function testAddPorosi(){
		$data = array("client_id"=>$this->client_id,"pershkrimi"=>'Test add Porosi',"product_id"=>1234);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/porosi/add');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		if($data->success == true){
			$porosi = json_decode($data->porosi);
			$this->porosi_id = $porosi->id;
		}
		sleep(1);
	}
	public function testGetPaymentLink(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/paypal/link/'.$this->porosi_id.'?amount=50');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		sleep(1);
	}
	public function testConfirmPagese(){
		$this->assertTrue(true);
	}
	public function testCancelPagese(){
		$this->assertTrue(true);
	}
	public function testGetPorosi(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/porosi/'.$this->porosi_id);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		sleep(1);
	}

	public function testUpdatePorosi(){
		$data = array("status"=>1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/porosi/update/'.$this->porosi_id);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		sleep(1);
	}
	public function testDeletePorosi(){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/porosi/delete/'.$this->porosi_id);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		sleep(1);
	}
	public function testGetClient(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/client/'.$this->client_id);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		if($data->success){
			$this->client_email = $data->email;
		}
		sleep(1);
	}
	public function testUpdateClient(){
		$data = array("email"=>$this->client_email,'emri'=>'Test','mbiemri'=>'updated');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/client/update/');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		sleep(1);
	}
	public function testDeleteClient(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/v1/client/delete/'.$this->client_id);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$data = curl_exec($ch);
		$data=json_decode($data);
		$this->assertTrue($data->success);
		sleep(1);
	}
}
?>