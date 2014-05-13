<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $constantData;

	public function __construct()
	{
		parent::__construct();
		$this->constantData['getActionControl']['controller'] = $this->router->fetch_class();
		$this->constantData['getActionControl']['action'] = $this->router->fetch_method();
		$this->constantData['site_name'] = ' | Autos Fiesta';
	}
}