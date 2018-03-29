<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        $this->load->helper('utilidades');
        
    }

    /*******************************
        Iniciar Sesión
    *******************************/

    public function ingresar($data) {

        $data['password'] = hash('ripemd160',$data['password']);

        $data_login = array(
            'correo' => $data['correo'],
            'password' => $data['password']
        );

        $query = $this->db->get_where('login', $data_login);

         if($query->num_rows() > 0){

            // Debe asignar nueva contraseña
            if(  strcmp($query->row()->setear, 'T') === 0 ){
                $respuesta = array(
                    'err' => FALSE,
                    'token' => null,
                    'setear' => TRUE,
                    'id_usuario' => $query->row()->id_usuario
                );
            }else{

                $resultado = $query->result();
                $token = generar_token($resultado);

                $respuesta = array(
                    'err' => FALSE,
                    'token' => $token,
                    'setear' => FALSE,
                    'id_usuario' => $query->row()->id_usuario
                );

            }

            return $respuesta;

        }else{
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Correo y/o contraseña incorrecta'
            );
            return $respuesta;
        }

    }

    /*******************************
        Asignar nueva contraseña
    *******************************/

    public function nueva_pass($data){

        $data['password'] = hash('ripemd160',$data['password']);

        $data_update = array(
            'password' => $data['password'],
            'setear' => 'F'
        );

        $this->db->set($data_update);
        $this->db->where('id_usuario',$data['id']);
        $this->db->update('login');

        $this->db->reset_query();

        $query = $this->db->get_where('login',array('id_usuario' => $data['id']));
        $resultado = $query->result();
        $token = generar_token($resultado);

        return array(
            'err' => FALSE,
            'mensaje' => 'Contraseña actualizada',
            'token' => $token
        );

    }

}