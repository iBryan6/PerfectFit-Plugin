<?php
 /*
 * Followig class handling pre-uploaded image control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Image_wooproduct extends PPOM_Inputs
{

	/*
	 * input control settings
	 */
	var $title, $desc, $settings;

	/*
	 * this var is pouplated with current plugin meta
	*/
	var $plugin_meta;

	function __construct()
	{

		$this->plugin_meta = ppom_get_plugin_meta();

		$this->title 		= __('Imagenes', 'ppom');
		$this->desc		= __('Images selection', 'ppom');
		$this->icon		= __('<i class="fa fa-picture-o" aria-hidden="true"></i>', 'ppom');
		$this->settings	= self::get_settings();
	}

	private function get_settings()
	{

		return array(
			'title' => array(
				'type' => 'text',
				'title' => __('Titulo', 'ppom'),
				'desc' => __('It will be shown as field label', 'ppom')
			),
			'data_name' => array(
				'type' => 'text',
				'title' => __('Nombre en la Base de Datos', 'ppom'),
				'desc' => __('REQUERIDO: Es el nombre que tendra como identificador en la tabla de grupos.', 'ppom')
			),
			'description' => array(
				'type' => 'textarea',
				'title' => __('Descripción', 'ppom'),
				'desc' => __('Pequeña descripción, se mostrará cerca del nombre del título.', 'ppom')
			),

			'error_message' => array(
				'type' => 'text',
				'title' => __('Mensaje de error', 'ppom'),
				'desc' => __('Inserte el mensaje de error para la validación.', 'ppom')
			),
			'class' => array(
				'type' => 'text',
				'title' => __('Clase extra HTML', 'ppom'),
				'desc' => __('Inserte una(s) clase(s) adicional (separar por coma) para una mayor personalización.', 'ppom')
			),
			'width' => array(
				'type' => 'select',
				'title' => __('Anchura', 'ppom'),
				'desc' => __('Tamaño en la pantalla siendo 12 el maximo y 2 el minimo.', 'ppom'),
				'options'	=> ppom_get_input_cols(),
				'default'	=> 12,
			),
			'images' => array(
				'type' => 'pre-images',
				'title' => __('Seleccionar imagenes', 'ppom'),
				'desc' => __('Seleccionar imágenes de la biblioteca de medios', 'ppom')
			),
			'selected' => array(
				'type' => 'text',
				'title' => __('Imagen seleccionada', 'ppom'),
				'desc' => __('Imagen seleccionada en la pestaña (Agregar Imágenes) si ya lo desea seleccionado.', 'ppom')
			),
			// BRYAN VISIBILITY IMAGE
			// 'visibility' => array(
			// 	'type' => 'select',
			// 	'title' => __('Visibilidad', 'ppom'),
			// 	'desc' => __('Establecer la visibilidad de campo en función del usuario.', 'ppom'),
			// 	'options'	=> ppom_field_visibility_options(),
			// 	'default'	=> 'everyone',
			// ),
			// 'visibility_role' => array(
			// 	'type' => 'text',
			// 	'title' => __('Roles del usuario', 'ppom'),
			// 	'desc' => __('Rol separado por coma.', 'ppom'),
			// 	'hidden' => true,
			// ), 
			/* 
			'desc_tooltip' => array (
					'type' => 'checkbox',
					'title' => __ ( 'Show tooltip (PRO)', 'ppom' ),
					'desc' => __ ( 'Show Descripción in Tooltip with Help Icon', 'ppom' )
			), */
			'required' => array(
				'type' => 'checkbox',
				'title' => __('Necesario', 'ppom'),
				'desc' => __('Seleccione esto si es necesario llenar el campo.', 'ppom')
			),
			'multiple_allowed' => array(
				'type' => 'checkbox',
				'title' => __('Selecciones multiples?', 'ppom'),
				'desc' => __('¿Permitir a los usuarios seleccionar más de una imagen?', 'ppom')
			),
			'show_popup' => array(
				'type' => 'checkbox',
				'title' => __('Popup', 'ppom'),
				'desc' => __('Mostrar imagen grande en el hover.', 'ppom')
			),/* 
			'legacy_view' => array(
				'type' => 'checkbox',
				'title' => __('Habilitar vista heredada', 'ppom'),
				'desc' => __('Marque la casilla para activar la vista de cuadros viejos para imágenes.', 'ppom')
			), */
			'logic' => array(
				'type' => 'checkbox',
				'title' => __('Enable Conditions', 'ppom'),
				'desc' => __('Tick it to turn conditional logic to work below', 'ppom')
			),
			'conditions' => array(
				'type' => 'html-conditions',
				'title' => __('Conditions', 'ppom'),
				'desc' => __('Tick it to turn conditional logic to work below', 'ppom')
			),
		);
	}


	/*
	 * @params: $options
	*/
	function render_input($args, $images = "", $default_selected = "")
	{

		// nm_personalizedproduct_pa();
		$_html = '';

		// Checking if old view is enabled for images with boxes
		if ($args['legacy_view'] == 'on') {
			$_html = '<div class="pre_upload_image_box">';

			$img_index = 0;
			$popup_width	= $args['popup-width'] == '' ? 600 : $args['popup-width'];
			$popup_height	= $args['popup-height'] == '' ? 450 : $args['popup-height'];

			if ($images) {

				foreach ($images as $image) {


					$_html .= '<div class="pre_upload_image">';
					if ($image['id'] != '') {
						if (isset($image['url']) && $image['url'] != '')
							$_html .= '<a href="' . $image['url'] . '"><img src="' . wp_get_attachment_thumb_url($image['id']) . '" /></a>';
						else
							$_html .= '<img src="' . wp_get_attachment_thumb_url($image['id']) . '" />';
					} else {
						if (isset($image['url']) && $image['url'] != '')
							$_html .= '<a href="' . $image['url'] . '"><img width="150" height="150" src="' . $image['link'] . '" /></a>';
						else {
							$_html .= '<img width="150" height="150" src="' . $image['link'] . '" />';
						}
					}


					// for bigger view
					$_html	.= '<div style="display:none" id="pre_uploaded_image_' . $args['id'] . '-' . $img_index . '"><img style="margin: 0 auto;display: block;" src="' . $image['link'] . '" /></div>';

					$_html	.= '<div class="input_image">';
					if ($args['multiple-allowed'] == 'on') {
						$_html	.= '<input type="checkbox" data-price="' . $image['price'] . '" data-title="' . stripslashes($image['title']) . '" name="' . $args['name'] . '[]" value="' . esc_attr(json_encode($image)) . '" />';
					} else {

						//default selected
						$checked = ($image['title'] == $default_selected ? 'checked = "checked"' : '');
						$_html	.= '<input type="radio" data-price="' . $image['price'] . '" data-title="' . stripslashes($image['title']) . '" data-type="' . stripslashes($args['data-type']) . '" name="' . $args['name'] . '" value="' . esc_attr(json_encode($image)) . '" ' . $checked . ' />';
					}


					$price = '';
					if (function_exists('wc_price') && $image['price'] > 0)
						$price = wc_price($image['price']);

					// image big view	 
					$_html	.= '<a href="#TB_inline?width=' . $popup_width . '&height=' . $popup_height . '&inlineId=pre_uploaded_image_' . $args['id'] . '-' . $img_index . '" class="thickbox" title="' . $image['title'] . '"><img width="15" src="' . $this->plugin_meta['url'] . '/images/zoom.png" /></a>';
					$_html	.= '<div class="p_u_i_name">' . stripslashes($image['title']) . ' ' . $price . '</div>';
					$_html	.= '</div>';	//input_image


					$_html .= '</div>';

					$img_index++;
				}
			}

			$_html .= '<div style="clear:both"></div>';		//container_buttons

			$_html .= '</div>';		//container_buttons
		} else {

			$_html = '<div class="nm-boxes-outer">';

			$img_index = 0;
			$popup_width	= $args['popup-width'] == '' ? 600 : $args['popup-width'];
			$popup_height	= $args['popup-height'] == '' ? 450 : $args['popup-height'];

			if ($images) {

				foreach ($images as $image) {

					$_html .= '<label><div class="pre_upload_image">';
					if ($args['multiple-allowed'] == 'on') {
						$_html	.= '<input type="checkbox" data-price="' . $image['price'] . '" data-title="' . stripslashes($image['title']) . '" name="' . $args['name'] . '[]" value="' . esc_attr(json_encode($image)) . '" />';
					} else {

						//default selected
						$checked = ($image['title'] == $default_selected ? 'checked = "checked"' : '');
						$_html	.= '<input type="radio" data-price="' . $image['price'] . '" data-title="' . stripslashes($image['title']) . '" data-type="' . stripslashes($args['data-type']) . '" name="' . $args['name'] . '" value="' . esc_attr(json_encode($image)) . '" ' . $checked . ' />';
					}
					if ($image['id'] != '') {
						if (isset($image['url']) && $image['url'] != '')
							$_html .= '<a href="' . $image['url'] . '"><img src="' . wp_get_attachment_thumb_url($image['id']) . '" /></a>';
						else
							$_html .= '<img data-image-tooltip="' . wp_get_attachment_url($image['id']) . '" class="nm-enlarge-image" src="' . wp_get_attachment_thumb_url($image['id']) . '" />';
					} else {
						if (isset($image['url']) && $image['url'] != '')
							$_html .= '<a href="' . $image['url'] . '"><img width="150" height="150" src="' . $image['link'] . '" /></a>';
						else {
							$_html .= '<img class="nm-enlarge-image" data-image-tooltip="' . $image['link'] . '" src="' . $image['link'] . '" />';
						}
					}



					$_html .= '</div></label>';

					$img_index++;
				}
			}

			$_html .= '<div style="clear:both"></div>';		//container_buttons

			$_html .= '</div>';		//container_buttons
		}

		echo $_html;

		$this->get_input_js($args);
	}


	/*
	 * following function is rendering JS needed for input
	*/
	function get_input_js($args)
	{
		?>

<script type="text/javascript">
    <!--
    jQuery(function($) {
        if ($('.nm-enlarge-image').length) {
            $('.nm-enlarge-image').imageTooltip({
                xOffset: 5,
                yOffset: 5
            });
        }
        // pre upload image click selection
        /*$(".pre_upload_image").click(function(){

        	if($(this).find('input:checkbox').attr("checked") === 'checked'){
        		$(this).find('input:checkbox').attr("checked", false);
        	}else{
        		$(this).find('input:radio, input:checkbox').attr("checked", "checked");
        	}

        });*/

    });

    //-->
</script>
<?php

}
}
