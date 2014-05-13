<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importar extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();	
		//$this->load->model($this->constantData['ruta_modelo'],'',TRUE);
	}

	public function index()
	{
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['ver'];
		/**************************************************************
			Si quisieramos que una seccion tenga un titulo diferente:
			$data['titulo'] = 'Titulo de la seccion';
			$this->constantData['titulo'] = 'Titulo de la pagina';
		**************************************************************/
		$data['titulo'] = $this->constantData['titulo'] = 'Importar desde Excel';
		$this->viewAdmin('comunes/top', $this->constantData);
		//if($this->flexi_auth->is_privileged($nivel)){

			//$data = (count($data)>0 ? array_merge($this->$modelo->Grid(),$data):$this->$modelo->Grid());
			if($data){
				//$content['msg']= $this->viewAdmin('comunes/grid', $data, TRUE);
				$this->viewAdmin($this->constantData['ruta'].'/base',$content);
			}
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom');
	}

	public function test()
	{
		$this->load->library('Productos_updater');
		$test = $this->productos_updater->init('D:\/Respaldos\/Rigel\/htdocs\/aromania\/assets\/upload\/993f3dd2c6da00dd0fc1764f9f614f3e.xls');
		 
		 echo '<pre>'.print_r($test,true).'</pre>';
		
	}
	public function agregar()
	{
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['insertar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		
		$row['constant']=$this->constantData;
		$this->viewAdmin($this->constantData['ruta'].'/add',$row);
	}

	public function editar($id)
	{
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row['constant']=$this->constantData;
		$row['data'] = $this->$modelo->datosInfo($id);
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
		}
	}
}

/* End of file importar.php */
/* Location: ./application/controllers/admin/productos/importar.php */