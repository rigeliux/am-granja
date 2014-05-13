<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('basic_crud_buttons')) {
    function basic_crud_buttons($args=array())
    {
    	$CI =& get_instance();
    	$modelo = $CI->constantData['modelo'];

    	$fields = $CI->$modelo->fields;

        $base_url = base_url_admin($CI->constantData['ruta']);

        $href_edit = "$base_url/editar/$args[id]?randNum=".microtime(true);
        $identificador = array(
        		'id'	=> $args['id'],
        		'nombre'=> $args['nombre'],
        		'seccion'=> $fields['database']['table_name']

        	);
        $json_data = json_encode($identificador);

        $buttons = "<div class='btn-toolbar'><div class='btn-group'>";
		$buttons.=	"<a href='$href_edit' class='btn btn-round editar nofollow' title='Editar'><i class='fa fa-pencil-square-o fa-lg'></i></a>";
		$buttons.= 	"<a href='#' rel='nofollow' data-identificador='$json_data' class='btn btn-round eliminar nofollow'><i class='fa fa-minus-square-o fa-lg'></i></a>";
		$buttons.= "</div></div>";

		return $buttons;
    }
}

if (!function_exists('rating')) {
    function rating($jsonVar)
    {
        $ent = json_decode($jsonVar);

        $entero = intval($ent->entero);
        $whites = 5-$entero;
        
        $texto;
        for($i=1;$i<=$entero;$i++){
            $texto.='<img src="assets/images/admin/star-on.png">';
        }
        for($i=1;$i<=$whites;$i++){
            $texto.='<img src="assets/images/admin/star-off.png">';
        }
        return $texto;
        //return print_r($ent,true);
    }
}

if (!function_exists('imageZoom')) {
    function imageZoom($jsonVar)
    {
        $var = json_decode($jsonVar);
        $nombre = $var->nombre;
        $tipo   = $var->tipo;
        $thumb   = $var->thumb;
        $big    = $var->big;
        
        $template = "<a href='assets/images/$tipo/$big/$nombre' class='fancy high-img'><img src='assets/images/$tipo/$thumb/$nombre' ></a>";
        return $template;
        //return print_r($ent,true);
    }
}


/* End of file grid_helper.php */
/* Location: ./application/helpers/grid_helper.php */