<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto_model extends CI_Model {

    public function insertar( $data ){

        $data_insertar = array(
            'id_empresa' => $data['empresa'],
            'id_alianza' => $data['alianza'],
            'id_linea_servicio' => $data['linea_servicio'],
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
            'cargo' => $data['cargo']
        );

        $this->db->insert('contactos', $data_insertar);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Contacto creada exitosamente'
        );

        return $respuesta;

    }

    public function todos( $id, $tipo="empresa" ){

        if( strcmp($tipo, 'empresa') === 0 ){
            $query = $this->db->get_where('contactos',array('id_empresa' => $id));
        }else{
            $query = $this->db->get_where('contactos',array('id_alianza' => $id));
        }

        
        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Contactos cargados exitosamente',
            'contactos' => $query->result()
        );
        return $respuesta;

    }

    public function actualizar( $id, $data ){

        $data_update = array(
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
            'cargo' => $data['cargo']
        );

        $this->db->set($data_update);
        $this->db->where('id', $id);
        $this->db->update('contactos');

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Contacto actualizado exitosamente'
        );

        return $respuesta;

    }

}