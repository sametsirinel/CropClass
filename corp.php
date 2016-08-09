<?php 


	//////////////////////////////
	//// Bekir Samet Şirinel //// 
	////       Create Time     ////
	////  09.08.2016 06.07 ////
	//////////////////////////////

	class corp{
		
		protected $dist_x = 0;
		
		protected $dist_y = 0;
		
		protected $src_x = 0;
		
		protected $src_y = 0;
		
		protected $dist_w = 0;
		
		protected $dist_h = 0;
		
		protected $src_w =  0;
		
		protected $src_h =  0;
		
		public $newNames = null;
		
		protected $file_patch = null;
		
		protected $errors  = "you not has error ";
		
		function __construct($par=null){
			
			$this->file_patch = $par;
			
		}
		
		function setTop($par=null){
			
			if($this->hasnumber($par,"setTop")){
				
				$this->src_y = $par;
				
			}else{
				
				return false;
				
			}
			
		}
		
		function setLeft($par=null){
			
			if($this->hasnumber($par,"setLeft")){
				
				$this->src_x = $par;
				
			}else{
				
				return false;
				
			}
			
		}
		
		function setWidth($par=null){
			
			if($this->hasnumber($par,"setLeft")){
				
				$this->dist_w = $par;
				$this->src_w = $par;
				
			}else{
				
				return false;
				
			}
			
		}
		
		function setHeight($par=null){
			
			if($this->hasnumber($par,"setLeft")){
				
				$this->dist_h = $par;
				$this->src_h = $par;
				
			}else{
				
				return false;
				
			}
			
		}
		
		protected function hasnumber($par=null,$errorName=null){
			
			if($par !=null){
				
				if(is_numeric($par)){
					
					return true;
					
				}else{
					
					$this->errors = $errorName + " paramaters is not numerical";
					return  false;
					
				}
				
			}else{
				
				$this->errors = $errorName + " paramaters is cannot found";
				return false;
				
			}
			
		}
		
		public function test($par = null){
			
			if($par == null){
				
				$this->errors  = "Parametre Girişi Yapılmadı";
				
				return false;
								
			}else{
				
				$this->file_patch = $par;
				
				if(is_file($this->file_patch)){
				
					$this->imgtype();
					
					return true;
					
				}else{
			
					$this->errors =  "Verdiğiniz Dizin Hatalı ";
				
					return false;
			
				}
				
			}
			
		}
		
		public function error(){
			
			return " Error Code : "  + $this->errors;
			
		}
		
		public function mimetype($filename) {

			$mime_types = array(

				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp'

			);

			$ext = strtolower(array_pop(explode('.',$filename)));
			
			if (array_key_exists($ext, $mime_types)) {
				
				return $mime_types[$ext];
				
			}elseif (function_exists('finfo_open')) {
				
				$finfo = finfo_open(FILEINFO_MIME);
				
				$mimetype = finfo_file($finfo, $filename);
				
				finfo_close($finfo);
				
				return $mimetype;
				
			}else{
				
				return 'application/octet-stream';
				
			}
			
		}
		
		protected function  imgtype(){
			
			switch(@$this->mimetype($this->file_patch)){
				
				case "image/png":
					
					$this->resizepng();
				
				break;
				
				case "image/jpeg":
			
					$this->resizejpg();
				
				break; 
				
			}
			
		}
		
		public function newName($par=null){
			
			if($par!=null){
				$this->newNames = $par;
				
			}else{
				
				$this->newNames = $this->file_patch;
				$this->errors = "new name is not has";
				
			}
			
		}
		
		protected function resizepng(){
			if($this->newNames!=null){
				
				if($this->dist_w==0 || $this->dist_h==0){
					
					list($width,$height) = getimagesize($this->file_patch);
					$dist_img = imagecreatetruecolor($width,$width);
					$src_img = imagecreatefrompng($this->file_patch);
					imagecopyresampled($dist_img,$src_img,$this->dist_x,$this->dist_y,$this->src_x,$this->src_y,$width,$height,$width,$height);
					imagejpeg($dist_img,$this->newNames);
					return  true;
				
				}else{
					
					$dist_img = imagecreatetruecolor($this->src_w,$this->src_h);
					$src_img = imagecreatefrompng($this->file_patch);
					imagecopyresampled($dist_img,$src_img,$this->dist_x,$this->dist_y,$this->src_x,$this->src_y,$this->dist_w,$this->dist_h,$this->src_w,$this->src_h);
					imagejpeg($dist_img,$this->newNames);
					return  true;
					
				}
				
			}
			
		}
		
		protected function resizejpg(){
			
			if($this->newNames!=null){
			
				if($this->dist_w==0 || $this->dist_h==0){
					echo "calisti";
					list($width,$height) = getimagesize($this->file_patch);
					$dist_img = imagecreatetruecolor($width,$height);
					$src_img = imagecreatefromjpeg($this->file_patch);
					imagecopyresampled($dist_img,$src_img,$this->dist_x,$this->dist_y,$this->src_x,$this->src_y,$width,$height,$width,$height);
					imagejpeg($dist_img,$this->newNames);
					return  true;
				
				}else{
					
					$dist_img = imagecreatetruecolor($this->src_w,$this->src_h);
					$src_img = imagecreatefromjpeg($this->file_patch);
					imagecopyresampled($dist_img,$src_img,$this->dist_x,$this->dist_y,$this->src_x,$this->src_y,$this->dist_w,$this->dist_h,$this->src_w,$this->src_h);
					imagejpeg($dist_img,$this->newNames);
					return  true;
						
				}
			
			}
			
		}
		
	}

?>