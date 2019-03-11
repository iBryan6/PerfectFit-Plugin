<?php
/*
 * Followig class handling date input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Date_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Date Input', 'ppom' );
		$this -> desc		= __ ( 'regular date input', 'ppom' );
		$this -> icon		= __ ( '<i class="fa fa-calendar" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	private function get_settings(){
		
		return array (
			'title' => array (
					'type' => 'text',
					'title' => __ ( 'Titulo', 'ppom' ),
					'desc' => __ ( 'It will be shown as field label', 'ppom' ) 
			),
			'data_name' => array (
					'type' => 'text',
					'title' => __ ( 'Nombre en la Base de Datos', 'ppom' ),
					'desc' => __ ( 'REQUERIDO: Es el nombre que tendra como identificador en la tabla de grupos.', 'ppom' ) 
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
			'class' => array (
					'type' => 'text',
					'title' => __ ( 'Clase extra HTML', 'ppom' ),
					'desc' => __ ( 'Inserte una(s) clase(s) adicional (separar por coma) para una mayor personalización.', 'ppom' ) 
			),
			'default_value' => array (
					'type' => 'text',
					'title' => __ ( 'Default Date', 'ppom' ),
					'desc' => __ ( 'User format YYYY-MM-DD e.g: 2017-05-25.', 'ppom' ),
			),
			'width' => array (
					'type' => 'select',
					'title' => __ ( 'Anchura', 'ppom' ),
					'desc' => __ ( 'Tamaño en la pantalla siendo 12 el maximo y 2 el minimo.', 'ppom'),
					'options'	=> ppom_get_input_cols(),
					'default'	=> 12,
			),
			'date_formats' => array (
					'type' => 'select',
					'title' => __ ( 'Date formats', 'ppom' ),
					'desc' => __ ( 'Select date format. (if jQuery enabled below)', 'ppom' ),
					'options' => ppom_get_date_formats(),
			),
			'year_range' => array (
					'type' => 'text',
					'title' => __ ( 'Year Range', 'ppom' ),
					'desc' => __ ( 'e.g: 1950:2016. (if jQuery enabled below) Set start/end year like used example.', 'ppom' ),
					'link' => __ ( '<a target="_blank" href="http://api.jqueryui.com/datepicker/#option-yearRange">Example</a>', 'ppom' )
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
					'title' => __ ( 'Necesario', 'ppom' ),
					'desc' => __ ( 'Seleccione esto si es necesario llenar el campo.', 'ppom' ) 
			),
			'jquery_dp' => array (
					'type' => 'checkbox',
					'title' => __ ( 'jQuery Datepicker', 'ppom' ),
					'desc' => __ ( 'It will load jQuery fancy datepicker.', 'ppom' ) 
			),
			'past_dates' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Disable Past Dates', 'ppom' ),
					'desc' => __ ( 'It will disable past dates.', 'ppom' ) 
			),
			'no_weekends' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Disable Weekends', 'ppom' ),
					'desc' => __ ( 'It will disable Weekends.', 'ppom' ) 
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
		
		$this -> get_input_js($args);
	}
	
	/*
	 * following function is rendering JS needed for input
	*/
	function get_input_js($args){
	?>
		
				<script type="text/javascript">	
				<!--
				jQuery(function($){

					$("#<?php echo $args['id'];?>").datepicker("destroy");
					
					$("#<?php echo $args['id'];?>").datepicker({ 	
						changeMonth: true,
						changeYear: true,
						dateFormat: $("#<?php echo $args['id'];?>").attr('data-format'),
						defaultDate: "01-01-1964"
						});
				});
				
				//--></script>
				<?php
		}
}