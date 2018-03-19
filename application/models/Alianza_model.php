<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alianza_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    /*******************************
        Insertar Alianza
    *******************************/
    
    public function insertar( $data ){

        $data_insertar = array(
            'nombre' => $data['nombre'],
            'condicion_pago' => $data['condicion_pago']
        );

        $this->db->insert('alianzas', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Alianza creada exitosamente'
        );

        return $respuesta;

    }

    /*******************************
        Traer todas las alianzas
    *******************************/

    public function todos(){

        $this->db->where('id !=', 0);
        $query = $this->db->get('alianzas');
        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Alianzas cargadas exitosamente',
            'alianzas' => $query->result()
        );

        return $resultado;

    }

    /*******************************
        Actualizar Alianza
    *******************************/

    public function actualizar( $id, $data ){

        $data_update = array(
            'nombre' => $data['nombre'],
            'condicion_pago' => $data['condicion_pago'],
        );
        
        $this->db->set($data_update);
        $this->db->where('id', $id);
        $this->db->update('alianzas');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Alianza actualizada exitosamente'
        );

        return $respuesta;

    }

}