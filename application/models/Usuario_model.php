<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('utilidades');
    }
    
    /******************************
        Insertar Usuario
    ******************************/
    
    public function insertar($data){
        $arreglo_general = array();  

        $query = $this->db->get_where('login', array('correo' => $data['correo']));
        if($query->num_rows() > 0){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Este correo ya esta asignado a otro Usuario'
            );
            return $respuesta;
        }

        $this->db->reset_query();  

        $query = $this->db->get_where('usuarios_info_personal', array('correo_personal' => $data['correo_personal']));
        if($query->num_rows() > 0){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Correo personal ya esta asignado a otro Ususario'
            );
            return $respuesta;
        }
        $this->db->reset_query();  

        //ingresar registro a tabla usuario
        $data_insert = array(
            'id_rol' => $data['id_rol'],
            'cargo' => $data['cargo'],
            'fecha_vinculacion' => $data['fecha_vinculacion'],
            'foto' => $data['foto'],
            'perfil_profesional' => $data['perfil_profesional']
        );         
        $this->db->insert('usuario', $data_insert);    
        $id_usuario= $this->db->insert_id();  
        $this->db->reset_query();       

        //insertar registro a tabla login
        //ENCRIPTAR CONTRASEÑA
        $data['password'] = hash('ripemd160',$data['password']);

        $data_insert = array(
            'id_usuario' => $id_usuario,
            'correo' => $data['correo'],
            'password' => $data['password']
        ); 
        $this->db->insert('login', $data_insert);  
        $this->db->reset_query();

        //insertar registro en tabla usuario_info_personal
        $data_insert = array(
            'id_usuario' => $id_usuario,
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'rut' => $data['rut'],
            'correo_personal' => $data['correo_personal'],
            'celular' => $data['celular'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'direccion' => $data['direccion'],
            'pais_origen' => $data['pais_origen'],
            'pais_residencia' => $data['pais_residencia'],
            'pais_residencia' => $data['pais_residencia']
        ); 
        //$this->db->insert('usuarios_info_personal', $data_insert);  

        return $this->db->insert('usuarios_info_personal', $data_insert);         
    }

    /******************************
        Obtener Usuarios
    ******************************/

    public function obtener($id){
        if ($id == null){
            $this->db->select('u.id, u.foto, i.nombres');
            $this->db->from('usuario as u' );
            $this->db->join('usuarios_info_personal as i', 'u.id = i.id_usuario',"left");
        }else{           
            $this->db->select('i.*,l.correo ,u.*');
            $this->db->from('usuario as u' );
            $this->db->join('login as l', 'u.id=l.id_usuario',"left");
            $this->db->join('usuarios_info_personal as i', 'l.id_usuario = i.id_usuario ');
            $this->db->where( array( 'u.id' => $id) );
        }        
        $query = $this->db->get();
        return $query->result();        
    }

     /******************************
        Actualizar usuarios
     ******************************/

    public function actualizar( $id, $data ){
        
        $validaciones = array(
            'correo_personal' => $data['correo_personal'],
            'id_usuario !='=> $id
        );
        $resultado = verificar_duplicidad('usuarios_info_personal',$validaciones);

        if($resultado['err']){
            return $resultado;
        }


        //actualizar registro a tabla usuario
        $data_update = array(
            'id_rol' => $data['id_rol'],
            'cargo' => $data['cargo'],
            'fecha_vinculacion' => $data['fecha_vinculacion'],
            'foto' => $data['foto'],
            'perfil_profesional' => $data['perfil_profesional']
        );  
        
        $this->db->set($data_update);
        $this->db->where('id', $id);
        $this->db->update('usuario');
        $this->db->reset_query();

        //insertar registro en tabla usuario_info_personal
        $data_update = array(
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'rut' => $data['rut'],
            'correo_personal' => $data['correo_personal'],
            'celular' => $data['celular'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'direccion' => $data['direccion'],
            'pais_origen' => $data['pais_origen'],
            'pais_residencia' => $data['pais_residencia'],
            'pais_residencia' => $data['pais_residencia']
        ); 

        $this->db->set($data_update);
        $this->db->where('id_usuario', $id);
        $this->db->update('usuarios_info_personal');


        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Usuario actualizado exitosamente'
        );

        return $respuesta;        
        
    }

    /******************************
        Asignar modulos
     ******************************/

    public function asignar_modulo( $id, $data ){

        $data_insert = array(
            'id_usuario' => $id,
            'id_modulos' => $data['modulo']
        );

        $query = $this->db->get_where('modulos_usuarios',$data_insert);

        if( $query->num_rows() > 0 ){
            $this->db->insert('modulos_usuarios', $data_insert);
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Asignación exitosa'
            );
        }else{
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El usuario ya tiene asignado este modulo'
            );
        }

        return $respuesta;

    }

     /******************************
        Traer modulos de usuarios
     ******************************/

     public function traer_modulos( $id=null ){

        if( isset($id) ){
            $this->db->where('b.id_usuario',$id);
        }

        $this->db->select("CONCAT(b.nombres,' ',b.apellidos) as usuario, CONCAT(d.nombre,' ',e.nombre) as modulo");
        $this->db->from('modulos_usuarios a');
        $this->db->join('usuarios_info_personal b', 'a.id_usuario = b.id_usuario');
        $this->db->join('perfiles_modulos c', 'a.id_modulos = c.id');
        $this->db->join('vmca_perfiles d', 'c.id_perfiles = d.id');
        $this->db->join('vmca_modulos e', 'c.id_modulos = e.id');
        $query = $this->db->get();

        if( $query->num_rows() > 0 ){
            $respuesta = array(
                'err' => FALSE,
                'modulos' => $query->result()
            );
        }else{
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Este usuario no tiene modulos asignados'
            );
        }

        return $respuesta;

    }

    /******************************
        Eliminar modulo de usuario
     ******************************/

     public function eliminar_modulo( $id_usuario, $id_modulo ){

        $array_delete = array(
            'id_usuario' => $id_usuario,
            'id_modulos' => $id_modulo
        );

        $this->db->delete('modulos_usuarios', $array_delete);

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Modulo de usuario eliminado'
        );

        return $respuesta;

     }

}