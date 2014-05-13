<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('regiter_script')) {
    function regiter_script($name)
    {
        $CI =& get_instance();
        if(!is_array($name))
        {
            if(!in_array($name, $CI->constantData['scripts']))
            {
                $CI->constantData['scripts'][]=$name;
            }
        }
        else
        {
            foreach($name as $script)
            {
                if(!in_array($script, $CI->constantData['scripts']))
                {
                    $CI->constantData['scripts'][]=$script;
                }
            }
        }
    }
}

if (!function_exists('regiter_css')) {
    function regiter_css($name)
    {
        $CI =& get_instance();
        if(!is_array($name))
        {
            if(!in_array($name, $CI->constantData['css']))
            {
                $CI->constantData['css'][]=$name;
            }
        }
        else
        {
            foreach($name as $css)
            {
                if(!in_array($css, $CI->constantData['css']))
                {
                    $CI->constantData['css'][]=$css;
                }
            }
        }
        
    }
}

if (!function_exists('registred_script')) {
    function registred_script(array &$array)
    {
        $t='';
        foreach($array as $k=>$v)
        {
           $t.= "<script src='assets/js/$v.js' type='text/javascript'></script>";
        }
        return $t;
    }
}

if (!function_exists('registred_css')) {
    function registred_css(array &$array)
    {
        $t='';
        foreach($array as $k=>$v)
        {
           $t.= "<link rel='stylesheet' href='assets/css/$v.css'>";
        }
        return $t;
    }
}

/**
* [getId description]
* @param  string $string [description]
* @return [type] [description]
*/
if (!function_exists('getId')) {
	function getId($string)
	{
		$id = $string;
		if (!is_numeric($string)) {
			$id = explode('-',$string);
			$id = $id[1];
		}
		return $id;
	}
}

/**
 * [nl2p description]
 * @param  string  $string      [description]
 * @param  boolean $line_breaks [description]
 * @param  boolean $xml         [description]
 * @return [type] [description]
 */
if (!function_exists('nl2p')) {
	function nl2p($string, $line_breaks = true, $xml = true)
	{
		$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

		// It is conceivable that people might still want single line-breaks
		// without breaking into a new paragraph.
		if ($line_breaks == true)
		    return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
		else 
		    return '<p>'.preg_replace(
		    				array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
		    				array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),
							trim($string)).'</p>';
	}
}

/**
* [nl2li description]
* @param  string $string [description]
* @return [type] [description]
*/
if (!function_exists('nl2li')) {
	function nl2li($string)
	{
		$string = '<li>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li>"),trim($string,"\n\r")).'</li>';
		return $string;
	}
}

/**
 * [getStamp description]
 * @return [type] [description]
 */
if (!function_exists('getStamp')) {
    function getStamp(){
        list($Mili, $bot) = explode(" ", microtime());
        $DM=substr(strval($Mili),2,4);
        return strval(date("Y").date("m").date("d").date("H").date("i").date("s") );
    }
}


/**
 * [getHref description]
 * @param  string $seccion [description]
 * @return [type] [description]
 */
if (!function_exists('getHref')) {
	function getHref($seccion=null)
	{
		$CI =& get_instance();
		
		$href = (!is_null($seccion) ? $seccion:'');

		if ($CI->session->flashdata('page')) {
			$page	= $CI->session->flashdata('page');
			$getvars= $CI->session->flashdata('getvars');
			$coming = $CI->session->flashdata('coming');

			$href = $coming;
			if ($page!='' && $page!=1 ) {
				$href.='/pag/'.$page;
			}

			if ($getvars!='' && $getvars!=1 ) {
				$href.='?'.$page;
			}

			$CI->session->keep_flashdata('page');
			$CI->session->keep_flashdata('getvars');
			$CI->session->keep_flashdata('coming');
		}

		return $href;
	}
}

/**
 * [getSlug description]
 * @param  string $input [description]
 * @return [type] [description]
 */
if (!function_exists('getSlug')) {
	function getSlug($input)
	{
		setlocale(LC_ALL, 'en_US.UTF-8');
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $input);
		$clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
		$clean = trim($clean, '_');
		$clean = preg_replace("/[\/_| -]+/", '_', $clean);
		$clean = strtolower($clean);
		return $clean;
	}
}

/**
 * [cleanString description]
 * @param  string $string [description]
 * @return [type] [description]
 */
if (!function_exists('cleanString')) {	
	function cleanString($string)
	{
		$string = preg_replace('/[\_\-]/', '', $string);
		$string = preg_replace('/\s[\s]+/', '_', $string);
		$string = preg_replace('/[\s]+/', '_', $string);
		$string = preg_replace('/[\W]+/','',$string); 
		$string = preg_replace('/^[\-]+/','',$string);
		$string = preg_replace('/[\-]+$/','',$string);
	    return $string;
	}
}

/**
 * [stripHtmlTags description]
 * @param  string $text [description]
 * @return [type] [description]
 */
if (!function_exists('stripHtmlTags')) {	
	function stripHtmlTags($text)
	{
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
				// Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',"$0", "$0", "$0", "$0", "$0", "$0","$0", "$0",),
			$text
		);

		// you can exclude some html tags here, in this case B and A tags
		$text = str_replace('<br />',' ',$text);
		$text = str_replace('<br>','_',$text);
		$text = removeWhiteSpace($text);
		return strip_tags( $text );
	}
}

/**
 * [removeWhiteSpace description]
 * @param string $text [description]
 * @return [type] [description]
 */
if (!function_exists('removeWhiteSpace')) {
	function removeWhiteSpace($text)
	{
		return preg_replace('/(\s)+/', ' ', $text);
	}
}

/**
 * [clean_number description]
 * @param  string $number [description]
 * @return int         [description]
 */
if (!function_exists('clean_number')) {
    function clean_number($number)
    {
        $numero = preg_replace("/[^0-9]/","",$number);
        return $numero;
    }
}

/**
 * [transformaOp description]
 * @param  string $string [description]
 * @param  string $valor  [description]
 * @return [type] [description]
 */
if (!function_exists('transformaOp')) {
	function transformaOp($string,$valor)
	{
		switch($string){
			case "Equal": $cadena = "='$valor'"; break;
			case "Not_Equal": $cadena = "!='$valor'"; break;
			case "Greater_Than": $cadena = ">'$valor'"; break;
			case "Less_Than": $cadena = "<'$valor'"; break;
			case "Greater_Than_Or_Equal": $cadena = ">='$valor'"; break;
			case "Less_Than_Or_Equal": $cadena = "<='$valor'"; break;
			case "Contain": $cadena = " LIKE '%$valor%'"; break;
			case "Not_Contain": $cadena = " NOT LIKE '$valor'"; break;
			case "Start_With": $cadena = " LIKE '$valor%'"; break;
			case "End_With": $cadena = " LIKE '%$valor'"; break;	
		}
		return $cadena;
	}
}

/**
 * [transformaOr description]
 * @param  string $string [description]
 * @return [type] [description]
 */
if (!function_exists('transformaOr')) {	
	function transformaOr($string)
	{
		switch($string){
			case "Ordenar ascendente": $cadena = "ASC"; break;
			case "Ordenar descendente": $cadena = "DESC"; break;
			default : $cadena = "ASC"; break;
		}
		return $cadena;
	}
}