<?php
/*
 * Followig class handling textarea input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Textarea_wooproduct extends PPOM_Inputs{
	
	/*
	 * input control settings
	 */
	var $title, $desc, $settings;
	
	/*
	 * this var is pouplated with current plugin meta
	*/
	var $plugin_meta;
	
	function __construct(){
		
		$this -> plugin_meta = ppom_get_plugin_meta();
		
		$this -> title 		= __ ( 'Textarea Input', "ppom" );
		$this -> desc		= __ ( 'regular textarea input', "ppom" );
		$this -> icon		= __ ( '<i class="fa fa-file-text-o" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	
	
	
	private function get_settings(){
		
		return array (
			'title' => array (
					'type' => 'text',
					'title' => __ ( 'Titulo', "ppom" ),
					'desc' => __ ( 'It will be shown as field label', "ppom" ) 
			),
			'data_name' => array (
					'type' => 'text',
					'title' => __ ( 'Nombre en la Base de Datos', "ppom" ),
					'desc' => __ ( 'REQUERIDO: Es el nombre que tendra como identificador en la tabla de grupos.', "ppom" ) 
			),
			'description' => array (
					'type' => 'textarea',
					'title' => __ ( 'Descripción', "ppom" ),
					'desc' => __ ( 'Pequeña descripción, se mostrará cerca del nombre del título.', "ppom" ) 
			),
			'error_message' => array (
					'type' => 'text',
					'title' => __ ( 'Mensaje de error', "ppom" ),
					'desc' => __ ( 'Inserte el mensaje de error para la validación.', "ppom" ) 
			),
			
			// 'default_value' => array (
			// 		'type' => 'text',
			// 		'title' => __ ( 'Post ID', "ppom" ),
			// 		'desc' => __ ( 'It will pull content from post. e.g: 22', "ppom" )
			// ),		
			/*'cols' => array (
					'type' => 'text',
					'title' => __ ( 'Columns', "ppom" ),
					'desc' => __ ( 'e.g 10', "ppom" )
			),*/
			'rows' => array (
					'type' => 'text',
					'title' => __ ( 'Columnas', "ppom" ),
					'desc' => __ ( 'Ejemplo: 3', "ppom" )
			),
			'max_length' => array (
					'type' => 'text',
					'title' => __ ( 'Max. Longitud', "ppom" ),
					'desc' => __ ( 'Max. caracteres permitidos, dejar en blanco por defecto', "ppom" )
			),
			'class' => array (
					'type' => 'text',
					'title' => __ ( 'Clase extra HTML', "ppom" ),
					'desc' => __ ( 'Inserte una(s) clase(s) adicional (separar por coma) para una mayor personalización.', "ppom" ) 
			),
			'width' => array (
					'type' => 'select',
					'title' => __ ( 'Anchura', 'ppom' ),
					'desc' => __ ( 'Select width column', 'ppom'),
					'options'	=> ppom_get_input_cols(),
					'default'	=> 12,
			),
			// BRYAN VISIBILITY TEXTAREA
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
			'required' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Necesario', "ppom" ),
					'desc' => __ ( 'Seleccione esto si es necesario llenar el campo.', "ppom" ) 
			),
			// 'rich_editor' => array (
			// 		'type' => 'checkbox',
			// 		'title' => __ ( 'Rich Editor', "ppom" ),
			// 		'desc' => __ ( 'Enable WordPress rich editor.', "ppom" ),
			// 		'link' => __ ( '<a target="_blank" href="https://codex.wordpress.org/Function_Reference/wp_editor">Editor</a>', 'ppom' ) 
			// ),
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
		
		$_html = '<textarea ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'" ';
		}
		
		$_html .= '>' . stripslashes( $content ) . '</textarea>';
		
		echo $_html;
	}
}