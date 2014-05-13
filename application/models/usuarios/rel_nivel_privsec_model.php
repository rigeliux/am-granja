<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rel_Nivel_Privsec_Model extends CI_Model
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
		$fields = array(
			'database' => array(
					'table_name'=>'user_privilege_groups',
					'primary_key'=>'upriv_groups_ugrp_fk',
					'primary_key_post'=>'',//id del grupo
					'rel_key'=>'upriv_groups_upriv_fk',
					'rel_key_post'=>''//id de la seccion
				)//,

			/*'crud' => array(
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
				*/
			);

		return $fields;
	}

	public function initialize($args=array())
	{
		$this->fields['database']['primary_key_post']=$args['primary_key_post'];
		$this->fields['database']['rel_key_post']=$args['rel_key_post'];
		$this->fields['crud'] = $this->getDatos($args['datos']);
	}

	public function getDatos($args)
	{
		$secNivel = array();
		foreach ($args as $secId => $value ) {
			foreach ($value as $privId) {
				 $info = array(
					'upriv_groups_ugrp_fk' => $this->fields['database']['primary_key_post'] ,
					'upriv_groups_upriv_fk' => $privId,
					'upriv_groups_usect_fk' => $secId
				);
				$secNivel[] = $info;				
			}
		}

		return $secNivel;
	}

	function insertar()
	{	
		$fields = $this->fields;
		$this->db->where($fields['database']['primary_key'], $fields['database']['primary_key_post']);
		$this->db->delete($fields['database']['table_name']); 

		$inserta = $this->db->insert_batch($fields['database']['table_name'], $fields['crud']);

		if($inserta) {
			return true;
		} else {
			return false;
		}
		
		return $this->fields['crud'];
	}

	/*public function editar($id)
	{
		$fields = $this->fields;
		$this->db->where($fields['database']['primary_key'], $id);
		$this->db->delete($fields['database']['table_name']); 

		$editar = $this->db->insert_batch($fields['database']['table_name'], $fields['crud']);

		if($editar) {
			return true;
		} else {
			return false;
		}
		
		return $this->fields['crud'];
	}*/

	public function eliminar($id)
	{
		$fields = $this->fields;
		$this->db->where($fields['database']['primary_key'], $id);
		$elimina = $this->db->delete($fields['database']['table_name']); 

		if($elimina) {
			return true;
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
			return $query->result_array();
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
		$fields = $this->inserts;
		$msgs = array();
		$msgs['insertar']['error']	= "Hubo un problema al registrar, intente nuevamente.".$this->flexi_auth->get_messages();
		$msgs['editar']['error']	= "Hubo un problema al registrar, intente nuevamente.".$this->flexi_auth->get_messages();
		$msgs['eliminar']['error']	= "Hubo un problema al eliminar, intente nuevamente.".$this->flexi_auth->get_messages();
		$msgs['insertar']['exito']	= "El Usuario: <strong>".$args['form']['upro_name']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "El Usuario actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "El Usuario <strong>".$args['form']['upro_name']."</strong> se eliminó con exito.<br>".formatResultDelete($args,$fields['fieldNames']);

		//.'<pre>'.print_r($args,true).'</pre>'
		return $msgs;
	}
}