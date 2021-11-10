<?php

namespace App\controllers;
use App\controllers\BaseController;


class HomeController extends BaseController {

	public function getHome()
    {
        $fecha=explode(',',date('d,m,Y'));
        
        return $this->renderHTML('home.twig',['saludo'=>"Hola San Juan","fecha"=>$fecha]);
    }

}

?>