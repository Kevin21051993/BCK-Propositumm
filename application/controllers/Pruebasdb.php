<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebasdb extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('utilidades');

	}

	public function eliminar(){

		$this->db->where('id', 1);
		$this->db->delete('test');

		echo 'registro eliminado';

	}


	public function actualizar(){
		$data = array(
	        'nombre' => 'Victor',
	        'apellido' => 'martinez'
		);

		$data = capitalizar_todo($data);

		$this->db->where('id', 1);
		$this->db->update('test', $data);

		echo 'todo ok!';
	}
	



	public function insertar(){

	// =====================================================
	// INSERTAR UN REGISTRO A LA VEZ
	// =====================================================

	// 	$data = array(
 	//        'nombre' => 'kevin',
 	//        'apellido' => 'sancho'
	// 	);

	// 	$data = capitalizar_todo($data);

	// 	$this->db->insert('test', $data);

	// 	$respuesta = array(
	// 		'err' => FALSE,
	// 		'id_insertado' => $this->db->insert_id()
	// 	);

	// 	echo json_encode($respuesta);

	// =====================================================
	// INSERTAR MULTIPLIES REGISTROS A LA VEZ
	// =====================================================
		$data = array(
	        array(
	                'nombre' => 'pepe',
	                'apellido' => 'latallo'
	        ),
	        array(
	                'nombre' => 'maria',
	                'apellido' => 'felipa'
	        )
		);

		$this->db->insert_batch('test', $data);

		echo $this->db->affected_rows();

	}


	public function tabla(){

		//$this->load->database();

		//$this->db->select('id, nombre, correo');
		//$this->db->select('id, nombre, correo,(select count(*) from clientes) as conteo');

		//$this->db->select_max('id','id_maximo');

		//$this->db->select_min('id','id_mainimo');

		//$this->db->select_avg('id','id_promedio');

		//$this->db->select_sum('id','id_sumatoria');


		//$this->db->select('pais, count(*) as clientes');
		
		$this->db->select('pais');
		$this->db->distinct();
		$this->db->from('clientes');
		$this->db->order_by('pais', 'ASC');

		$this->db->limit(10, 30);

		echo $this->db->count_all_results();  //Cantidad de registros que devuelve la consulta

		echo '<br/>';

		echo $this->db->count_all('clientes'); //Cantidad total de registros que tiene la tabla


		//$this->db->where('id !=',1);
		//$this->db->where('id <',10);
		//$this->db->where('id < 10');
		//$this->db->where('id',1);
		//$this->db->or_where('id',2);

		//$ids = array(1,2,3,4,5);

		//$this->db->where_in('id', $ids);
		//$this->db->where_not_in('id', $ids);

		//$this->db->where('id',1);
		//$this->db->where('activo',1);

		//$this->db->like('nombre','COLTON');
		//$this->db->like('nombre','LINDSEY','before');

		//$this->db->group_by("pais");

		// $query = $this->db->get();

		// foreach ($query->result() as $fila)
		// {	
  //       	echo $fila->pais.'<br/>';
		// }

		

		//$query = $this->db->get('clientes', 10, 0);

		//$query = $this->db->get_where('clientes', array('id' => 1));

		/*foreach ($query->result() as $row)
		{	
        	echo $row->nombre.'<br/>';
		}*/

		//echo json_encode($query->result());


	}






	public function clientes_beta(){

		//$this->load->database();

		$query = $this->db->query('SELECT id, nombre, correo, telefono1 FROM clientes limit 10');

		// foreach ($query->result() as $row)
		// {
		//         echo $row->id;
		//         echo $row->nombre;
		//         echo $row->correo;


		// }

		// echo 'Total registros: ' . $query->num_rows();

		$respuesta = array(
			'err' =>FALSE,
			'mensaje' => 'Registros cargados correctamente.',
			'total_registros' => $query->num_rows(),
			'clientes' => $query->result()
			);

		echo json_encode($respuesta);

	}

	public function cliente($id){

		//$this->load->database();

		$query = $this->db->query('SELECT * FROM clientes WHERE id = '.$id);

		$fila = $query->row();

		if(isset($fila)){

			$respuesta = array(
			'err' =>FALSE,
			'mensaje' => 'Registros cargados correctamente.',
			'total_registros' => 1,
			'clientes' => $fila
			);
			

		}else{

			$respuesta = array(
			'err' =>TRUE,
			'mensaje' => 'El registro con el id = '.$id.' no existe',
			'total_registros' => 0,
			'clientes' => null
			);

		}

		echo json_encode($respuesta);

		
	}


}










/*
URL:   http://thesisassessors.esy.es/restful-thesisadvisories/index.php/Users/user
Data que se le tiene que enviar: 
	first_name : pepito
	last_name :  apelllidopepito
	email :   pepito.apellido@hotmailc.com
	password :   123456
	photo_path : pepito.doc
	country : Peru
	city:  Trujillo
	phone: 983479594
Metodo: PUT

*/