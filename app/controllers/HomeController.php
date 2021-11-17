<?php

namespace App\controllers;
use App\controllers\BaseController;


class HomeController extends BaseController {

	public function getHome()
    {
        //$fecha=explode(',',date('d,m,Y'));
        $alumnos=array('Federico','Fernando','Ismael','Ruben','David','Emmanuel');
        //$fecha=new Fecha();

        return $this->renderHTML('home.twig' , ['listadoAlumnos'=>$alumnos]);
    }

    public function getAyuda()
    {
       // return view('home',[]);
        $nombre="ayuda";

       return $this->renderHTML('ayuda.twig' , ["valor"=>$nombre]);
    }
}

?>