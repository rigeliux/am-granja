<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Us_test extends Admin_Controller {
	var $clase;
	var $ruta;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('UsuariosModel','',TRUE);
		$this->clase = $this->router->fetch_class();
		$this->ruta = $this->router->fetch_directory().$this->router->fetch_class();
	}
	
	public function index(){
		$inserta = $this->UsuariosModel->insertar_admin();
		if(!$inserta){
			$json['error'] = 1;
			$json['msg'] = 'Error';
			$json['titulo'] = 'Error al insertar';
			$json['desc'] = $this->flexi_auth->get_messages();;
		} else {
			$json['error'] = 0;
			$json['msg'] = ucfirst($seccion).' registrado con exito';
			$json['desc'] = 'Todo bien';
			//$json['extra'] = $inserta[0];
		}
		$html = '<pre>'.print_r($json,true).'</pre>';
		$this->output->append_output($html);
	}
	
}

/* End of file usuarios.php */
/* Location: ./application/controllers/admin/usuarios.php */