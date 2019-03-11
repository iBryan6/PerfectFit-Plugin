<?php
/*
 * Followig class handling date input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Color_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Color picker', 'ppom' );
		$this -> desc		= __ ( 'Color pallete input', 'ppom' );
		$this -> icon		= __ ( '<i class="fa fa-modx" aria-hidden="true"></i>', 'ppom' );
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
					'desc' => __ ( 'Insert the error message for validation.', 'ppom' ) 
			),		
			'default_color' => array (
					'type' => 'text',
					'title' => __ ( 'Default color', 'ppom' ),
					'desc' => __ ( 'Define default color e.g: #effeff', 'ppom' ) 
			),
			
			'palettes_colors' => array (
					'type' => 'text',
					'title' => __ ( 'Palettes colors', 'ppom' ),
					'desc' => __ ( "Color codes seperated by comma e.g: #125, #459, #78b", 'ppom' )
			),
			'palettes_width' => array (
					'type' => 'text',
					'title' => __ ( 'Palettes width', 'ppom' ),
					'desc' => __ ( "e.g: 500", 'ppom' )
			),
			'palettes_mode' => array (
					'type' => 'select',
					'title' => __ ( 'Palettes mode', 'ppom' ),
					'desc' => __ ( "Select Mode", 'ppom' ),
					'options'=> array('hsl'=>'Hue, Saturation, Lightness','hsv'=>'Hue, Saturation, Value'),
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
					'title' => __ ( 'Necesario', 'ppom' ),
					'desc' => __ ( 'Seleccione esto si es necesario llenar el campo.', 'ppom' ) 
			),
			'show_palettes' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show palettes', 'ppom' ),
					'desc' => __ ( 'Tick if need to show a group of common colors beneath the square', 'ppom' )
			),
			'show_onload' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show on load', 'ppom' ),
					'desc' => __ ( 'Display color picker by default, otherwise show on click', 'ppom' )
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
		
		$palettes = ($args['show-palettes'] == '') ? 'off' : $args['show-palettes'];
		$show = ($args['show-onload'] == '') ? 'off' : $args['show-onload'];
	?>
		
				<script type="text/javascript">	
				<!--
				jQuery(function($){

					var palette = '<?php echo $palettes;?>' == 'on' ? true : false;
					var hide = '<?php echo $show;?>' == 'on' ? false : true;
					
					var options = {
							palettes: palette,
							color: "<?php echo $args['default-color'];?>",
							hide: hide,
							change: function(event,ui){
								$("#box-<?php echo $args['id'];?> input").css( 'background-color', ui.color.toString());
							}
					};
					
					$("#<?php echo $args['id'];?>").iris(options);
				});
				
				//--></script>
				<?php
		}
}