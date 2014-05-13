<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('siteUrlAdmin'))
{
    function siteUrlAdmin($seccion='')
    {
        $CI =& get_instance();
        $sect = ($seccion!='' ? $seccion:$CI->constantData['ruta']);
        $url = site_url('admin/'.$sect);
        return $url;
    }
}

if (!function_exists('base_url_admin'))
{
    function base_url_admin($seccion='')
    {
        $CI =& get_instance();
        $sect = ($seccion!='' ? $seccion:$CI->constantData['ruta']);
        $url = base_url('admin/'.$sect);
        return $url;
    }
}

/**
 * RESULTADOS DE CRUD
 * Funciones para devolver la respuesta de de actualización mostrando los cambios.
 */

/**
 * [createArrayDbJoins description]
 * @param  Array $table_rel [description]
 * @return Array            [description]
 */
if (!function_exists('createArrayForDbJoins')) {
    function createArrayForDbJoins($table_rel,$fields)
    {
        $fk_table = $table_rel['table_name'];
        $fk_field = $fk_table.'.'.$table_rel['fk'];
        $fk_fields = explode(',',$table_rel['dataFields']);

        $lc_table = $fields['database']['table_name'];
        $lc_field = $lc_table.'.'.(!isset($table_rel['lc']) ? $table_rel['fk']:$table_rel['lc']);

        $join_type = (!isset($table_rel['join']) ? 'inner':$table_rel['join']);
        $join_text = $fk_field.' = '.$lc_field;
        $join_fields = implode($fk_table.'.', $fk_fields);

        $relacion=array(
                'table_name'=> $fk_table,
                'join'      => $join_text,
                'type'      => $join_type,
                'fields'    => $join_fields
            );

        return $relacion;
    }
}

if (!function_exists('returnFieldByCommas')) {
    function returnFieldByCommas($data=array(),$campo)
    {
        $campos = array();
        foreach ($data as $field) {
            $campos[] = $field[$campo];
        }

        return implode(',',$campos);
    }
}

if (!function_exists('formatResultInsert')) {
    function formatResultInsert($data,$fieldNames)
    {
        $table = formatInfo($data,$fieldNames,false,false);

        return formatTableDisplay(array($table));
    }
}

if (!function_exists('formatResultUpdate')) {
    function formatResultUpdate($data,$fieldNames)
    {
        
        $table_l = formatInfo($data,$fieldNames);
        $table_r = formatInfo($data,$fieldNames,false);

        return formatTableDisplay(array($table_l,$table_r));
    }
}

if (!function_exists('formatResultDelete')) {
    function formatResultDelete($data,$fieldNames)
    {
        
        $table = formatInfo($data,$fieldNames,true,false);

        return formatTableDisplay(array($table));
    }
}

if (!function_exists('formatInfo')) {
    function formatInfo($data,$fieldNames,$esAntes=true,$printTitle=true)
    {
        $row;
        $campo = 'db';
        $titulo = 'Antes';
        if (!$esAntes) {
            $campo = 'form';
            $titulo = 'Despues';
        }

        if (!$printTitle) {
            $titulo = '';
        }

        foreach ($data[$campo] as $key => $value) {
            if (array_key_exists($key, $fieldNames)) {
                $table_row = "<td><strong>$fieldNames[$key]</strong></td><td>$value</td>";
                $row.="<tr>$table_row<tr>";
            }
        }

        $table = formatTableInfo($titulo,$row);

        return formatTableDisplay(array($table));
    }
}

if (!function_exists('formatTableInfo')) {
    function formatTableInfo($titulo,$rows)
    {
        $table= "
        <table class='table table-bordered table-condensed'>
            <caption><h5>$titulo</h5></caption>
            <tbody>
                $rows
            </tbody>
        </table>";

        return $table;
    }
}

if (!function_exists('formatTableDisplay')) {
    function formatTableDisplay($tablas)
    {
        foreach ($tablas as $tabla) {
            $tab.='<td>'.$tabla.'</td>';
        }
        $table= "
        <table>
            <tbody>
                <tr>
                    $tab
                </tr>
            </tbody>
        </table>";

        return $table;
    }
}

/**
 * FIN DE FUNCIONES CRUD
 */

/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */