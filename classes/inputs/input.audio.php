<?php
/*
 * Followig class handling pre-uploaded image control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Audio_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Audio / Video', "ppom" );
		$this -> desc		= __ ( 'Audio File Selection', "ppom" );
		$this -> icon		= __ ( '<i class="fa fa-file-video-o" aria-hidden="true"></i>', 'ppom' );
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
					'desc' => __ ( 'Insert the error message for validation.', "ppom" ) 
			),	
			'class' => array (
					'type' => 'text',
					'title' => __ ( 'Class', "ppom" ),
					'desc' => __ ( 'Insert an additional class(es) (separateb by comma) for more personalization.', "ppom" )
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
			),
			'audio' => array (
					'type' => 'pre-audios',
					'title' => __ ( 'Select Audio/Video', "ppom" ),
					'desc' => __ ( 'Select audio or video from media library', "ppom" )
			),/* 
			'desc_tooltip' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show tooltip (PRO)', 'ppom' ),
					'desc' => __ ( 'Show Descripción in Tooltip with Help Icon', 'ppom' )
			), */
			'required' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Necesario', "ppom" ),
					'desc' => __ ( 'Seleccione esto si es necesario llenar el campo.', "ppom" ),
			),
			'multiple_allowed' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Multiple selection?', "ppom" ),
					'desc' => __ ( 'Allow users to select more then one videos or audios?.', "ppom" )
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
	function render_input($args, $images = "", $default_selected = ""){
		
		// nm_personalizedproduct_pa($images);
		
		echo '<div class="pre_audio_box">';
			
		$img_index = 0;
		// $popup_width	= $args['popup-width'] == '' ? 600 : $args['popup-width'];
		// $popup_height	= $args['popup-height'] == '' ? 450 : $args['popup-height'];
		
		if ($images) {
			echo '<table width="100%">';
			
			foreach ($images as $image){

				// Getting Audio URL
				$audio_url = '';
				if($image['id'] != ''){
					$audio_url = wp_get_attachment_url( $image['id'] );	
				} else {
					$audio_url = $image['link'];
				}

				?>
					<tr>
						<td>
						<label>
						<?php
							if ($args['multiple-allowed'] == 'on') {
								echo '<input type="checkbox" data-price="'.$image['price'].'" data-title="'.stripslashes( $image['title'] ).'" name="'.$args['name'].'[]" value="'.esc_attr(json_encode($image)).'" /> ';
							}else{
								//default selected
								$checked = ($image['title'] == $default_selected ? 'checked = "checked"' : '' );
								echo '<input type="radio" data-price="'.$image['price'].'" data-title="'.stripslashes( $image['title'] ).'" data-type="'.stripslashes( $args['data-type'] ).'" name="'.$args['name'].'" value="'.esc_attr(json_encode($image)).'" '.$checked.' /> ';
							}

							$price = '';
							if(function_exists('wc_price') && $image['price'] > 0)
								$price = wc_price( $image['price'] );							
							echo '<b>'.stripslashes( $image['title'] ) . ' ' . $price .'</b>';
						?>
						</label>
						<br>
							<?php
								echo apply_filters( 'the_content', $audio_url );
							?>
						<br>
						</td>
					</tr>
				
				<?php 
					
				$img_index++;
			}
			echo '</table>';
		}
		
		echo '<div style="clear:both"></div>';
			
		echo '</div>';		//container_buttons
		
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
						$('.wp-video').css('width', '100%');
						$('.wp-video-shortcode').css('width', '100%');
	
						
					});
					
					//--></script>
					<?php
			}
}