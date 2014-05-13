<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends Admin_Controller {
	var $dataloca =array();
	var $tipo = 'crop';

	public function __construct(){
		parent::__construct();
		
		//$config['upload_path'] = './assets/upload/';
		//$config['allowed_types'] = 'xls|xlsx';
		//$config['max_size']	= '0';
		//$config['max_filename'] = 12;
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		$this->load->library('image_rezise');
	}
	
	public function index(){
		$formData = $this->input->post();
		$this->_determinaTipo($formData);
		$uConfig['salt']='mV4&U0RLw466rPt';
		$uConfig['salt']='';
		if ( !$this->upload->do_upload('Filedata')){
			$error = array('error' => $this->upload->display_errors());
			$error['tipo'] = $_POST['tipo'];
			$error['permitido'] = $this->upload->allowed_types;
			print_r($error);
			
		} else {
			$uData = $this->upload->data();
			$ext = end(explode(".", $_FILES['Filedata']['name']));
			$stamp = getStamp();
			$nombre = $stamp.$uData['file_ext'];
			$new_n = $uData['file_path'].$nombre;
			rename($uData['full_path'],$new_n);
			
			$uData['file_name'] = $nombre;
			$uData['full_path']= $new_n;
			$uData['raw_name']= $stamp;

			if($_POST['nombre']){
				$nombre = preg_replace("/\s+/", "_", $formData['nombre']).$uData['file_ext'];
				$new_n = $uData['file_path'].$nombre;
				rename($uData['full_path'],$new_n);
				
				$uData['file_name'] = $nombre;
				$uData['full_path']= $new_n;
			}
			if($_POST['thumbs']){
				$thumbs = $this->_elementosThumbs($_POST['thumbs']);
				$this->image_rezise->start($uData['full_path']);
				
				foreach($thumbs as $thumb){
					$carpeta = 'thumb-'.$thumb['thumb'].'/';
					$this->image_rezise->resizeImage($thumb['width'], $thumb['height'], $this->tipo);
					$this->image_rezise->saveImage($uData['file_path'].$carpeta.$uData['file_name'], 80);
				}
			} /*elseif($formData['nombre']){
			}*/
			
			sleep(1);
			//$json['name']=$uData['file_name'];
			//$json['path']=$uData['file_path'].$carpeta;
			echo json_encode($uData);
		}
	}
	
	function _determinaTipo($formData){
		$path = '';
		switch($formData['tipo']){
			case "slides":
				$path = './assets/images/slides/';
				$this->upload->set_upload_path($path);
				$this->upload->set_allowed_types('jpg|jpeg|png|gif');
				break;
			case "producto":
			case "productos":
				$path = './assets/images/productos/';
				$this->upload->set_upload_path($path);
				$this->upload->set_allowed_types('jpg|jpeg|png|gif');
				$this->upload->overwrite = TRUE;
				$this->tipo = 'auto';
				break;
			case "excel":
				$path = './assets/upload/';
				$this->upload->set_upload_path($path);
				$this->upload->set_allowed_types('xls|xlsx');
				break;
			
		}
		return $path;
	}
	
	function _elementosThumbs($arg){
		$final = array();
		$i=0;
		$vals = explode(',',$arg);
		
		foreach($vals as $thumbs){
			$sizes = explode('x',$thumbs);
			$final[$i]['thumb']=$thumbs;
			$final[$i]['width']=$sizes[0];
			$final[$i]['height']=$sizes[1];
			
			$i++;
		}
		return $final;
	}
	/*public function index(){
		$uploadDir = '/assets/images/proyectos/';
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png');
		if ( !empty($_FILES) ) {
			$tempFile   = $_FILES['Filedata']['tmp_name'];
			$uploadDir  = $_SERVER['DOCUMENT_ROOT'].'/terraforma/'.$uploadDir;
			$targetFile = $uploadDir . $_FILES['Filedata']['name'];
		
			// Validate the filetype
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
		
				// Save the file
				move_uploaded_file($tempFile, $targetFile);
				echo 1;
		
			} else {
		
				// The file type wasn't allowed
				echo 'Invalid file type.';
		
			}
		}
	}*/
	
}