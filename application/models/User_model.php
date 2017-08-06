<?php
defined('BASEPATH') OR exit('No direct script access allowed');


Class User_model extends CI_Model{

	public $id;
	public $first_name;
	public $last_name;
	public $email;
	public $password;
	public $photo_path;
	public $country;
	public $city;
	public $phone;

	

	public function get_user($id){

		//$this->db->select('id,nombre');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('users');

		$row = $query->custom_row_object(0, 'User_model');

		if(isset($row)){
			$row->id = intval($row->id);
		}

		return $row;
	}

	public function set_datos( $data_cruda ){

		foreach ($data_cruda as $nombre_campo => $valor_campo) {
			if( property_exists('User_model', $nombre_campo) ){
				$this->$nombre_campo = $valor_campo;
			}
		}
/*
		if( $this->activo == NULL ){
			$this->activo = 1;
		}
*/
		$this->first_name = strtoupper( $this->first_name );
		$this->last_name = strtoupper( $this->last_name );

		return $this;
	}


	public function insert(){
		$query = $this->db->get_where( 'users', array('email'=>$this->email ) );

	    $user_correo = $query->row();

	    //Verificamos si el correo existe
	    if( isset( $user_correo ) ){
	        //EXISTE!!!
	        $respuesta = array(
	            'err' => TRUE,
	            'mensaje' => 'El correo electronico ya esta registrado'
	        );
	        return $respuesta;
	    }

	    //$cliente = $this->Cliente_model->set_datos( $data );
	    $hecho = $this->db->insert( 'users', $this);

	    if( $hecho ){
	        //Insertado
	        $respuesta = array(
	            'err' => FALSE,
	            'mensaje' => 'Registro insertado correctamente',
	            'user_id' => $this->db->insert_id()
	        );
	        //$this->response( $respuesta );
	        
	    }else{
	        //Si no sucedio
	        $respuesta = array(
	            'err' => TRUE,
	            'mensaje' => 'Error al insertar',
	            'error' => $this->db->_error_message(),
	            'error_num' => $this->db->_error_number()
	        );

	        //$this->response( $respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
	    }
	    return $respuesta;
	}

	public function update(){

		//SELECT * FROM CLIENTES WHERE correo = $this->correo AND id != $this->id
		//TRAEMOS LOS CLIENTES, MENOS ESTE, QUE TENGAN COMO CORREO EL CORREO QUE ESTAMOS QUERIENDO SETEAR CON EL UPDATE
		$this->db->where( 'email =', $this->email );
		$this->db->where( 'id !=', $this->id );
		$query = $this->db->get( 'users' );

	    $user_correo = $query->row();

	    //Verificamos si el correo existe
	    if( isset( $user_correo ) ){
	        //EXISTE!!!
	        $respuesta = array(
	            'err' => TRUE,
	            'mensaje' => 'El correo electronico ya esta registrado por otro usuario.'
	        );
	        return $respuesta;
	    }

	    //$cliente = $this->Cliente_model->set_datos( $data );

	    //RESETEAMOS EL QUERY PARA HACER NUEVA CONSULTA A LA BD
	    $this->db->reset_query();

	    //ACTUALIZANDO EL CLIENTE
	    $this->db->where( 'id', $this->id );
	    $hecho = $this->db->update( 'users', $this );

	    if( $hecho ){
	        //Insertado
	        $respuesta = array(
	            'err' => FALSE,
	            'mensaje' => 'Registro actualizado correctamente',
	            'user_id' => $this->id
	        );
	        //$this->response( $respuesta );
	        
	    }else{
	        //Si no sucedio
	        $respuesta = array(
	            'err' => TRUE,
	            'mensaje' => 'Error al actualizar',
	            'error' => $this->db->_error_message(),
	            'error_num' => $this->db->_error_number()
	        );

	        //$this->response( $respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
	    }
	    return $respuesta;
	}

	public function login(){

		$this->db->where(  array( 'email'=>$this->email , 'password'=>$this->password )  );
		$query = $this->db->get('users');

		$row = $query->custom_row_object(0, 'User_model');

		if(isset($row)){
			$row->id = intval($row->id);
		}

		return $row;
	}


	public function delete( $user_id ){

		$this->db->set('status', 'borrado');
		$this->db->where('id', $cliente_id);
		$hecho = $this->db->update('clientes'); 

		if( $hecho ){
	        //BORRADO
	        $respuesta = array(
	            'err' => FALSE,
	            'mensaje' => 'Registro eliminado correctamente'
	        );
	        //$this->response( $respuesta );
	        
	    }else{
	        //Si no sucedio
	        $respuesta = array(
	            'err' => TRUE,
	            'mensaje' => 'Error al borrar',
	            'error' => $this->db->_error_message(),
	            'error_num' => $this->db->_error_number()
	        );
	        //$this->response( $respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
	    }
	    return $respuesta;
	}





}

















