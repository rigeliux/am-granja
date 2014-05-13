<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilegios_Model extends CI_Model
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
		$datos = $this->input->post('privilegio',TRUE);
		$fields = array(
			'database' => array(
					'table_name'=>'user_privileges',
					'primary_key'=>'upriv_id',
					'primary_key_post'=> $datos['id'],
					'name_key'=>'nombre',
					'name_key_post'=>$datos['nombre']
				),
			'crud' => array(
					'upriv_name'	=> $datos['nombre'],
					'upriv_desc'	=> $datos['descripcion']
				),
			'fieldNames' => array(
					'upriv_name'	=> 'Nombre',
					'upriv_desc'	=> 'Descripción'
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
								*
							FROM
								user_privileges",
			'campos'=>array(
						array(
							'DataField' => 'upriv_id',
							'HeaderText' => 'ID'
						),
						array(
							'DataField' => 'upriv_name',
							'HeaderText' => 'NOMBRE PRIVILEGIO'
						),
						array(
							'DataField' => 'upriv_desc',
							'HeaderText' => 'DESCRIPCION'
						)
				),
			'crud_buttons' => array(
					'campo_id' => 'upriv_id',
					'campo_nombre' => 'upriv_name'
				)
		);

		return $this->grid_model->init($grid_gen);
	}
	
	public function insertar()
	{
		$fields = $this->fields;


		$nombre = $fields['crud']['upriv_name'];
		$description = $fields['crud']['upriv_desc'];
		

		$inserta = $this->flexi_auth->insert_privilege($nombre, $description);
	
		if($inserta) {
			$data['db']=$db_data;
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
		$user_id = $fields['database']['primary_key_post'];

		$actualiza = $this->flexi_auth->update_privilege($user_id, $fields['crud']);

		if($actualiza) {
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
		$elimina = $this->flexi_auth->delete_privilege($id);
		
		if($elimina) {
			$data['db']=$db_data;
			$data['form']=$fields['crud'];
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
		$msgs['insertar']['error']	= "Hubo un problema al registrar, intente nuevamente.".$this->flexi_auth->get_messages();
		$msgs['editar']['error']	= "Hubo un problema al registrar, intente nuevamente.".$this->flexi_auth->get_messages();
		$msgs['eliminar']['error']	= "Hubo un problema al eliminar, intente nuevamente.".$this->flexi_auth->get_messages();
		$msgs['insertar']['exito']	= "El Privilegio: <strong>".$args['form']['upriv_name']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "El Privilegio actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "El Privilegio <strong>".$args['form']['upriv_name']."</strong> se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);

		//.'<pre>'.print_r($args,true).'</pre>'
		return $msgs;
	}
}