<?php
namespace App\Modules\Home\Controllers;



use Lib\Core\Controller;

  class HomeController extends Controller {
    public function index() {
    
      $this->render('home', 'Home');

    }

   
    
 
    
  }
?>
