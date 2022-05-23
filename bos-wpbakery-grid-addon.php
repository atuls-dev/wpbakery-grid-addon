<?php
/*
Plugin Name: Bells of Steel Product by Cat Grid Addon
Description: Plugin to show products of backery by category
Version: 1.0.0
Author: Atul
*/


function register_wpbackery_category_addon() {

    
    register_taxonomy( 'product_cat', array('product'), array() );

    add_shortcode( 'custom_grid', 'custom_grid_func' );
    function custom_grid_func( $atts, $content = null ) { 
     extract( shortcode_atts( array(
      'pro_cat' => 0,
      'pro_order_by' => 'name',
      'items_qty' => -1,
     ), $atts ) );
     
        $pro_args = array();
        switch ( $pro_order_by ){
            case 'date':
                $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'asc',
                    );
                break;
            case 'modified':
                $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'modified',
                    'meta_key'       => 'total_sales'
                    );
                break;
    		case 'title':
                $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'title',
                    'order'    		 => 'asc'
                    );
                break;
            case 'rand':
                $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'rand',
                    //'order'    		 => 'asc'
                    );
                break;
            case 'comment_count':
                $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'comment_count',
                    //'order'    		 => 'asc'
                    );
                break;
            case 'price':
                 $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'asc',
                    'meta_key'       => '_price'
                    );
                break;
            case 'rating':
                 $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'desc',
                    'meta_key'       => '_wc_average_rating'
                    );
                break;
            case 'popularity':
                $args = array(
                    'post_type'      => 'product',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'desc',
                    'meta_key'       => 'total_sales'
                    );
                break;
            default:
                $args = array(
                    'post_type'      => 'product',
                    );
        }
        
        $items_qty = (int) $items_qty;
        $pro_cat = (int) $pro_cat;
        $args['post_status'] = 'publish';
        if( empty($items_qty) || is_int($items_qty) ){
            $args['posts_per_page'] = $items_qty;
        }
        
        if( empty($pro_cat) || is_int($pro_cat) ) {
            
            $catArgs = array(
                'taxonomy'  => 'product_cat',
                'hide_empty' => false
                //'child_of'    => 170
            );
            $terms = get_terms( $catArgs );
            $child_arr = get_child_taxonomy_ids($terms,$pro_cat);
            
            if(empty($child_arr)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy'      => 'product_cat',
                        'field'         => 'term_id', 
                        'terms'         => $pro_cat
                    )
                );
            } else {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy'      => 'product_cat',
                        'field'         => 'term_id', 
                        'terms'         => $pro_cat
                    ),
                    array(
                        'taxonomy'      => 'product_cat',
                        'field'         => 'term_id', 
                        'terms'         => $child_arr,
                        'operator'      => 'NOT IN'
                    )
                );
            }
        }
        ob_start();
        ?>
        <div class="w-grid type_grid layout_1990 cols_4 overflow_hidden" id="use_grid_addon_custom" data-filterable="true">
        	<style id="use_grid_addon_custom_css">
        	    #use_grid_addon_custom .w-grid-item{padding:1rem}#use_grid_addon_custom .w-grid-list{margin:-1rem}.w-grid + #use_grid_addon_custom .w-grid-list{margin-top:1rem}@media (max-width:1199px){#use_grid_addon_custom .w-grid-item{width:33.3333%}}@media (max-width:899px){#use_grid_addon_custom .w-grid-item{width:50.0000%}}@media (max-width:599px){#use_grid_addon_custom .w-grid-list{margin:0}#use_grid_addon_custom .w-grid-item{width:100.0000%;padding:0;margin-bottom:1rem}}
        	</style>
        	<style>
        	    .layout_1990 .w-grid-item-h{background:#ffffff;color:#333333;border-radius:0.3rem;z-index:3;box-shadow:0 0.03rem 0.06rem rgba(0,0,0,0.1),0 0.10rem 0.30rem rgba(0,0,0,0.1);transition-duration:0.3s}.no-touch .layout_1990 .w-grid-item-h:hover{box-shadow:0 0.10rem 0.20rem rgba(0,0,0,0.1),0 0.33rem 1.00rem rgba(0,0,0,0.15);z-index:4}.layout_1990 .usg_vwrapper_1{transition-duration:0.2s;transform-origin:50% 50%;transform:scale(1) translate(0,0)}.layout_1990 .w-grid-item-h:hover .usg_vwrapper_1{transform:scale(1) translate(0,-2.4rem);opacity:1}.layout_1990 .usg_add_to_cart_1{transition-duration:0.3s;transform-origin:50% 50%;transform:scale(1) translate(0%,0%);opacity:0}.layout_1990 .w-grid-item-h:hover .usg_add_to_cart_1{transform:scale(1) translate(0%,0%);opacity:1}.layout_1990 .usg_product_field_1{position:absolute!important;top:10px!important;left:10px!important;padding-right:0.8rem!important;padding-left:0.8rem!important;font-family:'Rubik',sans-serif!important;font-size:12px!important;font-weight:700!important;text-transform:uppercase!important;color:#ffffff!important;border-radius:2rem!important;background:#f73453!important}.layout_1990 .usg_vwrapper_1{background:inherit!important;padding:1rem 1.2rem 1rem 1.2rem!important}.layout_1990 .usg_post_title_1{margin-bottom:0.3rem!important;font-family:'Rubik',sans-serif!important;font-size:1.2rem!important;font-weight:400!important;color:inherit!important}.layout_1990 .usg_product_field_2{margin-bottom:0.5rem!important;font-family:'Rubik',sans-serif!important;font-size:0.9rem!important}.layout_1990 .usg_product_field_3{font-family:'Rubik',sans-serif!important;font-weight:700!important}.layout_1990 .usg_add_to_cart_1{font-size:0.8rem!important;width:100%!important;border-radius:0!important;position:absolute!important;left:0!important;bottom:0!important;right:0!important}
        	</style>
    	 <div class="w-grid-list">
        <?php
       
        $products = new WP_Query($args);
        if( $products->have_posts()) : while( $products->have_posts() ) : $products->the_post();
                $product_id  = get_the_ID();
                $_product = new WC_Product( $product_id );
                $grouppr = wc_get_product($product_id);
                $all_prices = array();
                foreach ( $grouppr->get_children() as $child_id ) {
                    $all_prices[] = get_post_meta( $child_id, '_price', true );
                }
                if ( ! empty( $all_prices ) ) {
                    $max_price = max( $all_prices );
                    $min_price = min( $all_prices );
                    $price_html = '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$min_price.'</bdi></span> – <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$max_price.'</bdi></span>';
                } else {
                    $price_html = $_product->get_price_html();
                }
                $average  =  $_product->get_average_rating();
                if ( has_post_thumbnail() ) {
                    $img_src_300x300 = get_the_post_thumbnail_url($product_id,array(300,300));
                    $img_src_150x150 = get_the_post_thumbnail_url($product_id,array(150,150));
                }else{
                    $img_src_300x300 = plugin_dir_url( __FILE__ ) . 'images/default-image-not-found_300x300.png'; 
                    $img_src_150x150 = plugin_dir_url( __FILE__ ) . 'images/default-image-not-found_150x150.png'; 
                }
           ?>    
    		<article class="w-grid-item size_1x1 post-<?=$product_id?> product type-product status-publish has-post-thumbnail product_cat-power-racks  instock featured shipping-taxable product-type-grouped" data-id="<?=$product_id?>">
    			<div class="w-grid-item-h">
    				<div class="w-post-elm post_image usg_post_image_1 stretched">
    					<a href="<?php echo get_the_permalink($product_id); ?>" aria-label="<?=get_the_title()?>">
    					    <img src="<?php echo $img_src_300x300; ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="" loading="lazy" srcset="<?php echo $img_src_300x300; ?> 300w, <?php echo $img_src_150x150; ?> 150w" sizes="(max-width: 300px) 100vw, 300px" width="300" height="300">
    					</a>
    				</div>
    				<div class="w-vwrapper usg_vwrapper_1 align_center valign_top">
    				    <?php if($average >= 1) { ?>
                        <div class="w-post-elm product_field rating usg_product_field_2">
                            <div class="star-rating" role="img" aria-label="<?php echo sprintf(__('Rated %s out of 5', 'woocommerce'), $average); ?>">
					            <span style="width:<?php echo ($average*20); ?>">Rated <strong class="rating">5.00</strong> out of 5</span>
					        </div>
                        </div>
                        <?php } ?>
                        <h2 class="w-post-elm post_title usg_post_title_1 woocommerce-loop-product__title color_link_inherit has_text_color">
                            <a href="<?php echo get_the_permalink($product_id); ?>"><?=get_the_title()?></a>
                        </h2>
                        <div class="w-post-elm product_field price usg_product_field_3">
                            <?php echo $price_html; ?>
                        </div>
                    </div>
                    <div class="w-btn-wrapper woocommerce usg_add_to_cart_1 has_border_radius has_font_size no_view_cart_link">
                        <a href="<?php echo get_the_permalink($product_id); ?>" data-quantity="1" class="button product_type_grouped" data-product_id="<?=$product_id?>" data-product_sku="<?=$_product->get_sku()?>" aria-label="View products in the <?=get_the_title()?> group" rel="nofollow"><i class="g-preloader type_1"></i><span class="w-btn-label">View products</span></a>
                    </div>	
    			</div>
    		</article>
        <?php
            endwhile;
        endif;
        wp_reset_query();
        ?>
            </div>
        </div>
<?php
        return ob_get_clean();
    }

    add_action( 'vc_before_init', 'grid_addon_integrateWithVC' );
    function grid_addon_integrateWithVC() {
        $orderby = 'name';
        $order = 'asc';
        $hide_empty = false ;
        $args = array(
            'taxonomy'   => "product_cat",
            'orderby'    => $orderby,
            'order'      => $order,
            'hide_empty' => $hide_empty,
        );
         
        $product_categories = get_terms( $args );
        $pro_cat_array = array(); 
        foreach( $product_categories as $pcat ) {
            $pro_cat_array[''] = '';
            $pro_cat_array[html_entity_decode($pcat->name)] = $pcat->term_id;
        }
        
        $order_array = array(
                ''                  => '',
            	'Date of creation'  => 'date',
            	'Date of update'    => 'modified',
            	'Title' 			=> 'title',
            	'Random' 			=> 'rand',
            	'Comments' 			=> 'comment_count',
            	'Sales' 			=> 'popularity',
            	'Price' 			=> 'price',
            	'Rating' 			=> 'rating',
            );

        vc_map( array(
          "name" => __( "Grid Product by Cat", "my-custom-element" ),
          "base" => "custom_grid",
          "class" => "",
          "category" => __( "Content", "my-custom-element"),
         // 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
         // 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
          "params" => array(
                
                array(
                    "type" => "dropdown",
                    "heading" => __( "Show Items of selected Product categories" ),
                    "param_name" => "pro_cat",
                    'admin_label' => true,
                    'value'       => $pro_cat_array,
                    //"description" => __( "Items selected product categories." )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __( "Order" ),
                    "param_name" => "pro_order_by",
                    'admin_label' => true,
                    'value'       => $order_array,
                    'std'         => 'name', //default value
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __( "Items Quantity" ),
                    "param_name" => "items_qty", 
                    "value" => __( "" ),
                )
          )
         ));
     
    }
    function get_child_taxonomy_ids( $terms, $parent = 0 ) {
        $children = array();
    	foreach( $terms as $term ) {
            if( $term->parent == $parent ) {
                $children[] = $term->term_id;
    			$children = array_merge( $children,get_child_taxonomy_ids( $terms, $term->term_id) );
            }
        }
        return $children;
    }
         
}

add_action( 'init', 'register_wpbackery_category_addon' );