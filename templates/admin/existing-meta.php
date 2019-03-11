<?php
 /*
** PPOM Existing Meta Template
*/

/* 
**========== Direct access not allowed =========== 
*/
if (!defined('ABSPATH')) die('Not Allowed');

$all_forms = PPOM()->get_product_meta_all();
?>

<div class="text-center ppom-import-export-block ppom-meta-card-block" style="display: none">

    <h3><?php _e('Import PPOM Meta', 'ppom'); ?></h3>

    <form method="post" action="admin-post.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="ppom_import_meta" />
        <label for="file-upload" class="btn btn-success">
            <span><?php _e('Choose a file…', 'ppom'); ?></span>
            <input id="file-upload" type="file" name="ppom_csv" style="display: none;">
        </label>
        <input type="submit" class="btn btn-primary" value="<?php _e('Import Meta', 'ppom'); ?>">
    </form>

    <div class="text-right ppom-cancle-import-export-wrap">
        <button class="btn btn-danger ppom-cancle-import-export-btn"><?php _e('Cancel', 'ppom'); ?></button>
    </div>

    <div class="clear"></div>
</div>

<div class="wrapper">
    <h2 class="ppom-heading-style"><?php _e('LISTA DE GRUPOS', 'ppom'); ?></h2>
</div>


<div class="ppom-existing-meta-wrapper">

    <form method="post" action="admin-post.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="ppom_export_meta" />

        <div class="ppom-product-table-header">

            <span class="ppom-product-count-span"><?php _e('Selecionando', 'ppom'); ?> <span id="selected_products_count">0</span><?php _e(' Grupo(s)', 'ppom'); ?></span><br><br>
            <a class="btn btn-danger" id="ppom_delete_selected_products_btn"><?php _e('Borrar', 'ppom') ?></a><br><br>
            <span class="clear"></span>
        </div>
        <div class="table-responsive">
            <table id="ppom-meta-table" class="table">
                <thead>
                    <tr class="bg-info">
                        <th class="ppom-checkboxe-style">
                            <label>
                                <input type="checkbox" name="allselected" id="ppom-all-select-products-head-btn">
                                <span></span>
                            </label>
                        </th>
                        <th><?php _e('ID', "ppom") ?></th>
                        <th><?php _e('Nombre de Grupo', "ppom") ?></th>
                        <th><?php _e('Categorias', "ppom") ?></th>
                        <th><?php _e('Selecionar Productos', "ppom") ?></th>
                        <th><?php _e('Opciones', "ppom") ?></th>
                    </tr>
                </thead>

                <?php 

				foreach ($all_forms as $productmeta) {

					$url_edit     = add_query_arg(array('productmeta_id' => $productmeta->productmeta_id, 'do_meta' => 'edit'));
					$url_clone    = add_query_arg(array('productmeta_id' => $productmeta->productmeta_id, 'do_meta' => 'clone'));
					$url_products = admin_url('edit.php?post_type=product', (is_ssl() ? 'https' : 'http'));
					$product_link = '<a href="' . esc_url($url_products) . '">' . __('Products', 'ppom') . '</a>';
					?>
                <tr>
                    <td class="ppom-meta-table-checkbox-mr ppom-checkboxe-style">
                        <label>
                            <input class="ppom_product_checkbox" type="checkbox" name="ppom_meta[]" value="<?php echo esc_attr($productmeta->productmeta_id); ?>">
                            <span></span>
                        </label>
                    </td>

                    <td><?php echo $productmeta->productmeta_id; ?></td>
                    <td>
                        <a href="<?php echo esc_url($url_edit); ?>">
                            <?php echo stripcslashes($productmeta->productmeta_name) ?>
                        </a>
                    </td>
                    <td><?php echo ppom_admin_simplify_meta($productmeta->the_meta) ?></td>
                    <td>
                        <a class="btn btn-primary ppom-products-modal" data-ppom_id="<?php echo esc_attr($productmeta->productmeta_id); ?>" data-formmodal-id="ppom-product-modal"><?php _e('Elegir Productos', "ppom") ?></a>
                    </td>
                    <td>
                        <a id="del-file-<?php echo esc_attr($productmeta->productmeta_id); ?>" href="#" class="button button-sm ppom-delete-single-product" data-product-id="<?php echo esc_attr($productmeta->productmeta_id); ?>"><span class="dashicons dashicons-no"></span></a>
                        <a href="<?php echo esc_url($url_edit); ?>" title="<?php _e('Editar', "ppom") ?>" class="button"><span class="dashicons dashicons-edit"></span></a>
                        <a href="<?php echo esc_url($url_clone); ?>" title="<?php _e('Clonar', "ppom") ?>" class="button"><span class="dashicons dashicons-image-rotate-right"></span></a>
                    </td>
                </tr>
                <?php 
			}
			?>
            </table>
        </div>
    </form>
</div>

<!-- Product Modal -->
<div id="ppom-product-modal" class="ppom-modal-box" style="display: none;">
    <form id="ppom-product-form">
        <input type="hidden" name="action" value="ppom_attach_ppoms" />
        <input type="hidden" name="ppom_id" id="ppom_id">

        <header>
            <h3><?php _e('Productos de la Tienda en Julyos', 'ppom'); ?></h3>
        </header>

        <div class="ppom-modal-body">

        </div>

        <footer>
            <button type="button" class="btn btn-danger close-model ppom-js-modal-close"><?php _e('Cerrar', 'ppom-addon-pdf'); ?></button>
            <button type="submit" class="btn btn-success"><?php _e('Guardar', 'ppom'); ?></button>
        </footer>
    </form>
</div> 