<?php
namespace Lib\Core;

  class Cache {
     

    public  $cacheDir = "/var/www/myFram/cache";
    public  $caching = false;
    public  $cacheFile;
    public  $cacheFileName;
    public  $cacheLogFile;
    public  $cacheLog;

    function __construct(){
		
        $this->cacheFile = base64_encode($_SERVER['REQUEST_URI']);
        $this->cacheFileName = $this->cacheDir.'/'.$this->cacheFile.'.txt';
        $this->cacheLogFile = $this->cacheDir."/log.txt";
        if(!is_dir($this->cacheDir)) mkdir($this->cacheDir, 0777);
        if(file_exists($this->cacheLogFile))
            $this->cacheLog = unserialize(file_get_contents($this->cacheLogFile));
        else
            $this->cacheLog = array();
    }

    function start(){
		
        $location = array_slice(explode('/',$_SERVER['REQUEST_URI']), 2);
  
            if(file_exists($this->cacheFileName) ){
              $this->cacheFileName;
               $this->caching = false;
                echo file_get_contents($this->cacheFileName);
                exit();
            }else{
                $this->caching = true;
                ob_start();
            }
        
    }

    function end(){
        if($this->caching){
            file_put_contents($this->cacheFileName,ob_get_contents());
            ob_end_flush();
            $this->cacheLog[$this->cacheFile] = 1;
            if(file_put_contents($this->cacheLogFile,serialize($this->cacheLog)))
                return true;
        }
    }



	function purge_page($location){
		
		 $cacheFile = base64_encode($location);
        $cacheFileName = $this->cacheDir.'/'.$cacheFile.'.txt';
        $cacheLogFile = $this->cacheDir."/log.txt";
        $location = array_slice(explode('/',$_SERVER['REQUEST_URI']), 2);
            if(file_exists($cacheFileName) ){
                unlink($cacheFileName);
                exit();
            } 
}



    function purge_all(){
       $files = glob($this->cacheDir.'/*');
       foreach ($files as $file) {
		   unlink($file);
	   }
    }

    
  }
?>
