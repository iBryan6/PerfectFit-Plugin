<?php
/*
 * Followig class handling hidden input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Hidden_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Hidden Input', "ppom" );
		$this -> desc		= __ ( 'regular hidden input', "ppom" );
		$this -> icon		= __ ( '<i class="fa fa-hashtag" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	
	
	
	private function get_settings(){
		
		return array (

			'title' => array (
					'type' => 'text',
					'title' => __ ( 'Titulo', 'ppom' ),
					'desc' => __ ( 'Label will show in cart', 'ppom' ) 
			),
			'data_name' => array (
					'type' => 'text',
					'title' => __ ( 'Nombre en la Base de Datos', "ppom" ),
					'desc' => __ ( 'REQUERIDO: Es el nombre que tendra como identificador en la tabla de grupos.', "ppom" )
			),
			'field_value' => array (
					'type' => 'text',
					'title' => __ ( 'Field value', "ppom" ),
					'desc' => __ ( 'you can pre-set the value of this hidden input.', "ppom" )
			),
			'visibility' => array (
					'type' => 'select',
					'title' => __ ( 'Visibilidad', 'ppom' ),
					'desc' => __ ( 'Establecer la visibilidad de campo en función del usuario.', 'ppom'),
					'options'	=> ppom_field_visibility_options(),
					'default'	=> 'everyone',
			),
			'visibility_role' => array (
					'type' => 'text',
					'title' => __ ( 'Roles del usuario', 'ppom' ),
					'desc' => __ ( 'Rol separado por coma.', 'ppom'),
					'hidden' => true,
			),
		);
	}
	
	
	/*
	 * @params: args
	*/
	function render_input($args, $content=""){
		
		$_html = '<input type="hidden" ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'"';
		}
		
		if($content)
			$_html .= 'value="' . stripslashes($content) . '"';
		
		$_html .= ' />';
		
		echo $_html;
	}
}