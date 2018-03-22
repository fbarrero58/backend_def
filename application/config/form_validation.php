<?php 
if( ! defined('BASEPATH') ) exit('No direct script access allowed');


$config = array(

	// 'cliente_put' => array(
	// 		array( 'field'=>'correo', 'label'=>'correo electronico','rules'=>'trim|required|valid_email' ),
	// 		array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required|min_length[2]|max_length[255]' ),
	// 		array( 'field'=>'zip', 'label'=>'zip','rules'=>'trim|required|min_length[2]|max_length[5]' )
	// )

	'usuarios_post' => array(
		array( 'field'=>'nombres', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'apellidos', 'label'=>'Apellidos','rules'=>'trim|required' ),
		array( 'field'=>'fecha_nacimiento', 'label'=>'Fecha de Nacimiento','rules'=>'trim|required' ),
		array( 'field'=>'id_rol', 'label'=>'Rol','rules'=>'trim|required' ),
		array( 'field'=>'correo', 'label'=>'Correo Empresarial','rules'=>'trim|required|valid_email' ),
		array( 'field'=>'cargo', 'label'=>'Cargo','rules'=>'trim|required' ),
		array( 'field'=>'fecha_vinculacion', 'label'=>'Fecha de Vinculación','rules'=>'trim|required' ),
		array( 'field'=>'correo_personal', 'label'=>'Correo Personal','rules'=>'trim|valid_email' )
	),

	'usuarios_put' => array(
		array( 'field'=>'id_rol', 'label'=>'Rol','rules'=>'trim|required' ),
		array( 'field'=>'cargo', 'label'=>'Cargo','rules'=>'trim|required' ),
		array( 'field'=>'fecha_vinculacion', 'label'=>'Fecha de Vinculación','rules'=>'trim|required' ),
		array( 'field'=>'nombres', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'apellidos', 'label'=>'Apellidos','rules'=>'trim|required' ),
		array( 'field'=>'fecha_nacimiento', 'label'=>'Fecha de Nacimiento','rules'=>'trim|required' ),
		array( 'field'=>'correo_personal', 'label'=>'Correo Personal','rules'=>'trim|valid_email' )
	),
	
	'empresas_post' => array(
			array( 'field'=>'tipo_empresa', 'label'=>'Tipo de Empresa','rules'=>'trim|required' ),
			array( 'field'=>'codigo', 'label'=>'Código','rules'=>'trim|required' ),
			array( 'field'=>'nombre', 'label'=>'Nombre del proyecto','rules'=>'trim|required' ),
			array( 'field'=>'alias', 'label'=>'Alias del proyecto','rules'=>'trim|required' ),
			array( 'field'=>'condicion_pago', 'label'=>'Condición de pago','rules'=>'trim|required' ),
	),

	'empresas_put' => array(
		array( 'field'=>'tipo_empresa', 'label'=>'Tipo de Empresa','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre del proyecto','rules'=>'trim|required' ),
		array( 'field'=>'condicion_pago', 'label'=>'Condición de pago','rules'=>'trim|required' ),
	),

	'proyectos_post' => array(
		array( 'field'=>'empresa', 'label'=>'Empresa','rules'=>'trim|required' ),
		array( 'field'=>'tipo_servicio', 'label'=>'Tipo de Servicio','rules'=>'trim|required' ),
		array( 'field'=>'linea_servicio', 'label'=>'Linea de Servicio','rules'=>'trim|required' ),
		array( 'field'=>'codigo', 'label'=>'Código','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre del proyecto','rules'=>'trim|required' ),
		array( 'field'=>'inicio', 'label'=>'Fecha de inicio','rules'=>'trim|required' ),
		array( 'field'=>'fin', 'label'=>'Fecha de finalización','rules'=>'trim|required' ),
		array( 'field'=>'habilitado', 'label'=>'Habilitado','rules'=>'trim|required' ),
		array( 'field'=>'ticket', 'label'=>'Habilitar Ticket','rules'=>'trim|required' ),
		array( 'field'=>'facturable', 'label'=>'Facturable','rules'=>'trim|required' ),
	),

	'proyectos_put' => array(
		array( 'field'=>'tipo_servicio', 'label'=>'Tipo de Servicio','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre del proyecto','rules'=>'trim|required' ),
		array( 'field'=>'inicio', 'label'=>'Fecha de inicio','rules'=>'trim|required' ),
		array( 'field'=>'fin', 'label'=>'Fecha de finalización','rules'=>'trim|required' ),
		array( 'field'=>'habilitado', 'label'=>'Habilitado','rules'=>'trim|required' ),
		array( 'field'=>'ticket', 'label'=>'Habilitar Ticket','rules'=>'trim|required' ),
		array( 'field'=>'facturable', 'label'=>'Facturable','rules'=>'trim|required' ),
	),

	'permisos_post' => array(
		array( 'field'=>'id_usuario_solicitante', 'label'=>'Usuario Solicitante','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario_aprobador', 'label'=>'Usuario Aprobador','rules'=>'trim|required' ),
		array( 'field'=>'fecha', 'label'=>'Fecha','rules'=>'trim|required' ),
		array( 'field'=>'horas', 'label'=>'Horas','rules'=>'trim|required' )
	),

	'vacaciones_post' => array(
		array( 'field'=>'id_usuario_solicitante', 'label'=>'Usuario Solicitante','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario_aprobador', 'label'=>'Usuario Aprobador','rules'=>'trim|required' ),
		array( 'field'=>'desde', 'label'=>'Desde','rules'=>'trim|required' ),
		array( 'field'=>'hasta', 'label'=>'Hasta','rules'=>'trim|required' )
	),
	
	'compensatorio_post' => array(
		array( 'field'=>'id_usuario_solicitante', 'label'=>'Usuario Solicitante','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario_aprobador', 'label'=>'Usuario Aprobador','rules'=>'trim|required' ),
		array( 'field'=>'fecha', 'label'=>'Fecha','rules'=>'trim|required' ),
		array( 'field'=>'razon', 'label'=>'Razón','rules'=>'trim|required' )
	),

	'aprobar_put' => array(
		array( 'field'=>'estado', 'label'=>'Estado','rules'=>'trim|required' )
	),

	'permisos_put' => array(
		array( 'field'=>'id_usuario_aprobador', 'label'=>'Usuario Aprobador','rules'=>'trim|required' ),
		array( 'field'=>'fecha', 'label'=>'Fecha','rules'=>'trim|required' ),
		array( 'field'=>'horas', 'label'=>'Horas','rules'=>'trim|required' )
	),

	'vacaciones_put' => array(
		array( 'field'=>'id_usuario_aprobador', 'label'=>'Usuario Aprobador','rules'=>'trim|required' ),
		array( 'field'=>'desde', 'label'=>'Desde','rules'=>'trim|required' ),
		array( 'field'=>'hasta', 'label'=>'Hasta','rules'=>'trim|required' )
	),

	'compensatorio_put' => array(
		array( 'field'=>'id_usuario_aprobador', 'label'=>'Usuario Aprobador','rules'=>'trim|required' ),
		array( 'field'=>'fecha', 'label'=>'Fecha','rules'=>'trim|required' ),
		array( 'field'=>'razon', 'label'=>'Razón','rules'=>'trim|required' )
	),

	'alianzas_post' => array(
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'condicion_pago', 'label'=>'Condición de pago','rules'=>'trim|required' )
	),

	'educacion_post' => array(
		array( 'field'=>'id_usuario', 'label'=>'Usuario','rules'=>'trim|required' ),
		array( 'field'=>'id_tipo_estudio', 'label'=>'Tipo de estudio','rules'=>'trim|required' ),
		array( 'field'=>'pais', 'label'=>'Pais','rules'=>'trim|required' ),
		array( 'field'=>'institucion', 'label'=>'Institucion','rules'=>'trim|required' ),
		array( 'field'=>'titulo', 'label'=>'Titulo','rules'=>'trim|required' ),
		array( 'field'=>'fecha_inicio', 'label'=>'Fecha inicio','rules'=>'trim|required' ),
		array( 'field'=>'fecha_fin', 'label'=>'Fecha fin','rules'=>'trim|required' )
	),

	'educacion_put' => array(
		array( 'field'=>'id_usuario', 'label'=>'Usuario','rules'=>'trim|required' ),
		array( 'field'=>'id_tipo_estudio', 'label'=>'Tipo de estudio','rules'=>'trim|required' ),
		array( 'field'=>'pais', 'label'=>'Pais','rules'=>'trim|required' ),
		array( 'field'=>'institucion', 'label'=>'Institucion','rules'=>'trim|required' ),
		array( 'field'=>'titulo', 'label'=>'Titulo','rules'=>'trim|required' ),
		array( 'field'=>'fecha_inicio', 'label'=>'Fecha inicio','rules'=>'trim|required' ),
		array( 'field'=>'fecha_fin', 'label'=>'Fecha fin','rules'=>'trim|required' )
	),

	'empresa_post' => array(
		array( 'field'=>'id_usuario', 'label'=>'Usuario','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'industria', 'label'=>'Industria','rules'=>'trim|required' )
	),

	'cargo_post' => array(
		array( 'field'=>'id_empresa', 'label'=>'Empresa','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'fecha_inicio', 'label'=>'Fecha inicio','rules'=>'trim|required' ),
		array( 'field'=>'fecha_fin', 'label'=>'Fecha fin','rules'=>'trim|required' )
	),

	'responsabilidad_post' => array(
		array( 'field'=>'id_cargo', 'label'=>'ID Cargo','rules'=>'trim|required' ),
		array( 'field'=>'descripcion', 'label'=>'Descripción','rules'=>'trim|required' )
	),

	'empresa_put' => array(
		array( 'field'=>'id_usuario', 'label'=>'Usuario','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'industria', 'label'=>'Industria','rules'=>'trim|required' )
	),

	'cargo_put' => array(
		array( 'field'=>'id_empresa', 'label'=>'Empresa','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'fecha_inicio', 'label'=>'Fecha inicio','rules'=>'trim|required' ),
		array( 'field'=>'fecha_fin', 'label'=>'Fecha fin','rules'=>'trim|required' )
	),

	'responsabilidad_put' => array(
		array( 'field'=>'id_cargo', 'label'=>'ID Cargo','rules'=>'trim|required' ),
		array( 'field'=>'descripcion', 'label'=>'Descripción','rules'=>'trim|required' )
	),

	'registrohoras_post' => array(
		array( 'field'=>'id_proyecto', 'label'=>'ID Proyecto','rules'=>'trim|required' ),
		array( 'field'=>'id_actividad', 'label'=>'ID Actividad','rules'=>'trim|required' ),
		array( 'field'=>'id_tipo_servicio', 'label'=>'Tipo de Servicio','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario', 'label'=>'ID Usuario','rules'=>'trim|required' ),
		array( 'field'=>'descripcion', 'label'=>'Descripción','rules'=>'trim|required' )
	),

	'registrohoras_put' => array(
		array( 'field'=>'id_proyecto', 'label'=>'ID Proyecto','rules'=>'trim|required' ),
		array( 'field'=>'id_actividad', 'label'=>'ID Actividad','rules'=>'trim|required' ),
		array( 'field'=>'id_tipo_servicio', 'label'=>'Tipo de Servicio','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario', 'label'=>'ID Usuario','rules'=>'trim|required' ),
		array( 'field'=>'descripcion', 'label'=>'Descripción','rules'=>'trim|required' )
	),


	'asignacion_post' => array(
		array( 'field'=>'id_proyecto', 'label'=>'ID Proyecto','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario', 'label'=>'ID Usuario','rules'=>'trim|required' ),
		array( 'field'=>'id_modulos_usuario', 'label'=>'Id Modulos Usuario','rules'=>'trim|required' )
	),

	'asignacion_put' => array(
		array( 'field'=>'id_proyecto', 'label'=>'ID Proyecto','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario', 'label'=>'ID Usuario','rules'=>'trim|required' ),
		array( 'field'=>'id_modulos_usuario', 'label'=>'Id Modulos Usuario','rules'=>'trim|required' )
	),

	'propuesta_post' => array(
		array( 'field'=>'id_proyecto', 'label'=>'ID Proyecto','rules'=>'trim|required' ),
		array( 'field'=>'id_estado_comercial', 'label'=>'ID Estado Comercial','rules'=>'trim|required' ),
		array( 'field'=>'num_version', 'label'=>'Número de Versión','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'descripcion', 'label'=>'Descripción','rules'=>'trim|required' ),
		array( 'field'=>'horas_vendidas', 'label'=>'Horas Vendidas','rules'=>'trim|required' ),
		array( 'field'=>'valor_total', 'label'=>'Valor Total','rules'=>'trim|required' )
	),

	'propuesta_put' => array(
		array( 'field'=>'id_estado_comercial', 'label'=>'ID Estado Comercial','rules'=>'trim|required' ),
		array( 'field'=>'num_version', 'label'=>'Número de Versión','rules'=>'trim|required' ),
		array( 'field'=>'nombre', 'label'=>'Nombre','rules'=>'trim|required' ),
		array( 'field'=>'descripcion', 'label'=>'Descripción','rules'=>'trim|required' ),
		array( 'field'=>'horas_vendidas', 'label'=>'Horas Vendidas','rules'=>'trim|required' ),
		array( 'field'=>'valor_total', 'label'=>'Valor Total','rules'=>'trim|required' )
	),

	'condicion_post' => array(
		array( 'field'=>'id_estado_facturacion', 'label'=>'ID Estado Facturación','rules'=>'trim|required' ),
		array( 'field'=>'id_estado_pago', 'label'=>'ID Estado Pago','rules'=>'trim|required' )
	),

	'condicion_put' => array(
		array( 'field'=>'id_estado_facturacion', 'label'=>'ID Estado Facturación','rules'=>'trim|required' ),
		array( 'field'=>'id_estado_pago', 'label'=>'ID Estado Pago','rules'=>'trim|required' )
	),

	'preventa_post' => array(
		array( 'field'=>'id_linea_servicio', 'label'=>'ID Estado Facturación','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario', 'label'=>'ID Estado Pago','rules'=>'trim|required' ),
		array( 'field'=>'id_contacto', 'label'=>'ID Estado Pago','rules'=>'trim|required' ),
		array( 'field'=>'id_estado_pipeline', 'label'=>'ID Estado Pago','rules'=>'trim|required' )
	),

	'preventa_put' => array(
		array( 'field'=>'id_linea_servicio', 'label'=>'ID Estado Facturación','rules'=>'trim|required' ),
		array( 'field'=>'id_usuario', 'label'=>'ID Estado Pago','rules'=>'trim|required' ),
		array( 'field'=>'id_contacto', 'label'=>'ID Estado Pago','rules'=>'trim|required' ),
		array( 'field'=>'id_estado_pipeline', 'label'=>'ID Estado Pago','rules'=>'trim|required' )
	)


);




?>
