<?php
class creaLienzo{
	public $image;
	public $exif;
	public $medidas;
	public $lienzo;
	public $tipoPosicion;
	public $newImage;
	
	function __construct($fileName,$lzo_medidas=array())
	{
		// *** Open up the file
		$this->image = $this->openImage($fileName);
		//$this->exif = exif_read_data($fileName, 'FILE');
		$this->medidas();
		$this->genLienzo();
		if( count($lzo_medidas)>1){
			$this->lienzo['width']  = $lzo_medidas['width'];
			$this->lienzo['height'] = $lzo_medidas['height'];
			$this->tipoPosicion = 'smaller';
		}
		$this->createImagen();
	}
	
	public function saveImage($path){
		//$fileName = $this->exif['FileName'];
		//$result = $path.$fileName;
		$result = $path;
		$fp = fopen ($result,'w');
		fwrite ($fp, $this->newImage);
		fclose ($fp);
	}
	
	## --------------------------------------------------------
	
	private function openImage($file)
	{
		// *** Get extension
		$extension = strtolower(strrchr($file, '.'));
	
		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				$img = imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = @imagecreatefromgif($file);
				break;
			case '.png':
				$img = @imagecreatefrompng($file);
				break;
			default:
				$img = false;
				break;
		}
		return $img;
	}
	
	private function medidas(){
		// *** Get width and height
		$this->medidas['width']  = imagesx($this->image);
		$this->medidas['height'] = imagesy($this->image);
	}
	
	private function genLienzo(){
		$width;
		$height;
		if( $this->medidas['width'] > $this->medidas['height'] ){
			$width  = $this->medidas['width'];
			$height = $this->medidas['width'];
			$this->tipoPosicion = 'width';
		}
		if( $this->medidas['width'] < $this->medidas['height'] ){
			$width  = $this->medidas['height'];
			$height = $this->medidas['height'];
			$this->tipoPosicion = 'height';
		}
		if( $this->medidas['width'] == $this->medidas['height'] ){
			$width  = $this->medidas['width'];
			$height = $this->medidas['width'];
			$this->tipoPosicion = 'same';
		}

		$this->lienzo['width']  = $width;
		$this->lienzo['height'] = $height;
		
	}
	
	private function createImagen(){
		$posicion = $this->getPosicion();
		
		//$lienzo = imagecreatetruecolor($this->lienzo['width'], $this->lienzo['height'])  or die('Cannot Initialize new GD image stream');
		$lienzo = imagecreatetruecolor($this->lienzo['width'], $this->lienzo['height']);
		$white = imagecolorallocate($lienzo, 255, 255, 255);
		imagefill($lienzo, 0, 0, $white);
		imagecopy($lienzo, $this->image, $posicion['x'], $posicion['y'], 0, 0,  $this->medidas['width'], $this->medidas['height']);
		
		ob_start();
		imagejpeg($lienzo, NULL, 100);
		imagedestroy($lienzo);
		$i = ob_get_clean();
		
		$this->newImage = $i;
	}
	
	public function getPosicion(){
		$imgMedidas = $this->medidas;
		$lzoMedidas = $this->lienzo;
		$x=0;
		$y=0;
		switch($this->tipoPosicion){
			case "width":
				$y = ($lzoMedidas['height']-$imgMedidas['height'])/2;
				break;
			case "height":
				$x = ($lzoMedidas['width']-$imgMedidas['width'])/2;
				break;
			case "smaller":
				$x = ($lzoMedidas['width']-$imgMedidas['width'])/2;
				$y = ($lzoMedidas['height']-$imgMedidas['height'])/2;
				break;
			case "same":
				break;
		}
		
		$coords['x'] = $x;
		$coords['y'] = $y;
		$coords['tipo'] = $this->tipoPosicion;
		return $coords;
	}
}
?>