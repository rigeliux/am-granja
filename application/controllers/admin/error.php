<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function e_403(){
		$this->load->view('admin/comunes/top', $this->constantData);
		$this->load->view('admin/error/403');
		$this->load->view('admin/comunes/bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */