<?php

namespace App\controllers;
use App\controllers\BaseController;
use App\models\Alumno;


class HomeController extends BaseController {

	public function getHome()
    {
        //$fecha=explode(',',date('d,m,Y'));
        $skills=array('PHP','LARAVEL','MYSQL','HTML','CSS','JAVASCRIPT');
        //$fecha=new Fecha();

        return $this->renderHTML(
            'home.twig',
            [
                'listSkills'=>$skills
            ]
        );
    }

    public function getAyuda()
    {
       // return view('home',[]);
        $nombre="ayuda";

       return $this->renderHTML(
           'ayuda.twig',
           [
               "valor"=>$nombre
            ]
        );
    }


    public function getAlumnos()
    {
        // $alumnos=Alumno::where('id','>',0)->get();
        
        $alumnos=Alumno::all();

        return $this->renderHTML(
            'alumnos.twig',
            [
                'listadoAlumnos'=>$alumnos
            ]
        );

    }

    public function storeAlumno($request)
    {

        $dato_post=$request->getParsedBody();

        $nuevo_alumno=new Alumno();

        $nuevo_alumno->nombre=$dato_post['nombre'];

        $nuevo_alumno->save();

        $alumnos=Alumno::all();

        return $this->renderHTML(
            'alumnos.twig',
            [
                'listadoAlumnos'=>$alumnos
            ]
        );
    }
}

?>