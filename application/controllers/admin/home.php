<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->constantData[titulo] = 'Inicio';
		$this->constantData[usuario] = $this->flexi_auth->get_user_by_id_row_array();
		
		$data['constant'] =$this->constantData;
		$this->load->view('admin/comunes/top', $this->constantData);
		$this->load->view('admin/inicio/dashboard',$data);
		$this->load->view('admin/comunes/bottom');
	}
	
	public function e_403(){
		$this->viewAdmin('comunes/top', $this->constantData);
		$this->viewAdmin('error/403');
		$this->viewAdmin('comunes/bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */