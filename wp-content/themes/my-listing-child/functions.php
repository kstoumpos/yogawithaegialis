<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'mylisting-google-maps','mylisting-icons','mylisting-vendor','mylisting-frontend','theme-styles-default','theme-styles-default','mylisting-messages' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 1000 );

// END ENQUEUE PARENT ACTION

/* Custom script with no dependencies, enqueued in the header */
function my_scripts_method() {
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array( 'jquery' )
    );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function mychildtheme_enqueue_styles() {
    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'mychildtheme_enqueue_styles' );

/* Custom script for different logo on mobile devices, enqueued in the header */
function mobileLogo() {
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/js/mobileLogo.js',
        array( 'jquery' )
    );
}
add_action( 'wp_enqueue_scripts', 'mobileLogo' );

function my_header_scripts(){
    ?>
    <script>
        //console.log("script start");
        if (window.innerWidth < 480) {
            document.addEventListener('DOMContentLoaded', function() {
            console.log("width less than 480");
            document.getElementById("myLogo").src="https://yogawithaegialis.com/wp-content/uploads/2021/03/yogawithaegialis_mobilelogo.svg";
            }, false);
        }
    </script>
    <?php
}
add_action( 'wp_head', 'my_header_scripts' );

function myscript() {
	?>
    <script type="text/javascript">
        let element = document.getElementsByClassName("elementor-element-ba8a4d2");
        //console.log("sticky button selected");
        document.addEventListener('DOMContentLoaded', function() {
            // document.getElementById('stickyButton')[1].style.display = 'none';
            // console.log("sticky button selected");
            setInterval(function(){
                // document.getElementById('stickyButton')[1].style.display = 'none';
                // console.log("sticky button selected");
            },3000);
        }, false);
    </script>
	<?php
}
add_action('wp_footer', 'myscript');

function redirectAtLogout() {
	wp_redirect(home_url());
	exit();
}
add_action( 'wp_logout', 'redirectAtLogout' );

function logout_without_confirm($action, $result)
{
	/**
	 * Allow logout without confirmation
	 */
	if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
		$redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : home_url();
		$location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
		header("Location: $location");
		die;
	}
}
add_action('check_admin_referer', 'logout_without_confirm', 10, 2);

function wc_login_redirect( $redirect_to ) {
    $redirect_to = 'https://yogawithaegialis.com/my-account/';
    return $redirect_to;
}
add_filter('woocommerce_login_redirect', 'wc_login_redirect');

// Function to change email address
function wpb_sender_email( $original_email_address ) {
    return 'info@yogawithaegialis.com';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'Yoga with Aegialis';
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

// Redirect User after Registration
function custom_registration_redirect() {
    wp_redirect( home_url('/verification/') );
    exit;
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);