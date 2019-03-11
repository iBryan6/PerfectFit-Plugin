<?php
/*
 * Followig class handling radio input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Radio_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Campo de radio', "ppom" );
		$this -> desc		= __ ( 'regular radio input', "ppom" );
		$this -> icon		= __ ( '<i class="fa fa-dot-circle-o" aria-hidden="true"></i>', 'ppom' );
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
				'desc' => __ ( 'Small description, it will be diplay near name title.', "ppom" ) 
			),
			'error_message' => array (
				'type' => 'text',
				'title' => __ ( 'Mensaje de error', "ppom" ),
				'desc' => __ ( 'Inserte el mensaje de error para la validación.', "ppom" ) 
			),
			'options' => array (
				'type' => 'paired',
				'title' => __ ( 'Add options', "ppom" ),
				'desc' => __ ( 'Type option with price (optionally)', "ppom" )
			),
			
			/*'show_price' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Show price', 'ppom' ),
						'desc' => __ ( 'Show price on front end with options', 'ppom' ) 
				),*/
				
			'selected' => array (
				'type' => 'text',
				'title' => __ ( 'Selected option', "ppom" ),
				'desc' => __ ( 'Type option name given in (Add Options) tab if you want already selected.', "ppom" ) 
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
			'onetime' => array (
				'type' => 'checkbox',
				'title' => __ ( 'Fixed Fee', "ppom" ),
				'desc' => __ ( 'Add one time fee to cart total.', "ppom" ) 
			),
			'onetime_taxable' => array (
				'type' => 'checkbox',
				'title' => __ ( 'Fixed Fee Taxable?', "ppom" ),
				'desc' => __ ( 'Calculate Tax for Fixed Fee', "ppom" ) 
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
	 * @params: $options
	*/
	function render_input($args, $options="", $default=""){
		
		$_html = '';
		foreach($options as $opt)
		{

			if($opt['price']){
				
				//if in percent
				if(strpos($opt['price'],'%') !== false){
					$output	= stripslashes(trim($opt['option'])) .' (+ ' . $opt['price'].')';	
				}else{
					$output	= stripslashes(trim($opt['option'])) .' (+ ' . wc_price($opt['price']).')';
				}
				
			}else{
				$output	= stripslashes(trim($opt['option']));
			}			
			
			$field_id = $args['name'] . '-meta-'.strtolower ( preg_replace ( "![^a-z0-9]+!i", "_", $opt['option'] ) );
			
			$_html .= '<label for="'.$field_id.'"> <input id="'.$field_id.'" data-price="'.$opt['price'].'" type="radio" ';
			
			foreach ($args as $attr => $value){
					
				$_html .= $attr.'="'.stripslashes( $value ).'"';
			}
		
			// data-value for optionprice for fixed price
			// since 6.4
			$data_value = $args['field_label'].'-'.$opt['option'];
			
			$_html .= ' value="'.$opt['option'].'" ';
			$_html	.= 'data-value="'.$data_value.'" ';
			$_html	.= checked($default, $opt['option'], false).'> ';
			$_html .= $output;
		
			$_html .= '</label> ';
		}
		
		echo $_html;
	}
}