<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sg_Order_Approval_Woocommerce_Pro
 * @subpackage Sg_Order_Approval_Woocommerce_Pro/admin
 * @author     Sevengits <sevengits@gmail.com>
 */
class Sg_Order_Approval_Woocommerce_Pro_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 
		 * An instance of this class should be passed to the run() function
		 * defined in Sg_Order_Approval_Woocommerce_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sg_Order_Approval_Woocommerce_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sg-order-approval-woocommerce-pro-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 
		 * An instance of this class should be passed to the run() function
		 * defined in Sg_Order_Approval_Woocommerce_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sg_Order_Approval_Woocommerce_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sg-order-approval-woocommerce-pro-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * add custom status
	 * @since    1.0.0
	 */
	function oawoo_register_my_new_order_statuse_wc_waiting() {

			    register_post_status( 'wc-waiting', array(
			        'label'                     => _x( 'Waiting for approval', 'Order status', 'order-approval-woocommerce' ),
			        'public'                    => true,
			        'exclude_from_search'       => false,
			        'show_in_admin_all_list'    => true,
			        'show_in_admin_status_list' => true,
			        'label_count'               => _n_noop( 'Waiting approval <span class="count">(%s)</span>', 'Waiting<span class="count">(%s)</span>', 'order-approval-woocommerce' )
			    ) );

	}

	/**
	 * add custom status
	 * @since    1.0.0
	 
	 */
	
	function oawoo_wc_order_statuse_wc_waiting( $order_statuses ) {
	    $order_statuses['wc-waiting'] = _x( 'Waiting for approval', 'Order status', 'order-approval-woocommerce' );

	    return $order_statuses;
	}
	/**
	 * @since 1.0.0  add action button in admin 
	 * @return actions
	 */
	function oawoo_add_custom_order_status_actions_button( $actions, $order ) {

			    if ( $order->has_status( array( 'waiting' ) ) ) {

			        $actions['wc_approved'] = array(
			            'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=pending&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
			            'name'      => __( 'Approve', 'order-approval-woocommerce' ),
			            'action'    => 'wc_approved',
			        );
			         // Set the action button
			        $actions['wc_reject'] = array(
			            'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=cancelled&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
			            'name'      => __( 'Reject', 'order-approval-woocommerce' ),
			            'action'    => 'wc_reject',
			        );
			    }
  
    	return $actions;
	}
	/**
	 * 
	 * @since 1.0.0  add action button in admin 
	 
	 */
	

	function oawoo_add_custom_order_status_actions_button_css() {
  
			    echo '<style>.wc-action-button-wc_approved::after { font-family: woocommerce !important; content: "\e015" !important; color:GREEN }</style>';
			    echo '<style>.wc-action-button-wc_reject::after { font-family: woocommerce !important; content: "\e013" !important; color:RED}</style>';
	}
	/**
	 * @since 1.0.0  
	 * Add the gateway to WC Available Gateways
	 */
		
	function oawoo_wc_add_to_gateways( $gateways ) {
			
			$gateways[] = 'Woa_Gateway';
			return $gateways;

	}

	/**
	 *  @since 1.0.0  
 	* Adds plugin page links
 	*/
 
	function oawoo_wc_gateway_plugin_links( $links ) {

		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=advanced&section=sg_order_tab' ) . '">' . __( 'Settings', 'order-approval-woocommerce' ) . '</a>',


		);

		return array_merge( $plugin_links, $links );
	}

	/**
	 *  @since 1.0.0  
 	* 
 	*/
	function oawoo_wc_gateway_init()
	{

	require_once SG_PLUGIN_PATH_ORDER . 'includes/class-sg-order-approval-woocommerce-pro-payment-gateway.php';
	}
	/**
	 *  @since 1.0.0  
 	* 
 	*/
	
	function email_waiting_new_order_notifications( $order_id, $order ) {
    		
    		WC()->mailer()->get_emails()['WC_Customer_Order_New']->trigger( $order_id );
    		WC()->mailer()->get_emails()['WC_Admin_Order_New']->trigger( $order_id );
	}

	/**
	 *  @since 1.0.0  
 	* 
 	*/
 
	function oawoo_status_waiting_rejected_notification( $order_id, $order ) {
   
       WC()->mailer()->get_emails()['WC_Customer_Order_Rejected']->trigger( $order_id );
	
	}
	

	/**
	 *  @since 1.0.0  
 	* 
 	*/
 
	function oawoo_status_waiting_approved_notification( $order_id, $order ) {

		WC()->mailer()->get_emails()['WC_Customer_Order_Approved']->trigger( $order_id );
	
	}


	/**
     * @since 2.0.4 
     */

    public function link_pro_purchase($links)
    {

        $links[] = sprintf('<a href="%s" target="_blank" class="order-pro-link">%s</a>', esc_url('https://sevengits.com/plugin/sg-order-approval-woocommerce-pro/?utm_source=dashboard&utm_medium=plugins-link&utm_campaign=Free-plugin'), esc_html__('Buy Premium', $this->plugin_name));

        return $links;
    }
	
	/**
	 * add more links like docs,support and premium version link in plugin page.
	 *
	 * @since 2.0.4
	 */
	function oawoo_plugin_row_meta( $links, $file ) {    
		if ( strpos( $file, 'order-approval-woocommerce.php' ) !== false ) {
			$new_links = array(
									'pro' => '<a href="https://sevengits.com/plugin/sg-order-approval-woocommerce-pro/?utm_source=dashboard&utm_medium=plugins-link&utm_campaign=Free-plugin" target="_blank" class="order-pro-link">Buy Premium</a>',
									'docs' => '<a href="https://sevengits.com/docs/sg-order-approval-woocommerce-pro?utm_source=dashboard&utm_medium=plugins-link&utm_campaign=Free-plugin" target="_blank">Docs</a>',
									'support' => '<a href="https://wordpress.org/support/plugin/order-approval-woocommerce/?utm_source=dashboard&utm_medium=plugins-link&utm_campaign=Free-plugin" target="_blank"> Free Support</a>'
					);
			
			$links = array_merge( $links, $new_links );
		}
		
		return $links;
	}
	/**
     * @since 2.0.4
     */
    public function sg_get_settings($settings, $current_section)
    {

        $custom_settings = array();

        if ('sg_order_tab' == $current_section) {

			$payment_link = admin_url()."admin.php?page=wc-settings&tab=checkout";
			$e_link = admin_url().'admin.php?page=wc-settings&tab=email';
            $custom_settings =  array(

                array(
                    'name' => __('Sg Order Approval for Woocommerce', 'order-approval-woocommerce'),
                    'type' => 'title',
					'desc' =>	sprintf( __( 'Free version order approval plugin enabled for all orders.<p> Enable order approval at <a href="%s" target="_blank">payments</a> & customise  <a href="%s" target="_blank">emails</a>.</p> If you want to enable order approval for specific product please purchase  <a href="%s" target="_blank">premium version</a>.', 'order-approval-woocommerce' ),$payment_link,$e_link,'https://sevengits.com/plugin/sg-order-approval-woocommerce-pro/?utm_source=dashboard&utm_medium=settings_page&utm_campaign=Free-plugin'),
					'id'   => 'sg_tab_main'
                ),
				array(
					'name' => __( 'Activate' ),
					'type' => 'sidebar',
					'desc' => __( 'Activate plugin'),
					'desc_tip' => true,
					'class' => 'button-secondary',
					'id'	=> 'activate',
	
				),

                array(
                    'type' => 'sectionend',
                    'name' => 'end_section',
                    'id' => 'ppw_woo'
                ),

            );

            return $custom_settings;
        } else {

            return $settings;
        }
    }
    /**
     * @since 2.0.4
     */
    public function sg_add_settings_tab($settings_tab)
    {

        $settings_tab['sg_order_tab'] = __('SG Order Approval', 'order-approval-woocommerce');
        return $settings_tab;
    }
	/**
	 * @since  2.0.4
	 */
	function sg_custom_admin_css(){
		echo '<style>
		a.order-pro-link {
			color: #e75152 !important;
			font-weight: bold !important;
		}
  		</style>';
	}




