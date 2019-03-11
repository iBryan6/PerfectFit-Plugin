<?php
/**
 * Product with PPOM IDs
 **/

if (!defined("ABSPATH")) die("Not Allowed");

// Getting products with already attached PPOM
$ppom_attached_params = array(
    'meta_key'   => '_product_meta_id',
    'meta_value' => $ppom_id,
    'compare'    => '=',
    'post_type'  => 'product',
    'posts_per_page'    => -1,
    'post_status'   => 'publish',
);

$ppom_attached = get_posts($ppom_attached_params);

if (count($ppom_attached) > 0):
    ?>
<div style="background-color: #D3D3D3; padding: 10px; border: orange; border-style: double; border-radius: 25px;">
    <h3>
        <?php _e('Productos Agregados', 'ppom'); ?>
    </h3>
    <table id="ppom-already-attached-table" class="ppom-table table table-striped">
        <thead>
            <tr>
                <th>
                    <strong>
                        <?php _e('Producto', 'ppom') ?></strong>
                </th>
                <th>
                    <strong>
                        <?php _e('Seleccionar', 'ppom') ?></strong>
                </th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($ppom_attached as $ppom_products) {

                echo '<tr>';
                echo '<td>';

                echo $ppom_products->post_title;

                echo '</td>';

                echo '<td>';
                echo '<input type="checkbox" name="ppom_removed[]" value="' . $ppom_products->ID . '"> Remover';
                echo '</td>';


                echo '</tr>';
            }
            ?>

        </tbody>
    </table>
</div>
<?php
endif;
?>

<h3>
    <?php _e('Agregar Nuevos:', 'ppom'); ?>
</h3>
<table id="ppom-product-table" class="ppom-table table table-striped">
    <thead>
        <tr>
            <th>
                <strong>
                    <?php _e('Producto', 'ppom') ?></strong>
            </th>
            <th>
                <strong>
                    <?php _e('Seleccionar', 'ppom') ?></strong>
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($product_list as $product) {

            echo '<tr>';
            echo '<td>';

            echo $product->post_title;

            echo '</td>';

            echo '<td>';
            echo '<input type="checkbox" name="ppom_attached[]" value="' . $product->ID . '"> Agregar Arriba';
            echo '</td>';


            echo '</tr>';
        }
        ?>
    </tbody>
</table> 