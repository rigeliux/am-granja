<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secciones_Model extends CI_Model
{
	public $fields;
	public $datos;

	function __construct()
	{
		parent::__construct();
		$this->fields = $this->initFields();
	}

	public function initFields()
	{
		$datos = $this->input->post('seccion',TRUE);
		$fields = array(
			'database' => array(
					'table_name'=>'user_sections',
					'primary_key'=>'usec_id',
					'primary_key_post'=> $datos['id'],
					'name_key'=>'nombre',
					'name_key_post'=>$datos['nombre']
				),
			'crud' => array(
					'usec_name'	=> $datos['nombre']
				),
			'fieldNames' => array(
					'usec_name'	=> 'Nombre'
				)
			);

		$this->datos = $datos;
		return $fields;
	}

	public function Grid()
	{
		$this->load->model('grid_model');
		
		$grid_gen = array(
			'SelectCommand'=>"SELECT
								usec_id,
								usec_name
							FROM
								user_sections",
			'campos'=>array(
						array(
							'DataField' => 'usec_id',
							'HeaderText' => 'ID'
						),
						array(
							'DataField' => 'usec_name',
							'HeaderText' => 'SECCION'
						)
				),
			'crud_buttons' => array(
					'campo_id' => 'usec_id',
					'campo_nombre' => 'usec_name'
				)
		);

		return $this->grid_model->init($grid_gen);
	}

	public function insertar()
	{
		$fields = $this->fields;
		$inserta = $this->db->insert($fields['database']['table_name'], $fields['crud']);
		
		if($inserta){
			$data['form']=$fields['crud'];
			return $data;
		} else {
			return false;
		}
	}

	public function editar()
	{
		$fields = $this->fields;
		$db_data = $this->datosInfo($fields['database']['primary_key_post']);
		
		$this->db->where($fields['database']['primary_key'], $fields['database']['primary_key_post']);
		$actualiza = $this->db->update($fields['database']['table_name'], $fields['crud']);

		if($actualiza){
			$data['db']=$db_data;
			$data['form']=$fields['crud'];
			
			return $data;
		} else {
			return false;
		}
	}

	public function eliminar($id)
	{
		$fields = $this->fields;
		$db_data = $this->datosInfo($id);

		$this->db->where($fields['database']['primary_key'], $id);
		$elimina = $this->db->delete($fields['database']['table_name']);

		if($elimina) {
			$data['db']=$db_data;
			return $data;
		} else {
			return false;
		}
	}

	public function datosInfo($id)
	{
		$fields = $this->fields;
		
		$this->db->where($fields['database']['primary_key'], $id);
		$query = $this->db->get($fields['database']['table_name']);
		
		if($query) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function getDatosTabla()
	{
		$fields = $this->fields;
		$query = $this->db->get($fields['database']['table_name']);
		
		if($query) {
			return $query;
		} else {
			return false;
		}
	}

	public function getDatosByParam($nombre_campo,$valor="")
	{
		$fields = $this->fields;

		if($valor != "") {
			$this->db->where($nombre_campo,$valor);
		}
		
		$query = $this->db->get($fields['database']['table_name']);

		if($query){
			return $query;
		} else {
			return false;
		}
	}

	public function messages($args = array())
	{
		$fields = $this->fields;
		$msgs = array();
		$msgs['insertar']['error']	= "Hubo un problema al registrar, intente nuevamente.";
		$msgs['editar']['error']	= "Hubo un problema al registrar, intente nuevamente.";
		$msgs['eliminar']['error']	= "Hubo un problema al eliminar, intente nuevamente.";
		$msgs['insertar']['exito']	= "La sección: <strong>".$args['form']['usec_name']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "La sección actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "La sección se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);

		//.'<pre>'.print_r($args,true).'</pre>'
		return $msgs;
	}
}