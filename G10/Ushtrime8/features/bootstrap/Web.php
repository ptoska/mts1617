<?php

require __DIR__.'/../../vendor/autoload.php';
class Web
{
	protected $driver;
    protected $session;
    protected $page;

	function __construct()
	{
		$key = '89051498897c8c845169d41e6e02958e';
        $secret = '7bb546510e8762f4889dbe109d1e7c61';
        
        $testingBotApiUrl = "http://{$key}:{$secret}@hub.testingbot.com/wd/hub";
         
        $this->driver = new \Behat\Mink\Driver\Selenium2Driver('chrome',
            array("platform"=>"WINDOWS", "browserName"=>"chrome", "name" => "ToodledoTest"), $testingBotApiUrl);
        $this->session = new \Behat\Mink\Session($this->driver);
        $this->session->start();
	}
	public function visit($url){
		$this->session->visit($url);
        
        $this->page = $this->session->getPage();
	}
	public function fillField($name,$value){
		$this->page->fillField($name, $value);
	}
	public function checkField($selector){
		$this->page->find('css', $selector)->check();
	}
	public function clickButton($selector){
		$this->page->find('css', $selector)->click();
	}
	public function hasContet($content){
		return $this->session->getPage()->hasContent($content);
	}
	public function submitForm($selector){
		$this->page->find("css", $selector)->submit();
	}
	public function pressButton($selector){
		$this->page->pressButton($selector);
	}
	public function closeConnection(){
		$this->session->reset();
        $this->session->stop();
	}
}