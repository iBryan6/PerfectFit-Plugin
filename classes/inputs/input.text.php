<?php
/*
 * Followig class handling text input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Text_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Text Input', 'ppom' );
		$this -> desc		= __ ( 'regular text input', 'ppom' );
		$this -> icon		= __ ( '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	private function get_settings(){
		
		return array (
				'title' => array (
						'type' => 'text',
						'title' => __ ( 'Titulo', 'ppom' ),
						'desc' => __ ( 'Se mostrará como etiqueta de campo', 'ppom' ) 
				),
				'data_name' => array (
						'type' => 'text',
						'title' => __ ( 'Nombre de la Tabla en la Base de Datos.', 'ppom' ),
						'desc' => __ ( 'REQUERIDO: el nombre de identificación de este campo, que puede insertar en la configuración de correo electrónico del cuerpo. Nota: Use solo caracteres en minúscula y guiones bajos.', 'ppom' ) 
				),
				'placeholder' => array (
						'type' => 'text',
						'title' => __ ( 'Marcador de posición', 'ppom' ),
						'desc' => __ ( 'Opcional.', 'ppom' ) 
				),
				'description' => array (
						'type' => 'textarea',
						'title' => __ ( 'Descripción', 'ppom' ),
						'desc' => __ ( 'Pequeña descripción, se mostrará cerca del nombre del título.', 'ppom' ) 
				),
				'error_message' => array (
						'type' => 'text',
						'title' => __ ( 'Mensaje de error', 'ppom' ),
						'desc' => __ ( 'Inserte el mensaje de error para la validación.', 'ppom' ) 
				),
				'maxlength' => array (
						'type' => 'text',
						'title' => __ ( 'Max. Longitud', 'ppom' ),
						'desc' => __ ( 'Maximo caracteres permitidos, dejar en blanco por defecto.', 'ppom' )
				),
				
				'minlength' => array (
						'type' => 'text',
						'title' => __ ( 'Min. Longitud', 'ppom' ),
						'desc' => __ ( 'Minimo caracteres permitidos, dejar en blanco por defecto', 'ppom' )
				),
				
				'default_value' => array (
						'type' => 'text',
						'title' => __ ( 'Set default value', 'ppom' ),
						'desc' => __ ( 'Pre-defined value for text input', 'ppom' )
				),
				'class' => array (
						'type' => 'text',
						'title' => __ ( 'Class', 'ppom' ),
						'desc' => __ ( 'Insert an additional class(es) (separateb by comma) for more personalization.', 'ppom' ) 
				),
				'input_mask' => array (
						'type' => 'text',
						'title' => __ ( 'Input Masking', 'ppom' ),
						'desc' => __ ( 'Click options to see all Masking Options', 'ppom' ),
						'link' => __ ( '<a href="https://github.com/RobinHerbots/Inputmask" target="_blank">Options</a>', 'ppom' ) 
				),
				'width' => array (
						'type' => 'select',
						'title' => __ ( 'Width', 'ppom' ),
						'desc' => __ ( 'Type field width in % e.g: 50%', 'ppom'),
						'options'	=> ppom_get_input_cols(),
						'default'	=> 12,
				),
				'visibility' => array (
						'type' => 'select',
						'title' => __ ( 'Visibility', 'ppom' ),
						'desc' => __ ( 'Set field visibility based on user.', 'ppom'),
						'options'	=> ppom_field_visibility_options(),
						'default'	=> 'everyone',
				),
				'visibility_role' => array (
						'type' => 'text',
						'title' => __ ( 'User Roles', 'ppom' ),
						'desc' => __ ( 'Role separated by comma.', 'ppom'),
						'hidden' => true,
				),
				'required' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Required', 'ppom' ),
						'desc' => __ ( 'Select this if it must be required.', 'ppom' ) 
				),
				'logic' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Enable Conditions', 'ppom' ),
						'desc' => __ ( 'Tick it to turn conditional logic to work below', 'ppom' )
				),
				'conditions' => array (
						'type' => 'html-conditions',
						'title' => __ ( 'Conditions', 'ppom' ),
						'desc' => __ ( 'Tick it to turn conditional logic to work below', 'ppom' )
				),
				
		);
	}
	
	
	/*
	 * @params: args
	*/
	function render_input($args, $content=""){
		
		$_html = '<input type="text" ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'"';
		}
		
		if($content)
			$_html .= 'value="' . stripslashes($content	) . '"';
		
		$_html .= ' />';
		
		echo $_html;
	}
}