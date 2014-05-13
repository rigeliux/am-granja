<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slides extends Admin_Controller {
	var $ruta_array = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->model($this->constantData['ruta_modelo'],'',TRUE);

		regiter_css('uploadifive');
		regiter_script(array('jquery.uploadifive','catalogos'));
	}
	
	public function index(){

		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['ver'];
		/**************************************************************
			Si quisieramos que una seccion tenga un titulo diferente:
			$data['titulo'] = 'Titulo de la seccion;
			$this->constantData['titulo'] = 'Titulo de la pagina';
		**************************************************************/
		$this->constantData['botones_r']['agregar']['text'] = 'Agregar Slide';
		$this->viewAdmin('comunes/top', $this->constantData);
		
		//if($this->flexi_auth->is_privileged($nivel)){

			$this->constantData['gridd']=$this->$modelo->Grid();
			$content['grid']= $this->viewAdmin('comunes/grid', $this->constantData, TRUE);
			$content['constantData'] = $this->constantData;
			$this->viewAdmin('comunes/contenido',$content);

			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom');
	}
	
	
	public function agregar(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['insertar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		
		$row['constant']=$this->constantData;
		$this->viewAdmin($this->constantData['padre'].'/add',$row);
	}
	
	public function editar($id){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		
		$row['data']	= $this->$modelo->datosInfo($id);
		$row['constant']=$this->constantData;
		if($row){
			$this->viewAdmin($this->constantData['padre'].'/edit',$row);
		}
	}
	
}

/* End of file banners.php */
/* Location: ./application/controllers/admin/banners.php */