function freeship_add_admin_field_sidebar( $value ){
	require_once SG_PLUGIN_PATH_ORDER . 'admin/promo-sidebar.php';   
}
function wc_order_item_add_action_buttons_callback($order)
	{
		$order_status  = $order->get_status();
		$approve_class 	='';
		$reject_class	='';
		$aprv_btn_visibility_cls='';

		if($order->get_status() == 'waiting') {
			$approve_label  =	 __('Approve', 'order-approval-woocommerce');
			
		}else{
			$approve_label  =	 __('Approved', 'order-approval-woocommerce');
			$approve_class = 'approved';
		}
		if($order->get_status() == 'cancelled') {
			$reject_class = 'reject';
			$aprv_btn_visibility_cls='oa_btn_visibility';
			$reject_label   = 	__('Rejected', 'order-approval-woocommerce');
		}else{
			$reject_label   = 	__('Reject', 'order-approval-woocommerce');
		}

		
		$approve_slug   =	wp_nonce_url(admin_url('admin-ajax.php?action=woocommerce_mark_order_status&status=pending&order_id=' . $order->get_id()), 'woocommerce-mark-order-status');
		$reject_slug	=	wp_nonce_url(admin_url('admin-ajax.php?action=woocommerce_mark_order_status&status=cancelled&order_id=' . $order->get_id()), 'woocommerce-mark-order-status');
		?>
		<a href="<?php echo $approve_slug; ?>" class="button success <?php echo $approve_class." ".$aprv_btn_visibility_cls; ?>"><?php echo $approve_label; ?></a>
		<a href="<?php echo $reject_slug; ?>" class="button danger <?php echo $reject_class; ?>"><?php echo $reject_label; ?></a>
		<style>
		.button.danger {
			color: red;
			border-color: red;
		}
		.button.danger:hover {
			color: red;
			border-color: red;
		}
		.button.success {
			color: green;
			border-color: green;
		}
		.button.success:hover {
			color: green;
			border-color: green;
		}
		.approved:before {
			content: "\f12a";
			font: normal 15px/1 'dashicons';
			vertical-align: middle;
			
		}
		.reject:before {
			content: "\f153";
			font: normal 15px/1 'dashicons';
			vertical-align: middle;
			
		}
		.oa_btn_visibility{
			display:none !important
		}
		</style>
<?php
	}


}