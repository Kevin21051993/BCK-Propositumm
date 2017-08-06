<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require( APPPATH.'/libraries/REST_Controller.php');
//use Restserver\Libraries\REST_Controller;



class Users extends REST_Controller {

    public function __construct(){

        parent::__construct();
        
        $this->load->database();
        $this->load->model('User_model');
        //$this->load->helper('utilidades');

    }

    public function paginar_get(){
        $this->load->helper('paginacion');
        $pagina     =  $this->uri->segment(3);
        $por_pagina =  $this->uri->segment(4);

        $campos = array('id','nombre','telefono1');

        $respuesta = paginar_todo('clientes', $pagina, $por_pagina, $campos);

       /* if(!isset($por_pagina)){
            $por_pagina = 20;
        }
        */
        /*echo $pagina . '---';
        echo $por_pagina;*/

        /*$cuantos       = $this->db->count_all('clientes');
        $total_paginas = ceil($cuantos / $por_pagina);
 
        if($pagina > $total_paginas){
            $pagina = $total_paginas;
        }

        $pagina -= 1;
        $desde = $pagina * $por_pagina;

        if( $pagina >= $total_paginas - 1 ){
            $pag_siguiente = 1;
        }else{
            $pag_siguiente = $pagina + 2;
        }

        if( $pagina < 1 ){
            $pag_anterior = $total_paginas;
        }else{
            $pag_anterior = $pagina;
        }

        $query = $this->db->get('clientes', $por_pagina, $desde);

        $respuesta = array(
                'err' => FALSE,
                'cuantos' => $cuantos,
                'total _paginas' => $total_paginas,
                'pag_actual' => ($pagina + 1),
                'pag_siguiente' => $pag_siguiente,
                'pag_anterior' => $pag_anterior,
                'clientes' => $query->result()
        );*/

        $this->response($respuesta);

    }

/*
    public function user_delete(){
        
        $user_id  =  $this->uri->segment(3);
        
        $respuesta = $this->User_model->delete( $user_id );
        
        $this->response( $respuesta );


    }
*/


    public function  user_post(){

        $data = $this->post();

        $user_id = $this->uri->segment(3);

        //AGREGAMOS EL CAMPO Y VALOR ID A LA DATA INGRESADA EN BODY DEL POSTMAN
        $data['id'] = $user_id;

        $this->load->library('form_validation');

        $this->form_validation->set_data( $data );

        /*$this->form_validation->set_rules( 'correo', 'correo electronico', 'required|valid_email' );
        $this->form_validation->set_rules( 'nombre', 'nombre', 'required|min_lenght[2]' );
*/
        // TRUE:: TODO BIEN ,  FALSE:: Falla una/unas regla(s)
        if( $this->form_validation->run( 'user_post' ) ){  
            //TODO BIEN
            //$this->response('Todo bien');

            $user = $this->User_model->set_datos( $data );

            $respuesta = $user->update();

            if($respuesta['err']){
                $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
            }else{
                $this->response( $respuesta );
            }

        }else{
            //TODO MAL
            //$this->response('Todo mal');

            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Hay errores en el envio de informacion',
                'errores' => $this->form_validation->get_errores_arreglo()
            );
            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        }

        //$this->response($data);
    }



    public function userlogin_post(){

        $data = $this->post();

        $this->load->library('form_validation');

        $this->form_validation->set_data( $data );

        if( $this->form_validation->run( 'userlogin_post' ) ){  
            //TODO BIEN
            //$this->response('Todo bien');

            $user = $this->User_model->set_datos( $data );

            $respuesta = $user->login();

            if($respuesta['err']){
                $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
            }else{
                $this->response( $respuesta );
            }

        }else{
            //TODO MAL
            //$this->response('Todo mal');

            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Hay errores en el envio de informacion',
                'errores' => $this->form_validation->get_errores_arreglo()
            );
            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        }







        $user = $this->User_model->get_user($user_id);

        if(isset($user)){

            /*unset($cliente->telefono1);
            unset($cliente->telefono2);*/

            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro cargado correctamente.',
                'user' => $user
            );
            $this->response($respuesta);
        }else{
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El registro con el id = '.$user_id.' no existe.',
                'user' => null
            );
        }

        $this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
        //echo json_encode($cliente_id);
    }



    public function  user_put(){

        $data = $this->put();

        $this->load->library('form_validation');

        $this->form_validation->set_data( $data );

        /*$this->form_validation->set_rules( 'correo', 'correo electronico', 'required|valid_email' );
        $this->form_validation->set_rules( 'nombre', 'nombre', 'required|min_lenght[2]' );
*/
        // TRUE:: TODO BIEN ,  FALSE:: Falla una/unas regla(s)
        if( $this->form_validation->run( 'user_put' ) ){  
            //TODO BIEN
            //$this->response('Todo bien');
            $user = $this->User_model->set_datos( $data );

            $respuesta = $user->insert();

            if($respuesta['err']){
                $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
            }else{
                $this->response( $respuesta );
            }

        }else{
            //TODO MAL
            //$this->response('Todo mal');

            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Hay errores en el envio de informacion',
                'errores' => $this->form_validation->get_errores_arreglo()
            );
            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        }

        //$this->response($data);

    }



    public function user_get(){

        //Recupero los valores enviados por el POSTMAN
        $user_id = $this->uri->segment(3);

        //Validar cliente_id
        if(!isset($user_id)){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Es necesario el ID del usuario.'
            );

            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $user = $this->User_model->get_user($user_id);

        if(isset($user)){

            /*unset($cliente->telefono1);
            unset($cliente->telefono2);*/

            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro cargado correctamente.',
                'user' => $user
            );
            $this->response($respuesta);
        }else{
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El registro con el id = '.$user_id.' no existe.',
                'user' => null
            );
        }

        $this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
        //echo json_encode($cliente_id);
    }





    /*public function index_get(){

        $this->load->helper('utilidades');

        $data = array(

            'nombre' => 'fernando herrera',
            'contacto' => 'melissa flores',
            'direccion' => 'residencial villa de las hadas'
        );


        $campos_capitalizar = array('nombre','contacto');
        $data = capitalizar_arreglo($data, $campos_capitalizar);

        // $data['nombre'] = strtoupper($data['nombre']);
        // $data['contacto'] = strtoupper($data['contacto']);

        echo json_encode($data);

    }*/

    /*public function cliente($id){

        $this->load->model('Cliente_model');

        $cliente = $this->Cliente_model->get_cliente($id);

        echo json_encode($cliente);

    }*/

}