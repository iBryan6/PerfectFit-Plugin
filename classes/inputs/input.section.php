<?php
/*
 * Followig class handling text input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Section_wooproduct extends PPOM_Inputs{
	
	/*
	 * input control settings
	 */
	var $title, $desc, $settings;
	
	
	/*
	 * check if section is started
	 */
	var $is_section_stared;
	/*
	 * this var is pouplated with current plugin meta
	*/
	var $plugin_meta;
	
	function __construct(){
		
		$this -> plugin_meta = ppom_get_plugin_meta();
		
		$this -> title 		= __ ( 'HTML', 'ppom' );
		$this -> desc		= __ ( 'HTML content', 'ppom' );
		$this -> icon		= __ ( '<i class="fa fa-code" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	
	private function get_settings(){
		
		return array (
			'data_name' => array (
						'type' => 'text',
						'title' => __ ( 'Nombre en la Base de Datos', 'ppom' ),
						'desc' => __ ( 'REQUERIDO: Es el nombre que tendra como identificador en la tabla de grupos.', 'ppom' ) 
				),
			'html' => array (
					'type' => 'textarea',
					'title' => __ ( 'Contenido', 'ppom' ),
					'desc' => __ ( 'Agrega tu texto o Codigo HTML aqui.', 'ppom' ) 
			),
			'description' => array (
					'type' => 'textarea',
					'title' => __ ( 'Descripción', 'ppom' ),
					'desc' => __ ( 'Pequeña descripción, se mostrará cerca del nombre del título.', 'ppom' ) 
			),
			
			'width' => array (
					'type' => 'select',
					'title' => __ ( 'Anchura', 'ppom' ),
					'desc' => __ ( 'Tamaño en la pantalla siendo 12 el maximo y 2 el minimo.', 'ppom'),
					'options'	=> ppom_get_input_cols(),
					'default'	=> 12,
			),
			// BRYAN VISIBILIDAD SECTION
			// 'visibility' => array (
			// 		'type' => 'select',
			// 		'title' => __ ( 'Visibilidad', 'ppom' ),
			// 		'desc' => __ ( 'Establecer la visibilidad de campo en función del usuario.', 'ppom'),
			// 		'options'	=> ppom_field_visibility_options(),
			// 		'default'	=> 'everyone',
			// ),
			// 'visibility_role' => array (
			// 		'type' => 'text',
			// 		'title' => __ ( 'Roles del usuario', 'ppom' ),
			// 		'desc' => __ ( 'Rol separado por coma.', 'ppom'),
			// 		'hidden' => true,
			// ),
			/* 
			'desc_tooltip' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show tooltip (PRO)', 'ppom' ),
					'desc' => __ ( 'Show Descripción in Tooltip with Help Icon', 'ppom' )
			), */
			'logic' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Enable Conditions', "ppom" ),
					'desc' => __ ( 'Tick it to turn conditional logic to work below', "ppom" )
			),
			'conditions' => array (
					'type' => 'html-conditions',
					'title' => __ ( 'Conditions', "ppom" ),
					'desc' => __ ( 'Tick it to turn conditional logic to work below', "ppom" )
			),
		);

	}
	
	
	/*
	 * @params: args
	*/
	function render_input($args, $content=""){
		
		
		$_html =  '<section id="'.$args['id'].'">';
		$_html .= '<div style="clear: both"></div>';
		
		$_html .= '<header class="webcontact-section-header">';
		$_html .= '<h2>'. stripslashes( $args['title'] ).'</h2>';
		$_html .= '<p id="box-'.$args['id'].'">'. stripslashes( $args['description']).'</p>';
		$_html .= '</header>';
		
		$_html .= '<div style="clear: both"></div>';
		
		echo $_html;
	}
}