<?php
/*
 * Followig class handling date input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Daterange_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'DateRange Input', 'ppom' );
		$this -> desc		= __ ( '<a href="http://www.daterangepicker.com/" target="_blank">More detail</a>', 'ppom' );
		$this -> icon		= __ ( '<i class="fa fa-table" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	private function get_settings(){
		
		return array (
			'title' => array (
					'type' => 'text',
					'title' => __ ( 'Titulo', 'ppom' ),
					'desc' => __ ( 'All about Daterangepicker, see daterangepicker', 'ppom' ), 
					'link' => __ ( '<a href="http://www.daterangepicker.com/" target="_blank">Daterangepicker</a>', 'ppom' ) 
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
			'width' => array (
					'type' => 'select',
					'title' => __ ( 'Anchura', 'ppom' ),
					'desc' => __ ( 'Tamaño en la pantalla siendo 12 el maximo y 2 el minimo.', 'ppom'),
					'options'	=> ppom_get_input_cols(),
					'default'	=> 12,
			),
			'date_formats' => array (
					'type' => 'text',
					'title' => __ ( 'Format', 'ppom' ),
					'desc' => __ ( 'e.g MM-DD-YYYY, DD-MMM-YYYY', 'ppom' ),
			),
			'default_value' => array (
					'type' => 'text',
					'title' => __ ( 'Default Date', 'ppom' ),
					'desc' => __ ( 'Must be same format as defined in above (Format) field.', 'ppom' ),
			),
			'tp_increment' => array (
					'type' => 'text',
					'title' => __ ( 'Timepicker increment', 'ppom' ),
					'desc' => __ ( 'e.g: 30', 'ppom' ) 
			),
			'open_style' => array (
					'type' => 'select',
					'title' => __ ( 'Open Style', 'ppom' ),
					'desc' => __ ( 'Default is down.', 'ppom' ),
					'options' => array('down'=>'Down', 'up'=>'Up'),
			),
			'start_date' => array (
					'type' => 'text',
					'title' => __ ( 'Start Date', 'ppom' ),
					'desc' => __ ( 'Must be same format as defined in above (Format) field.', 'ppom' ) 
			),
			'end_date' => array (
					'type' => 'text',
					'title' => __ ( 'End Date', 'ppom' ),
					'desc' => __ ( 'Must be same format as defined in above (Format) field.', 'ppom' ) 
			),
			'min_date' => array (
					'type' => 'text',
					'title' => __ ( 'Min Date', 'ppom' ),
					'desc' => __ ( 'e.g: 2017-02-25', 'ppom' ) 
			),
			'max_date' => array (
					'type' => 'text',
					'title' => __ ( 'Max Date', 'ppom' ),
					'desc' => __ ( 'e.g: 2017-09-15', 'ppom' ) 
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
			'time_picker' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show Timepicker', 'ppom' ),
					'desc' => __ ( 'Show Timepicker.', 'ppom' ) 
			),
			'tp_24hours' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show Timepicker 24 Hours', 'ppom' ),
					'desc' => __ ( 'Left blank for default', 'ppom' ) 
			),
			'tp_seconds' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show Timepicker Seconds', 'ppom' ),
					'desc' => __ ( 'Left blank for default', 'ppom' ) 
			),
			'drop_down' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show Dropdown', 'ppom' ),
					'desc' => __ ( 'Left blank for default', 'ppom' ) 
			),
			'show_weeks' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show Week Numbers', 'ppom' ),
					'desc' => __ ( 'Left blank for default.', 'ppom' ) 
			),
			'auto_apply' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Auto Apply Changes', 'ppom' ),
					'desc' => __ ( 'Hide the Apply/Cancel button.', 'ppom' ) 
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