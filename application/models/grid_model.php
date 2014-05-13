<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grid_Model extends CI_Model {
	public $grid;
	public $koolajax;
	public $ds_datos;
	public $model_fields;

	public function __construct()
	{
		$modelo = $this->constantData['modelo'];
    	$this->model_fields = $this->$modelo->fields;

		$KoolControlsFolder = 'assets/class/KoolControls';
		
		require $KoolControlsFolder.'/KoolAjax/koolajax.php';
		$koolajax->scriptFolder = $KoolControlsFolder.'/KoolAjax';
		require $KoolControlsFolder.'/KoolGrid/koolgrid.php';
		
		$ds_datos = new MySQLDataSource($this->db->conn_id);

		$grid = new KoolGrid("grid");
		$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
		$grid->styleFolder="office2010blue";
		$grid->Width = "100%";
		$grid->PageSize = "10";
		$grid->RowAlternative = true;
		$grid->AjaxEnabled = true;
		$grid->AjaxLoadingImage =  $KoolControlsFolder."/KoolAjax/loading/4.gif";
		
		$grid->ColumnWrap = true;
		$grid->AllowSorting = true;
		$grid->AllowEditing = true;
		$grid->AllowDeleting = true;
		$grid->AllowSelecting = false;
		$grid->AllowResizing = true;
		$grid->AllowHtmlRender = true; 
		$grid->AllowFiltering = true;
		$grid->AllowScrolling = true;
		$grid->KeepSelectedRecords = true;

		
		$grid->ClientSettings->ClientEvents["OnInit"] = "Handle_OnInit";
		$grid->ClientSettings->ClientEvents["OnLoad"] = "Handle_OnInit";
	
		
		$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
		$grid->MasterTable->Pager->ShowPageSize = TRUE;

		$grid->Localization->Load($KoolControlsFolder."/KoolGrid/localization/es.xml");

		$this->koolajax = $koolajax;
		$this->ds_datos = $ds_datos;
		$this->grid = $grid;
	}

	/*
	Base y configuración básica del GRID
	 */
	public function init($args=array())
	{
		$grid = $this->grid;

		$this->ds_datos->SelectCommand = $args['SelectCommand'];
		$this->generate_columns($args['campos']);
		$this->generate_crud_column($args);
		
		$grid->DataSource = $this->ds_datos;

		$grid->Process();
		
		$data['koolajax']=$this->koolajax;
		$data['grid']=$grid;
		return $data;
	}

	private function generate_columns($campos)
	{
		foreach($campos as $campo)
		{
			$column = $this->getColumnType($campo);
			$column->DataField = $campo['DataField'];
			$column->HeaderText = $campo['HeaderText'];
			$column->HeaderStyle->Align = "center";
			$column->CssClass = "c10";
			$column->Width = "120px";
			$column->Filter = array("Exp"=>"Contain");

			$this->grid->MasterTable->AddColumn($column);
		}
	}

	private function generate_crud_column($args=array())
	{
		$model_fields = $this->model_fields;

		$campo_id = $model_fields['database']['primary_key'];
		$campo_nombre = $model_fields['database']['name_key'];

		if (isset($args['crud_buttons']) && isset($args['crud_buttons']['campo_id'])) {
			$campo_id = $args['crud_buttons']['campo_id'];
		}

		if (isset($args['crud_buttons']) && isset($args['crud_buttons']['campo_nombre'])) {
			$campo_nombre = $args['crud_buttons']['campo_nombre'];
		}

		$column = new GridCalculatedColumn();
		$column->Expression = "basic_crud_buttons( array('id'=>{".$campo_id."},'nombre'=>'{".$campo_nombre."}') )";
		$column->Align = "center";
		$column->CssClass = "c20";
		$column->Width = "200px";
		$column->AllowResizing = false;
		$column->AllowFiltering = false;
		$column->AllowSorting = false;
		$this->grid->MasterTable->AddColumn($column);

	}

	private function getColumnType($campo)
	{
		switch ($campo['columnType']) {
			case 'GridCalculatedColumn':
				$expresionValues = $this->getExpresionValues($campo);

				$column = new GridCalculatedColumn();
				$column->Expression = "{$campo[expresionFunction]}( '{$expresionValues}' )";
				break;
			
			default:
				$column = new GridBoundColumn();
				break;
		}

		return $column;
	}

	private function getExpresionValues($campo)
	{
		$expresionValues = $campo['DataField'];
		if (isset($campo['expresionValues'])) {
			$expresionValues = json_encode($campo['expresionValues']);
		}

		return $expresionValues;
	}
}