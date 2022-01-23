<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://coderninja.ng/rafkev
 * @since      1.0.0
 *
 * @package    Share_Sales_Amount
 * @subpackage Share_Sales_Amount/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Share_Sales_Amount
 * @subpackage Share_Sales_Amount/public
 * @author     Raphael <tolakins@gmail.com>
 */
class Share_Sales_Amount_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/share-sales-amount-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-custom.css', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-custom.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-grid', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-grid.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-select2','https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('cn-select2.js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/share-sales-amount-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('cn-custom.js', plugin_dir_url( __FILE__ ) . '../cn_package/js/cn-custom.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name,'cn_plugin_vars', array('ajaxurl' => admin_url('admin-ajax.php'),'plugin_url' =>Share_Sales_Amount_URI,'site_url'=>get_site_url()));
	}


	public function cn_before_add_to_cart_btn(){
		global $product;
        //echo 'Hello World';
		$cn_setting=get_option('cn_setting');
		//$units_sold = get_post_meta( $product->id, 'total_sales', true );
		 $all_orders = wc_get_orders(
		      array(
		         'limit' => -1,
		         'status' => array_map( 'wc_get_order_status_name', wc_get_is_paid_statuses() ),
		         'date_after' => date( 'Y-m-d', strtotime( '-'.$cn_setting['period'].' '.$cn_setting['period_time'])),
		         'return' => 'ids',
		      )
		   );
		   // LOOP THROUGH ORDERS AND SUM QUANTITIES PURCHASED
		   $units_sold = 0;
		   foreach ( $all_orders as $all_order ) {
		      $order = wc_get_order( $all_order );
		      $items = $order->get_items();
		      foreach ( $items as $item ) {
		         $product_id = $item->get_product_id();
		         if ( $product_id == $product->id) {
		            $units_sold = $units_sold + absint( $item['qty'] ); 
		         }
		      }
		   }
		$cn_setting['sharing'];
		$cn_setting['positions'];
		$cn_setting['sales_count'];
		$cn_setting['period'];
		$cn_setting['period_time'];
		if ($cn_setting['sales_count']=='Yes') {
				echo '<div><strong>Sales Count: '.$units_sold.'</strong></div>';	
		}
		if ($cn_setting['frontend']=='Yes') {
			require_once Share_Sales_Amount_DIR . 'public/partials/share-sales-amount-public-display.php';
		}
	}

	public function test_takers($atts){
		ob_start();
		global $wpdb;
		global $product;
		if ($atts) {
			if ($atts['cat']) {
				$cat_id=$atts['cat'];	
			}else{
				$cat_id='';
			}
		}
		$cn_setting=get_option('cn_setting');
		//$units_sold = get_post_meta( $product->id, 'total_sales', true );
		 $all_orders = wc_get_orders(
		      array(
		         'limit' => -1,
		         'status' => array_map( 'wc_get_order_status_name', wc_get_is_paid_statuses() ),
		         'date_after' => date( 'Y-m-d', strtotime( '-'.$cn_setting['period'].' '.$cn_setting['period_time'])),
		         'return' => 'ids',
		      )
		   );

	 	$args = array(
	        'post_type'      => 'product',
	        'posts_per_page' => 1,
	        'product_cat'    => $cat
	    );

    	$loop = new WP_Query( $args );
    	$product=$loop->posts[0];
    	$product = wc_get_product( $product->ID);
		   // LOOP THROUGH ORDERS AND SUM QUANTITIES PURCHASED
		   $units_sold = 0;
		   foreach ( $all_orders as $all_order ) {
		      $order = wc_get_order( $all_order );
		      $items = $order->get_items();
		      foreach ( $items as $item ) {
		         $product_id = $item->get_product_id();
		         if ( $product_id == $product->id) {
		            $units_sold = $units_sold + absint( $item['qty'] ); 
		         }
		      }
		   }
		$cn_setting['sharing'];
		$cn_setting['positions'];
		$cn_setting['sales_count'];
		$cn_setting['period'];
		$cn_setting['period_time'];

		
		if ($cn_setting['sales_count']=='Yes') {
				echo '<div><strong>Sales Count: '.$units_sold.'</strong></div>';	
		}
		if ($cn_setting['frontend']=='Yes') {
			require_once Share_Sales_Amount_DIR . 'public/partials/share-sales-cat.php';
		}
		$ReturnString = ob_get_contents(); ob_end_clean(); 
 		return $ReturnString;
	}


	public function cn_is_decimal( $val )
	{
	    return is_numeric( $val ) && floor( $val ) != $val;
	}



}