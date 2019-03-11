<?php
/*
 * Followig class handling text input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
* 
* 
* ::::::::::::::::::::::: CREDIT :::::::::::::::::::::::
* Copyright (c) 2007-2013 Josh Bush (digitalbush.com)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

class NM_Masked_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Masked Input', "ppom" );
		$this -> desc		= __ ( 'masked input', "ppom" );
		$this -> settings	= self::get_settings();
		
		
		$this -> input_scripts = array(	'shipped'		=> array(''),
		
										'custom'		=> array(
												array (
														'script_name' 	=> 'mask_script',
														'script_source' => '/js/mask/jquery.maskedinput.min.js',
														'localized' 	=> false,
														'type' 			=> 'js',
														'depends'		=> array('jquery'),
														'in_footer'		=> '',
												),
													
										)
								);
		
		add_action ( 'wp_enqueue_scripts', array ($this, 'load_input_scripts'));
		
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
		),/* 
		'desc_tooltip' => array (
								'type' => 'checkbox',
								'title' => __ ( 'Show tooltip (PRO)', 'ppom' ),
								'desc' => __ ( 'Show Descripción in Tooltip with Help Icon', 'ppom' )
						), */
		'error_message' => array (
				'type' => 'text',
				'title' => __ ( 'Mensaje de error', "ppom" ),
				'desc' => __ ( 'Inserte el mensaje de error para la validación.', "ppom" ) 
		),
		
		'required' => array (
				'type' => 'checkbox',
				'title' => __ ( 'Necesario', "ppom" ),
				'desc' => __ ( 'Seleccione esto si es necesario llenar el campo.', "ppom" ) 
		),
				
		'mask' => array (
				'type' => 'text',
				'title' => __ ( 'Input Mask', "ppom" ),
				'desc' => __ ( 'Input mask e.g:<br>a - Represents an alpha character (A-Z,a-z)<br>9 - Represents a numeric character (0-9)<br>* - Represents an alphanumeric character (A-Z,a-z,0-9)', "ppom" )
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
		
		$_html = '<input type="text" ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'"';
		}
		
		// mask as placeholder
		$_html .= 'placeholder="' . stripslashes($args['data-mask']) . '"';
		
		if($content)
			$_html .= 'value="' . stripslashes($content) . '"';
		
		$_html .= ' />';
		
		echo $_html;
		
		$this -> get_input_js($args);
	}
	
	
	/*
	 * following function is rendering JS needed for input
	*/
	function get_input_js($args){
	
		$input_mask =  $args['data-mask'];
		?>
	
			<script type="text/javascript">	
			<!--
			jQuery("#<?php echo $args['id'];?>").mask("<?php echo $input_mask;?>",{completed:function(){
				this.attr('data-ismask', 'yes');
				}
			});
			//--></script>
			<?php
	}
}