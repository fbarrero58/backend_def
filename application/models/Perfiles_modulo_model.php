<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles_modulo_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        $this->load->helper('utilidades');
    }

    /*******************************
        Crear
    *******************************/

    public function crear( $data ){

        $data_insert = array(
            'id_perfiles' => $data['perfil'],
            'id_modulos' => $data['modulo'],
            'fecha_vigencia' => $data['fecha'],
            'costo_hora' => $data['costo']
        );
        
        $this->db->insert('perfiles_modulos', $data_insert);

        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Perfil del módulo creado exitosamente'
        );

        return $resultado;

    }

    /*******************************
        Traer
    *******************************/

    public function traer( $id=null ){

        if( isset($id) ){
            $this->db->where('a.id', $id);
        }

        $this->db->select('a.id, b.nombre as perfil, c.nombre as modulo, a.fecha_vigencia, a.costo_hora');
        $this->db->from('perfiles_modulos a');
        $this->db->join('vmca_perfiles b', 'a.id_perfiles = b.id');
        $this->db->join('vmca_modulos c', 'a.id_modulos = c.id');
        $query = $this->db->get();
        $resultado = array(
            'err' => FALSE,
            'perfiles_modulos' => $query->result()
        );

        return $resultado;

    }

    /*******************************
        Actualizar
    *******************************/

    public function actualizar( $id, $data ){

        $data_update = array(
            'fecha_vigencia' => $data['fecha'],
            'costo_hora' => $data['costo']
        );

        $this->db->where('id',$id);
        $this->db->set($data_update);
        $query = $this->db->update('perfiles_modulos');

        $resultado = array(
            'err' => FALSE,
            'mensaje' => 'Perfil actualizado exitosamente'
        );

        return $resultado;

    }

}