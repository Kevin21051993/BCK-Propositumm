<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require( APPPATH.'/libraries/REST_Controller.php');
//use Restserver\Libraries\REST_Controller;



class Facturacion extends REST_Controller {

	public function factura_get(){

		//Creamos la URL
		$factura_id = $this->uri->segment(3);

		//Luego van las validaciones
		//-----
		//-----
		//----------------------

		//Cargamos la BD
		$this->load->database();

		//Traemos la factura
		$this->db->where( 'factura_id', $factura_id );
		$query = $this->db->get('facturacion');
		$factura = $query->row();

		//Limpiamos el query para poder hacer una nueva sentencia SQL
		$this->db->reset_query(); 

		//Traemos el detalle de factura
		$this->db->where( 'factura_id', $factura_id );
		$query = $this->db->get('facturacion_detalle');
		$detalle = $query->result();


		$respuesta = array(
			'err' => FALSE,
			'mensaje' => 'factura cargada correctamente',
			'factura' => $factura,
			'detalle' => $detalle
		);

		$this->response( $respuesta );


	}






}