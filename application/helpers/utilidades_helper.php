<?php

    require_once(APPPATH.'/models/jwt.php');

    
    /**
	 * Verifica que los datos no estén repetidos en la base de datos
	 *
	 * @param string    $tabla        Tabla sobre la cual se harpa la consulta
	 * @param array     $condiciones  Las condiciones para validar si están repetidas
	 *
	 * @return array    Arreglo con TRUE si encontro duplicidad, de lo contrario FALSE
	 */
    function verificar_duplicidad($tabla, $condiciones){

        $CI =& get_instance();
        $CI->load->database();

        $query = $CI->db->get_where($tabla, $condiciones);

        if($query->num_rows() > 0){

            $mensajes_error=array();

            foreach( $condiciones as $nombre_campo => $valor_campo ){
                array_push($mensajes_error,"El $nombre_campo ya esta asignado");
            }

            $respuesta = array(
                'err' => TRUE,
                'mensaje' => $mensajes_error
            );  

        }else{
            $respuesta = array(
                'err' => FALSE
            );
        }

        return $respuesta;
	}
	


    /**
	 * @return string   Llave de encriptación
	 */
    function obtener_llave(){
        return 'Llave_encriptación_VmCa_2018';
    }


    /**
	 * Genera un nuevo token basado en el modelo del Login
	 *
	 * @param string    $objeto  Arreglo con los campos de la tabla login
	 *
	 * @return string   Un Token con el $objeto del Login encriptado
	 */
    function generar_token($objeto){
        $myJWT = new JWT();
        $llave = obtener_llave();
        return $myJWT->encode($objeto,$llave);
    }


    /**
	 * Desencripta y valida un token
	 *
	 * @param string    Token a validar
	 *
	 * @return string   Objeto PHP desencriptado
	 */
    function validar_token($token){

        if( !isset($token) ){
            return array(
                'err' => TRUE,
                'mensaje' => 'Token no especificado'
            );
        }

        $myJWT = new JWT();
        $llave = obtener_llave();

        try{
            // $respuesta = $myJWT->decode($token,$llave,true);
            $respuesta = array(
                'err' => FALSE,
                'objeto' => $myJWT->decode($token,$llave,true)
            );
            return $respuesta;
        }catch(UnexpectedValueException $e){
          return array(
            'err' => TRUE,
            'mensaje' => 'Token invalido'
          );
        }

    }

    /**
	 * Recibe una imagen y la guarda en la carpeta img
	 *
	 * @param string    $destino => usuarios || configuracion
     * @param array    $archivo => Imagen a guardar
	 *
	 * @return boolean   True => Lo pudo guardar, de lo contrario False
	 */
    function subir_archivo($destino, $archivo){
        $uploaddir = APPPATH.'/img/'.$destino.'/';
        $uploadfile = $uploaddir . basename($archivo['archivo']['name']);

        if (move_uploaded_file($archivo['archivo']['tmp_name'], $uploadfile)) {
            $data = true;       
        }else {
            $data = false;        
        }

        return $data;
    }

?>
