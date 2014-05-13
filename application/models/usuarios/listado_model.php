<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado_Model extends CI_Model
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
		$datos = $this->input->post('usuarios',TRUE);
		$fields = array(
			'database' => array(
					'table_name'=>'user_accounts',
					'primary_key'=>'id',
					'primary_key_post'=> $datos['id'],
					'name_key'=>'nombre',
					'name_key_post'=>$datos['nombre']
				),
			'crud' => array(
					'uacc_group_fk'	=> $datos['nivel'],
					'uacc_username'	=> $datos['usuario'],
					'upro_uacc_fk'	=> $datos['id'],
					'upro_name'		=> $datos['nombre']
				),
			'fieldNames' => array(
					'uacc_group_fk'	=> 'Nivel',
					'uacc_username'	=> 'Usuario',
					'upro_name'		=> 'Nombre'
				)
			);

		if($datos['pass'] != ""){
			$fields['crud']['uacc_password'] = $datos['pass'];
		}

		$this->datos = $datos;
		return $fields;
	}

	public function Grid()
	{
		$this->load->model('grid_model');
		
		$grid_gen = array(
			'SelectCommand'=>"SELECT
								t1.uacc_id,
								t1.uacc_username,
								t2.upro_name,
								t3.ugrp_name
							FROM
								user_accounts AS t1
							INNER JOIN user_profiles AS t2 ON t1.uacc_id = t2.upro_uacc_fk
							INNER JOIN user_groups AS t3 ON t1.uacc_group_fk = t3.ugrp_id ",
			'campos'=>array(
						array(
							'DataField' => 'uacc_id',
							'HeaderText' => 'ID'
						),
						array(
							'DataField' => 'uacc_username',
							'HeaderText' => 'USERNAME'
						),
						array(
							'DataField' => 'upro_name',
							'HeaderText' => 'NOMBRE'
						),
						array(
							'DataField' => 'ugrp_name',
							'HeaderText' => 'NIVEL'
						)
				),
			'crud_buttons' => array(
					'campo_id' => 'uacc_id',
					'campo_nombre' => 'upro_name'
				)
		);

		return $this->grid_model->init($grid_gen);
	}
	
	public function insertar()
	{
		$fields = $this->fields;

		$nombre = $fields['crud']['upro_name'];
		$nivel = $fields['crud']['uacc_group_fk'];
		$usuario = $fields['crud']['uacc_username'];
		$pass = $fields['crud']['uacc_password'];
		$user_data = array(
			'upro_name' => $nombre,
			'upro_phone'=>'',
			'upro_newsletter'=>''
		);
		
		$inserta = $this->flexi_auth->insert_user($nombre.'@mail.com', $usuario, $pass, $user_data, $nivel, true);
	
		if($inserta) {
			$data['form'] = $fields['crud'];
			return $data;
		} else {
			return false;
		}
	}

	public function editar()
	{
		$fields = $this->fields;
		$user_id = $fields['database']['primary_key_post'];
		$actualiza = $this->flexi_auth->update_user($user_id, $fields['crud']);

		if($actualiza) {
			$data['db']=$this->flexi_auth->get_user_by_id($user_id)->row_array();
			$data['form'] = $fields['crud'];
			
			return $data;
		} else {
			return false;
		}
		
	}

	public function eliminar($id)
	{
		$fields = $this->fields;
		$db_data = $this->datosInfo($id);
		$elimina = $this->flexi_auth->delete_user($id);

		
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
		
		$this->db->where('uacc_id', $id);
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
		$msgs['insertar']['exito']	= "El Usuario: <strong>".$args['form']['upro_name']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "El Usuario <strong>".$args['form']['upro_name']."</strong> actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "El Usuario <strong>".$args['form']['upro_name']."</strong> se eliminó con exito.<br>".formatResultDelete($args,$fields['fieldNames']);

		//.'<pre>'.print_r($args,true).'</pre>'
		return $msgs;
	}
}