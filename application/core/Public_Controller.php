<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('productos/web_listado_model');
	}

	public function recorrerListado($eslistado=true,$cantidad,$ancho)
	{
		$data['ancho'] = "col-md-".$ancho;
		$midato = $this->query;
		if (!$eslistado) {
			$midato = $this->web_listado_model->getRandProductoMarca($cantidad);
		}

		foreach ($midato->result() as $producto) {
			$data['miProducto']=$producto;
			$newhtml = $this->load->view('inventario/listadoindividual', $data, true);
			$html .= $newhtml;
		}

		return $html;
	}
}