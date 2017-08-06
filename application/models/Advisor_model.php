<?php
defined('BASEPATH') OR exit('No direct script access allowed');


Class Advisor_model extends CI_Model{

	public $id;
	public $academic_level;
	public $cv_path;
	public $advised_thesis_quantity;
	public $approved_thesis_percent;
	public $stars_quantity;
	public $video_url;
	public $price;
	public $available_schedule;

	

	public function get_advisors(){

		//$this->db->select('id,nombre');
		//$this->db->where(array('id'=>$id, 'status'=>'activo'));
		$query = $this->db->get('advisors');

		$advisors = $query->result();

		

		return $advisors;
	}

public function set_datos( $data_cruda ){

	foreach ($data_cruda as $nombre_campo => $valor_campo) {
		if( property_exists('Cliente_model', $nombre_campo) ){
			$this->$nombre_campo = $valor_campo;
		}
	}

	if( $this->activo == NULL ){
		$this->activo = 1;
	}

	$this->nombre = strtoupper( $this->nombre );
	return $this;
}


	public function insert(){
		$query = $this->db->get_where( 'clientes', array('correo'=>$this->correo ) );

	    $cliente_correo = $query->row();

	    //Verificamos si el correo existe
	    if( isset( $cliente_correo ) ){
	        //EXISTE!!!
	        $respuesta = array(
	            'err' => TRUE,
	            'mensaje' => 'El correo electronico ya esta registrado'
	        );
	        return $respuesta;
	    }

	    //$cliente = $this->Cliente_model->set_datos( $data );
	    $hecho = $this->db->insert( 'clientes', $this);

	    if( $hecho ){
	        //Insertado
	        $respuesta = array(
	            'err' => FALSE,
	            'mensaje' => 'Registro insertado correctamente',
	            'cliente_id' => $this->db->insert_id()
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
		$this->db->where( 'correo =', $this->correo );
		$this->db->where( 'id !=', $this->id );
		$query = $this->db->get( 'clientes' );

	    $cliente_correo = $query->row();

	    //Verificamos si el correo existe
	    if( isset( $cliente_correo ) ){
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
	    $hecho = $this->db->update( 'clientes', $this );

	    if( $hecho ){
	        //Insertado
	        $respuesta = array(
	            'err' => FALSE,
	            'mensaje' => 'Registro actualizado correctamente',
	            'cliente_id' => $this->id
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

	public function delete( $cliente_id ){

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

















