<?php
/*
 * Followig class handling Measuremnts input control and their
* dependencies. Do not make changes in code
* Create on: 21 May, 2014
*/

class NM_Measure_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Campo de medida', "ppom" );
		$this -> desc		= __ ( 'Measuremnts', "ppom" );
		$this -> icon		= __ ( '<i class="fa fa-building-o" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
		add_filter('ppom_option_label', array($this, 'change_option_label'), 15, 4);
	}
	
	function change_option_label($label, $option, $meta, $product){
   
		if($meta['type'] != 'measure') return $label;
		
		$price = isset($option['price']) ? $option['price'] : 0;
		$price = wc_price($price);
	    $label = $price.'/'.$option['option'];
	    return $label;
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
				
				/*'use_units' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Use Units', 'ppom' ),
						'desc' => __ ( 'If you have multiple units against this option, otherwise product base price will be used.', 'ppom' )
				),
				
				'options' => array (
						'type' => 'paired-measure',
						'title' => __ ( 'Add Units', "ppom" ),
						'desc' => __ ( 'Unit with price (optionally)', "ppom" )
				),*/
		
				'max' => array (
						'type' => 'text',
						'title' => __ ( 'Valores maximos', "ppom" ),
						'desc' => __ ( 'Valores maximos permitidos, dejar en blanco por defecto.', "ppom" )
				),
				'min' => array (
						'type' => 'text',
						'title' => __ ( 'Valores minimos', "ppom" ),
						'desc' => __ ( 'Valores minimos permitidos, dejar en blanco por defecto.', "ppom" )
				),
				'step' => array (
						'type' => 'text',
						'title' => __ ( 'Pasos', "ppom" ),
						'desc' => __ ( 'Intervalos de números legales especificados', "ppom" )
				),
				'default_value' => array (
						'type' => 'text',
						'title' => __ ( 'Establecer el valor predeterminado', "ppom" ),
						'desc' => __ ( 'Valor predefinido para la entrada de medida', "ppom" )
				),
				'class' => array (
						'type' => 'text',
						'title' => __ ( 'Clase extra HTML', "ppom" ),
						'desc' => __ ( 'Inserte una(s) clase(s) adicional (separar por coma) para una mayor personalización.', "ppom" ) 
				),
				'width' => array (
						'type' => 'select',
						'title' => __ ( 'Anchura', 'ppom' ),
						'desc' => __ ( 'Tamaño en la pantalla siendo 12 el maximo y 2 el minimo.', 'ppom'),
						'options'	=> ppom_get_input_cols(),
						'default'	=> 12,
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
				),/* 
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
		
		$_html = '<input type="number" ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'"';
		}
		
		if($content)
			$_html .= 'value="' . stripslashes($content	) . '"';
		
		$_html .= ' />';
		
		echo $_html;
	}
}