<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	
	
	public function testSize(){
        //$path = FCPATH . ".." ."/eticketing/assets/app/tickets/image" ;
        $path = FCPATH ."/assets/app/tickets/image" ;
		$path = str_replace("/",DIRECTORY_SEPARATOR,$path);
		var_dump($path);		
		//die();
		$total_size = foldersize($path);//$this->dirSize($path);
		var_dump(format_size($total_size,"KB"));		
    }
	

	
}