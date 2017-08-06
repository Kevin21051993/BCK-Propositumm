<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function index()
    {
        echo 'Hello World!';
    }

    public function comentarios( $id )
    {
    	if(!is_numeric($id)){
    		$respuesta = array('err' => true, 'mensaje' => 'El id tiene que ser numerico');
    		echo json_encode($respuesta);

    		return;
    	}

    	$comentarios = array(
    		array('id' => 1, 'mensaje' => 'Lorem ipsum dolor sit amet, '),
    		array('id' => 2, 'mensaje' => 'Lorem ipsum dolor sit amet knege, '),
    		array('id' => 3, 'mensaje' => 'Lorem ipsum dolor, ')
    	);

    	if(($id >= count($comentarios)) OR ($id < 0))
    	{

    		$respuesta = array('err' => true, 'mensaje' => 'El id no existe');
    		echo json_encode($respuesta);

    		return;
    	}  



        echo json_encode($comentarios[$id]);
    }
}