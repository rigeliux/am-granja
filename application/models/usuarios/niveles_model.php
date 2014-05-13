<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Niveles_Model extends CI_Model
{
	public $fields;
	public $datos;

	function __construct()
	{
		parent::__construct();
		$this->fields = $this->initFields();
		$this->load->model('usuarios/rel_nivel_privsec_model', 'rel_privs');
	}

	public function initFields()
	{
		$datos = $this->input->post('nivel',TRUE);
		$fields = array(
			'database' => array(
					'table_name'=>'user_groups',
					'primary_key'=>'ugrp_id',
					'primary_key_post'=> $datos['id'],
					'name_key'=>'nombre',
					'name_key_post'=>$datos['nombre']
				),
			'crud' => array(
					'ugrp_name'	=> $datos['nombre'],
					'ugrp_desc'	=> $datos['desc'],
					'ugrp_admin'=> $datos['admin']
				),
			'fieldNames' => array(
					'ugrp_name'	=> 'Nombre',
					'ugrp_desc'	=> 'Descripcion',
					'ugrp_admin' => 'Admin'
				)
			);

		$this->datos = $datos;
		return $fields;
	}

	public function Grid()
	{
		$this->load->model('grid_model');

		$grid_gen = array(
			'SelectCommand'=>"SELECT ugrp_id,ugrp_name,ugrp_desc, if(ugrp_admin = 1,'Es admin','No es admin') as Admin FROM user_groups",
			'campos'=>array(
						array(
							'DataField' => 'ugrp_id',
							'HeaderText' => 'ID'
						),
						array(
							'DataField' => 'ugrp_name',
							'HeaderText' => 'NOMBRE NIVEL'
						),
						array(
							'DataField' => 'ugrp_desc',
							'HeaderText' => 'DESCRIPCION NIVEL'
						),
						array(
							'DataField' => 'Admin',
							'HeaderText' => 'ES ADMIN'
						)
				),
			'crud_buttons' => array(
					'campo_id' => 'ugrp_id',
					'campo_nombre' => 'ugrp_name'
				)
		);

		return $this->grid_model->init($grid_gen);
	}

	public function insertar()
	{
		$fields = $this->fields;
		$datos = $this->datos;

		$nombre = $fields['crud']['ugrp_name'];
		$descripcion = $fields['crud']['ugrp_desc'];
		$nivel = $fields['crud']['ugrp_admin'];

		$inserta = $this->flexi_auth->insert_group($nombre, $descripcion, $nivel);

		if($inserta) {
			$data['form']=$fields['crud'];
			$id = $this->db->insert_id();

			$args = array(
				'primary_key_post' => $id,//obteniendo la ultima insercion a la base de datos
				'datos' => $datos['privilegios']//obteniendo array de privilegios
			);

			$this->rel_privs->initialize($args);
			$data['form_priv'] = $this->rel_privs->insertar();
			return $data;
		} else {
			return false;
		}
	}

	public function editar()
	{
		$fields = $this->fields;
		$datos = $this->datos;
		$id = $fields['database']['primary_key_post'];
		$db_data = $this->datosInfo($fields['database']['primary_key_post']);

		$actualiza = $this->flexi_auth->update_group($id, $fields['crud']);

		if($actualiza) {
			
			$data['db']=$db_data;
			$args = array(
				'primary_key_post' => $id,//obteniendo la ultima insercion a la base de datos
				'datos' => $datos['privilegios']//obteniendo array de privilegios
			);

			$this->rel_privs->initialize($args);
			$data['form_priv'] = $this->rel_privs->insertar();
			$data['form']=$fields['crud'];
			return $data;
		}
		//echo print_r($actualiza,true);
		return false;
	}

	public function eliminar($id)
	{
		$fields = $this->fields;
		$db_data = $this->datosInfo($id);
		$elimina = $this->flexi_auth->delete_group($id);
		

		if($elimina) {

			$data['db']=$db_data;
			$data['form']=$fields['crud'];
			$this->rel_privs->eliminar($id);
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

		if($query) {
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
		$msgs['insertar']['exito']	= "El Nivel: <strong>".$args['form']['ugrp_name']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "El Nivel <strong>".$args['form']['ugrp_name']."</strong> actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "El Nivel <strong>".$args['form']['ugrp_name']."</strong> se eliminó con exito.<br>".formatResultDelete($args,$fields['fieldNames']);

		//.'<pre>'.print_r($args,true).'</pre>'
		return $msgs;
	}
}