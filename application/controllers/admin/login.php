<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller {
	
	public function __construct(){
		parent::__construct();
		if ( $this->flexi_auth->is_logged_in() ){
			redirect('admin/home');
		}
	}
	public function index(){
		
		$data['title'] = 'Sistma Integral de Administración';
		$this->load->view('admin/login/top', $data);
		//print_r($this->db->conn_id);
	    $this->load->view('admin/login/login');
		$this->load->view('admin/login/footer');
	}

	private function _add_admin(){
		$this->load->model('usuarios/listado_model','listado_model');

		$this->listado_model->insertar_admin();

	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */