<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginatron{
	var $CI;
	var $config;
	var $pagi;
	var $getvars;
	
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->getvars = $this->formatGetvars($this->CI->input->get(NULL, TRUE));
		$this->setDefaults();
    }
	
	public function init($config=array())
	{
		$this->config = array_merge($this->config,$config);

		$this->getStart();
		$this->getTotalPages();
		$this->getPagiLoop();
		$this->listaPagi();
		
		return array_merge($this->pagi,$this->config);
	}
	
	public function setDefaults()
	{
		$config['cur_page']			=1;
		$config['per_page']			=10;
		$config['start']			=0;
		
		$config['first_btn']		=TRUE;
		$config['first_btn_txt']	='&laquo;';
		$config['previous_btn']		=TRUE;
		$config['previous_btn_txt']	='&lsaquo;';
		$config['next_btn']			=TRUE;
		$config['next_btn_txt']		='&rsaquo;';
		$config['last_btn']			=TRUE;
		$config['last_btn_txt']		='&raquo;';
		
		$config['baseSlug']			=site_url($this->CI->constantData['baseSlug']);
		$config['total']			=0;
		$config['pags']				=0;
		$config['start_loop']		=0;
		$config['end_loop']			=0;
		
		$config['getvars']			=$this->getvars;
		
		$this->config = $config;
	}

	function getStart()
	{
		$config = $this->config;
		$start = ($config['cur_page']-1) * $config['per_page'];
		$this->config['start'] = $start;

		return $start;
	}

	function getTotalPages()
	{
		$config = $this->config;
		$total_pages = ceil($config['total'] / $config['per_page']);
		$this->config['pags'] = $total_pages;

		return $total_pages;
	}
	
	function getPagiLoop()
	{
		$cur_page = $this->config['cur_page'];
		$pags = $this->config['pags'];

		if ($cur_page >= 7) {
			$start_loop = $cur_page - 3;
			if ($pags > ($cur_page + 3) ) {
				$end_loop = $cur_page + 3;
			} else if ($cur_page <= $pags && $cur_page > $pags - 6) {
				$start_loop = $pags - 6;
				$end_loop = $pags;
			} else {
				$end_loop = $pags;
			}
		} else {
			$start_loop = 1;
			if ($pags > 7){
				$end_loop = 7;
			} else {
				$end_loop = $pags;
			}
		}
		
		$this->config['start_loop']	= $start_loop;
		$this->config['end_loop']	= $end_loop;
	}
	
	function formatGetvars($getvars)
	{
		$string;
		foreach($getvars as $index=>$value){
			$string.=$index.'='.$value.'&';
		}
		if ($string!='') {
			$string=substr($string,0,strlen($string)-1); //se quita ultimo -&-
		}
		$string = $string;
		return $string;
	}
	
	function listaPagi()
	{
		$base = $this->config['baseSlug'];
		$first_btn_txt = $this->config['first_btn_txt'];
		$previous_btn_txt = $this->config['previous_btn_txt'];
		$next_btn_txt = $this->config['next_btn_txt'];
		$last_btn_txt = $this->config['last_btn_txt'];
		$pags = $this->config['pags'];
		
		$getVals = $this->getvars;
		$getVals = ($getVals!='' ? '?'.$getVals:'');
		$html = "<ul>";

		// FOR ENABLING THE FIRST BUTTON
		if ($this->config['first_btn'] && $this->config['cur_page'] > 1) {
			$html .= "<li p='1' class=''><a href='$base/pag/1/$getVals'>$first_btn_txt</a></li>";
		} else if ($this->config['first_btn']) {
			$html .= "<li p='1' class='disabled'><a href='$base/#' class='nofollow'>$first_btn_txt</a></li>";
		}

		// FOR ENABLING THE PREVIOUS BUTTON
		if ($this->config['previous_btn'] && $this->config['cur_page'] > 1) {
			$pre = $this->config['cur_page'] - 1;
			$html .= "<li p='$pre' class=''><a href='$base/pag/$pre/$getVals'>$previous_btn_txt</a></li>";
		} else if ($this->config['previous_btn']) {
			$html .= "<li class='disabled'><a href='$base/#' class='nofollow'>$previous_btn_txt</a></li>";
		}
		
		// LIST OF # OF PAGI
		for ($i = $this->config['start_loop']; $i <= $this->config['end_loop']; $i++) {

			if ($this->config['cur_page'] == $i){
				$html .= "<li p='$i' class='select'><span class='nofollow'>{$i}</span></li>";
			} else {
				$html .= "<li p='$i' class=''><a href='$base/pag/$i/$getVals'>{$i}</a></li>";
			}
		}

		// TO ENABLE THE NEXT BUTTON
		if ($this->config['next_btn'] && $this->config['cur_page'] < $pags) {
			$nex = $this->config['cur_page'] + 1;
			$html .= "<li p='$nex' class=''><a href='$base/pag/$nex/$getVals'>$next_btn_txt</a></li>";
		} else if ($this->config['next_btn']) {
			$html .= "<li class='disabled'><a href='$base/#' class='nofollow'>$next_btn_txt</a></li>";
		}

		// TO ENABLE THE END BUTTON
		if ($this->config['last_btn'] && $this->config['cur_page'] < $pags) {
			$html .= "<li p='$pags' class=''><a href='$base/pag/$pags/$getVals'>$last_btn_txt</a></li>";
		} else if ($this->config['last_btn']) {
			$html .= "<li p='$pags' class='disabled'><a href='$base/#' class='nofollow'>$last_btn_txt</a></li>";
		}
		
		$html.='</ul>';
		
		$pagi = '<div class="pagination">'.$html.'</div>';

		$this->pagi['nav'] = $pagi;
	}
	
}