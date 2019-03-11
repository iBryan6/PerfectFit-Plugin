<?php
/*
 * Followig class handling select input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Quantities_wooproduct extends PPOM_Inputs{
	
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
		
		$this -> title 		= __ ( 'Variation Quantity', 'ppom' );
		$this -> desc		= __ ( 'regular select-box input', 'ppom' );
		$this -> icon		= __ ( '<i class="fa fa-list-ol" aria-hidden="true"></i>', 'ppom' );
		$this -> settings	= self::get_settings();
		
	}
	
	
	
	
	private function get_settings(){
		
		$how_link = '<a href="https://najeebmedia.com/2016/09/29/add-quantity-fields-variations-woocommerce/" target="_blank">Example</a>';
		return array (
			'title' => array (
					'type' => 'text',
					'title' => __ ( 'Titulo', 'ppom' ),
					'desc' => __ ( 'It will be shown as field label. See example for usage.', 'ppom' ),
					'link' => __ ( '<a target="_blank" href="'.esc_url($how_link).'">Help</a>', 'ppom' ),
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
					'desc' => __ ( 'Inserte el mensaje de error para la validación.', "ppom" ) 
			),
			'options' => array (
					'type' => 'paired-quantity',
					'title' => __ ( 'Add options', "ppom" ),
					'desc' => __ ( 'Type option with price (optionally)', "ppom" )
			),
			
			/*'onetime' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Fixed Fee', "ppom" ),
					'desc' => __ ( 'Add one time fee to cart total.', "ppom" ) 
			),*/

			'class' => array (
					'type' => 'text',
					'title' => __ ( 'Clase extra HTML', 'ppom' ),
					'desc' => __ ( 'Inserte una(s) clase(s) adicional (separar por coma) para una mayor personalización.', 'ppom' ) 
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
					'title' => __ ( 'Necesario', 'ppom' ),
					'desc' => __ ( 'Seleccione esto si es necesario llenar el campo.', 'ppom' ) 
			),
			'use_productprice' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Include Product Price?', "ppom" ),
					'desc' => __ ( 'It will also add product base price in sum.', 'ppom' ) 
			),
			'horizontal' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Horizontal Layout', 'ppom' ),
					'desc' => __ ( 'Check to enable horizontal layout for variations.', 'ppom' ) 
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
	 * @params: $options
	*/
	function render_input($args, $options="", $default=""){
		
		echo '<input type="hidden" name="_quantities_option_price" id="_quantities_option_price">';
		
		if (isset($args['horizontal_layout']) && $args['horizontal_layout'] == 'on') { ?>
		<div class="nm-horizontal-layout">
			<table class="shop_table cart sizes-input">
			    <tr>
			        <th><?php _e('Options', 'ppom');?></th>
	            <?php foreach($options as $opt){ ?>
                	<th>
            			<label class="quantities-lable"> <?php echo stripslashes(trim($opt['option'])); ?>
                		
            			<?php if( $opt['price'] ){
            				echo ' <span>'.wc_price($opt['price']).'</span>';
            			} ?>

            			</label>
                	</th>
	            <?php } ?>
			    </tr>
			    <tr>
			        <th><?php _e('Quantity', 'ppom');?></th>
	            <?php foreach($options as $opt){ ?>
                	<td>
                		<?php
                		
                			$the_price = isset($opt['price']) ? $opt['price'] : 0;
                			
	            			$name = $args['id'].'['.$opt['option'].']';
	            			$min = (isset($opt['min']) ? $opt['min'] : 0 );
	            			$max = (isset($opt['max']) ? $opt['max'] : 10000 );
	            			
	            			$required = ($args['data-req'] == 'on' ? 'required' : '');
            				// echo '<input style="width:50px;text-align:center" '.$required.' min="'.$min.'" max="'.$max.'" data-option="'.$opt['option'].'" min="0" name="'.$name.'" type="number" class="ppom-quantity" value="0" data-price="'.$the_price.'">';
							$input_html	 = '<input style="width:50px;text-align:center" '.$required;
            				$input_html	.=' min="'.$min.'" max="'.$max.'" ';
            				$input_html	.= 'data-option="'.$opt['option'].'" ';
            				$input_html	.= 'name="'.$name.'" type="number" class="ppom-quantity" ';
            				$input_html	.= 'value="0" data-price="'.$the_price.'">';          
            				
            				echo $input_html;
                		?>
                	</td>
	            <?php } ?>
			    </tr>
			</table>
		</div>
		<?php } else { ?>
			<table class="shop_table cart sizes-input">
			    <tr>
			        <th><?php _e('Options', 'ppom');?></th>
			        <th><?php _e('Quantity', 'ppom');?></th>
			    </tr>
	            <?php foreach($options as $opt){ ?>
				    <tr>
		                	<th>
		            			<label class="quantities-lable"> <?php echo stripslashes(trim($opt['option'])); ?>
		                		
		            			<?php if( $opt['price'] ){
		            				echo ' <span>'.wc_price($opt['price']).'</span>';
		            			} ?>

		            			</label>
		                	</th>
		                	<th>
		                		<?php
			            			$name = $args['id'].'['.$opt['option'].']';
			            			$min = (isset($opt['min']) ? $opt['min'] : 0 );
			            			$max = (isset($opt['max']) ? $opt['max'] : 10000 );
			            			
			            			$required = ($args['data-req'] == 'on' ? 'required' : '');
		            				$input_html	 = '<input style="width:50px;text-align:center" '.$required;
		            				$input_html	.=' min="'.$min.'" max="'.$max.'" ';
		            				$input_html	.= 'data-option="'.$opt['option'].'" ';
		            				$input_html	.= 'name="'.$name.'" type="number" class="ppom-quantity" ';
		            				$input_html	.= 'value="0" data-price="'.$opt['price'].'">';
		            				
		            				echo $input_html;
		                		?>
		                	</th>
				    </tr>
	            <?php } ?>
			</table>

		<?php } ?>
		
		<div id="display-total-price">
			<span style="display:none;font-weight:700" class="ppom-total-option-price">
				<?php echo __("Options Total: ", 'ppom'); printf(__(get_woocommerce_price_format(), 'ppom'), get_woocommerce_currency_symbol(), '<span class="ppom-price"></span>');?>
			</span><br>
			<span style="display:none;font-weight:700" class="ppom-total-price">
				<?php echo __("Product Total: ", 'ppom'); printf(__(get_woocommerce_price_format(), 'ppom'), get_woocommerce_currency_symbol(), '<span class="ppom-price"></span>');?>
			</span>
			<span style="display:none;font-weight:700" class="ppom-grand-total-price">
			<hr style="margin: 0">
				<?php echo __("Grand Total: ", 'ppom'); printf(__(get_woocommerce_price_format(), 'ppom'), get_woocommerce_currency_symbol(), '<span class="ppom-price"></span>');?>
			</span>
		</div>
		
		<?php
	}
}