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

function mychildtheme_enqueue_styles() {
    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'mychildtheme_enqueue_styles' );

/* Custom script with no dependencies, enqueued in the header */
function my_scripts_method() {
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array( 'jquery' )
    );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

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

//// Function to change sender name
//function wpb_sender_name( $original_email_from ) {
//    return 'Yoga with Aegialis';
//}
//
//// Hooking up our functions to WordPress filters
//add_filter( 'wp_mail_from', 'wpb_sender_email' );
//add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

// Redirect User after Registration
function custom_registration_redirect() {
    wp_redirect( home_url('/my-account/edit-account/') );
    exit;
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);

//it's generic because you specify post statuses inside the function not via the hook
function retreat_feature_image ( $post ) {
        $id = $post->id;
        $postType = get_post_type($id);
        if ($postType == 'job_listing') {
            $job_cover = get_post_meta($id, '_job_cover', true);
            print_r( get_the_post_thumbnail($id, '_job_cover'));
            global $wpdb;
            $attachment = $wpdb->get_col($wpdb->prepare("SELECT '%s' FROM $wpdb->posts WHERE guid='%s';", $id, $job_cover ));
            set_post_thumbnail( $id, $attachment[0] );
        }
}
add_action('draft_to_publish', 'retreat_feature_image');
add_action('future_to_publish', 'retreat_feature_image');
add_action('private_to_publish', 'retreat_feature_image');

function write_log($log) {
    if (true === WP_DEBUG) {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }
}

function woocommerce_product_custom_fields()
{
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_product_tagline',
            'placeholder' => 'Product Tagline',
            'label' => __('Product Tagline', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => '_custom_start_date',
            'placeholder' => 'Event Start Date',
            'label' => __('Event Start Date', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => '_custom_end_date',
            'placeholder' => 'Event End Date',
            'label' => __('Event End Date', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'          => 'required_payment_percentage',
            'label'       => __( 'Required payment in advance', 'woocommerce' ),
            'desc_tip'    => 'true',
            'description' => __( 'Enter the custom required_payment_percentage number here.', 'woocommerce' )
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'          => 'next_payment_expected',
            'label'       => __( 'Final payment expected', 'woocommerce' ),
            'desc_tip'    => 'true',
            'description' => __( 'Enter the custom next_payment_expected here.', 'woocommerce' )
        )
    );

    //Custom Product Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => '_custom_product_include',
            'placeholder' => 'Product Package Includes',
            'label' => __('Product Package Includes', 'woocommerce')
        )
    );
    woocommerce_wp_textarea_input(
        array(
            'id' => '_custom_product_not_include',
            'placeholder' => 'Product Package Does Not Include',
            'label' => __('Product Package Does Not Include', 'woocommerce')
        )
    );

    woocommerce_wp_textarea_input(
        array(
            'id' => '_custom_product_activities',
            'placeholder' => 'Product Activities',
            'label' => __('Product Activities', 'woocommerce')
        )
    );

    woocommerce_wp_textarea_input(
        array(
            'id' => '_custom_product_program',
            'placeholder' => 'Product Program',
            'label' => __('Product Program', 'woocommerce')
        )
    );

    woocommerce_wp_textarea_input(
        array(
            'id' => '_custom_product_included_excursions',
            'placeholder' => 'Product Excursions',
            'label' => __('Product Excursions', 'woocommerce')
        )
    );
    echo '</div>';
}
// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
// Save Fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');

function add_image_to_product( $listing_id, $product_id ) {

    //get image url from listing
    $ListingCover = get_post_field('_job_cover', $listing_id);
    $ListingGallery = get_post_field('_job_gallery', $listing_id);
    $imageUrl = $ListingCover[0];

    // Add Featured Image to Post
    $image_url        = $imageUrl; // Define the image URL here
    $image_name       = 'wp-header-logo.png';
    $upload_dir       = wp_upload_dir(); // Set upload folder
    $image_data       = file_get_contents($image_url); // Get image data
    $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
    $filename         = basename( $unique_file_name ); // Create image file name

    // Check folder permission and define file location
    if( wp_mkdir_p( $upload_dir['path'] ) ) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    // Create the image  file on the server
    file_put_contents( $file, $image_data );

    // Check image file type
    $wp_filetype = wp_check_filetype( $filename, null );

    // Set attachment data
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    // Create the attachment
    $attach_id = wp_insert_attachment( $attachment, $file, $product_id );

    // Include image.php
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Define attachment metadata
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

    // Assign metadata to attachment
    wp_update_attachment_metadata( $attach_id, $attach_data );

    // And finally assign featured image to post
    set_post_thumbnail( $product_id, $attach_id );
}

//add new product when a listing is submitted
add_action( 'mylisting/submission/done', function( $listing_id ) {
    $listing = \MyListing\Src\Listing::get( $listing_id );
    //write_log('new listing action triggered');

    if ( $listing && $listing->type->get_slug() == 'event' ) {

        //set the featured image for the listing
        $ListingCover = get_post_field('_job_cover', $listing_id);
        $image_url = $ListingCover[0];

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if(wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file, $listing_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        $res2= set_post_thumbnail( $listing_id, $attach_id );


        $title = get_the_title($listing_id);
        $ListingDescription = get_post_field('post_content', $listing_id);
        $ListingAuthor = get_post_field('post_author', $listing_id);
        $Author_name = get_the_author_meta('display_name' , $ListingAuthor);
        $ListingTagline = get_post_field('_job_tagline', $listing_id);
        $ListingSkill = get_post_field('_skill-level', $listing_id);

        $ListingGallery = get_post_field('_job_gallery', $listing_id);
        $ListingDetails = get_post_field('_details', $listing_id);
        $ListingIncludes = get_post_field('_package-includes', $listing_id);
        $ListingNotInclude = get_post_field('_package-doesnt-include', $listing_id);
        $ListingActivities = get_post_field('_activities', $listing_id);
        $ListingProgram = get_post_field('_program', $listing_id);
        $ListingExcursions = get_post_field('_included-excursions', $listing_id);
        $ListingPrice = get_post_field('_price', $listing_id);
        $ListingPriceSingle = get_post_field('_price-for-single-room-', $listing_id);
        $ListingAvailability = get_post_field('_availability', $listing_id);
        $ListingAvailabilityDouble = get_post_field('_availability_double', $listing_id);

        $ListingDepositPercentage = get_post_field('_price_range', $listing_id);
        $ListingRemainingPrice = get_post_field('_remaining-amount', $listing_id);


        global $wpdb;
        $startDate = $wpdb->get_results("SELECT start_date FROM gzq_mylisting_events WHERE listing_id = '$listing_id'");
        $endDate = $wpdb->get_results("SELECT end_date FROM gzq_mylisting_events WHERE listing_id = '$listing_id'");

        //set endDate as expiry_date for every listing '_job_expires'
        update_post_meta( $listing_id, '_job_expires', $endDate );

        $activities = array_values($ListingActivities);

        for($i = 1; $i < count($ListingActivities); $i++) {
            $activities .= $ListingActivities[$i] . ", ";
        }

//        print_r($ListingGallery);
//        print_r($ListingDetails); //null

        $term_obj_list = get_the_terms( $listing_id, 'skill-level' );
        $skill = join(', ', wp_list_pluck($term_obj_list, 'name'));
        $category = get_the_terms( $listing_id, 'job_listing_category' );
        $yogaCats = join(', ', wp_list_pluck( $category, 'name' ));

        $args = array(
            'post_author' => $ListingAuthor,
            'post_content' => $ListingDescription,
            'post_status' => "publish", // (Draft | Pending | Publish)
            'post_title' => $title,
            'post_parent' => '',
            'post_type' => "product"
        );

        // Create a WooCommerce product
        $post_id = wp_insert_post( $args );

        // Setting the product type
        wp_set_object_terms( $post_id, 'variable', 'product_type' );
        update_post_meta( $post_id, '_virtual', 'Yes' );

        // Setting the product price
        update_post_meta( $post_id, '_price', $ListingPriceSingle );
        update_post_meta( $post_id, '_regular_price', $ListingPriceSingle );

        update_post_meta( $post_id, '_custom_product_tagline', $ListingTagline );
        update_post_meta( $post_id, '_custom_product_details', $ListingDetails );
        update_post_meta( $post_id, '_custom_product_include', $ListingIncludes );
        update_post_meta( $post_id, '_custom_product_not_include', $ListingNotInclude );
        update_post_meta( $post_id, '_custom_product_activities', $activities );
        update_post_meta( $post_id, '_custom_product_program', $ListingProgram );
        update_post_meta( $post_id, '_custom_product_included_excursions', $ListingExcursions );
        update_post_meta( $post_id, '_availability', $ListingAvailability );
        update_post_meta( $post_id, '_availability_double', $ListingAvailabilityDouble );
        update_post_meta( $post_id, '_skill', $skill );
        update_post_meta( $post_id, '_yogaCats', $yogaCats );

        $date1 = substr($startDate[0]->start_date, 0, strrpos($startDate[0]->start_date, ' '));
        $date2 = substr($endDate[0]->end_date, 0, strrpos($endDate[0]->end_date, ' '));
        update_post_meta( $post_id, '_custom_start_date',  $date1 );
        update_post_meta( $post_id, '_custom_end_date', $date2 );

        update_post_meta( $post_id, 'required_payment_percentage',  $ListingDepositPercentage );
        update_post_meta( $post_id, 'next_payment_expected', $ListingRemainingPrice );

        //my custom function add image to product
        add_image_to_product( $listing_id, $post_id );

        $attr_label = 'Persons';
        $attr_slug = sanitize_title($attr_label);

        $price_attr = 'Deposit percentage';
        $price_attr_slug = sanitize_title($price_attr);

        $attributes_array[$attr_slug] = array(
            'name' => $attr_label,
            'value' => 'Private double room | Private single room',
            'is_visible' => '1',
            'is_variation' => '1',
            'is_taxonomy' => '0' // for some reason, this is really important
        );

        $attributes_array[$price_attr_slug] = array(
            'name' => $price_attr,
            'value' => 'Full payment 100% | Deposit payment',
            'is_visible' => '1',
            'is_variation' => '1',
            'is_taxonomy' => '0' // for some reason, this is really important
        );

        update_post_meta( $post_id, '_product_attributes', $attributes_array );
        update_post_meta( $post_id, '_manage_stock','Yes' );
        update_post_meta( $post_id, '_stock', $ListingAvailability );
        update_post_meta( $post_id, 'product_author', $ListingAuthor );

        $parent_id = $post_id;
        //creating variation for variable product
        $variation = array(
            'post_title'   => $title . ' (variation)',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_parent'  => $parent_id,
            'post_type'    => 'product_variation'
        );

        $ListingDepositPercentage = substr($ListingDepositPercentage, 0, -1);
        $ListingDepositPercentage = intval($ListingDepositPercentage);

        // double room with deposit
        $variation_id = wp_insert_post( $variation );
        update_post_meta( $variation_id, '_regular_price', $ListingPrice*$ListingDepositPercentage/100 );
        update_post_meta( $variation_id, '_price', $ListingPrice*$ListingDepositPercentage/100 );
        update_post_meta( $variation_id, '_stock', $ListingAvailabilityDouble );
        update_post_meta( $variation_id, 'attribute_' . $attr_slug, 'Private double room' );
        update_post_meta( $variation_id, 'attribute_' . $price_attr_slug, 'Deposit payment' );
        update_post_meta( $variation_id, 'priceRemaining', $ListingPrice - ($ListingPrice*$ListingDepositPercentage/100));
        WC_Product_Variable::sync( $parent_id );

        // double room without deposit
        $variation_id = wp_insert_post( $variation );
        update_post_meta( $variation_id, '_regular_price', $ListingPrice );
        update_post_meta( $variation_id, '_price', $ListingPrice );
        update_post_meta( $variation_id, '_stock', $ListingAvailabilityDouble );
        update_post_meta( $variation_id, 'attribute_' . $attr_slug, 'Private double room' );
        update_post_meta( $variation_id, 'attribute_' . $price_attr_slug, 'Full payment 100%' );
        update_post_meta( $variation_id, 'priceRemaining', 0 );
        WC_Product_Variable::sync( $parent_id );

        //single room with deposit
        $variation_id = wp_insert_post( $variation );
        update_post_meta( $variation_id, '_regular_price', $ListingPriceSingle*$ListingDepositPercentage/100 );
        update_post_meta( $variation_id, '_price', $ListingPriceSingle*$ListingDepositPercentage/100 );
        update_post_meta( $variation_id, '_stock', $ListingAvailability );
        update_post_meta( $variation_id, 'attribute_' . $attr_slug, 'Private single room' );
        update_post_meta( $variation_id, 'attribute_' . $price_attr_slug, 'Deposit payment' );
        update_post_meta( $variation_id, 'priceRemaining', $ListingPriceSingle - ($ListingPriceSingle*$ListingDepositPercentage/100));
        WC_Product_Variable::sync( $parent_id );

        //single room without deposit
        $variation_id = wp_insert_post( $variation );
        update_post_meta( $variation_id, '_regular_price', $ListingPriceSingle );
        update_post_meta( $variation_id, '_price', $ListingPriceSingle );
        update_post_meta( $variation_id, '_stock', $ListingAvailability );
        update_post_meta( $variation_id, 'attribute_' . $attr_slug, 'Private single room' );
        update_post_meta( $variation_id, 'attribute_' . $price_attr_slug, 'Full payment 100%' );
        update_post_meta( $variation_id, 'priceRemaining', 0 );
        WC_Product_Variable::sync( $parent_id );

        //end of variable product creation

        //connect product to listing
        update_post_meta( $listing_id, '_product-id', $post_id );
    }
} );

//update product when a listing is edited
add_action( 'mylisting/submission/listing-updated', function( $listing_id ) {

    $listing = \MyListing\Src\Listing::get( $listing_id );
    $listingType = get_post_meta( $listing_id, '_case27_listing_type');

    if ( $listing && $listing->type->get_slug() == 'event' ) {

        //get product id from listing
        $productID = get_post_field('_product-id', $listing_id);

        //get meta from listing
        $ListingTitle = get_the_title($listing_id);
        $ListingTagline = get_post_field('_job_tagline', $listing_id);
        $ListingDescription = get_post_field('post_content', $listing_id);

        global $wpdb;
        $startDate = $wpdb->get_results("SELECT start_date FROM gzq_mylisting_events WHERE listing_id = '$listing_id'");
        $endDate = $wpdb->get_results("SELECT end_date FROM gzq_mylisting_events WHERE listing_id = '$listing_id'");
        $date1 = substr($startDate[0]->start_date, 0, strrpos($startDate[0]->start_date, ' '));
        $date2 = substr($endDate[0]->end_date, 0, strrpos($endDate[0]->end_date, ' '));

        $term_obj_list = get_the_terms($listing_id, 'skill-level');
        $skill = join(', ', wp_list_pluck($term_obj_list, 'name'));
        $category = get_the_terms($listing_id, 'job_listing_category');
        $yogaCats = join(', ', wp_list_pluck($category, 'name'));

        $ListingPrice = get_post_meta( $listing_id, '_price');
        $ListingPriceSingle = get_post_meta( $listing_id, '_price-for-single-room-');
        $ListingAvailability = get_post_meta( $listing_id, '_availability');
        $ListingAvailabilityDouble = get_post_meta( $listing_id, '_availability_double');
        $ListingIncludes = get_post_meta( $listing_id, '_package-includes');
        $ListingNotInclude = get_post_meta( $listing_id, '_package-doesnt-include');
        $ListingProgram = get_post_meta( $listing_id, '_program');
        $ListingExcursions = get_post_meta( $listing_id, '_included-excursions');
        $ListingActivities = get_post_meta( $listing_id, '_activities');

        $ListingVideo = get_post_meta( $listing_id, '_job_video_url');
        $ListingPricePercentage = get_post_meta( $listing_id, '_price_range');
        $ListingWillBePaidOn = get_post_meta( $listing_id, '_remaining-amount');

        //update product meta
        $my_product = array(
            'ID'           => $productID,
            'post_title'   => $ListingTitle,
            'post_content' => $ListingDescription,
        );

        // Update the post into the database
        wp_update_post( $my_product );

        update_post_meta( $productID, '_virtual', 'Yes' );
        update_post_meta( $productID, '_custom_product_tagline', $ListingTagline );
        update_post_meta( $productID, '_custom_product_include', $ListingIncludes[0] );
        update_post_meta( $productID, '_custom_product_not_include', $ListingNotInclude[0] );
        update_post_meta( $productID, '_custom_product_program', $ListingProgram[0] );
        update_post_meta( $productID, '_custom_product_included_excursions', $ListingExcursions[0] );
        update_post_meta( $productID, '_stock', $ListingAvailability[0] );
        update_post_meta( $productID, '_skill', $skill );
        update_post_meta( $productID, '_yogaCats', $yogaCats );

        update_post_meta( $productID, '_custom_start_date', $date1 );
        update_post_meta( $productID, '_custom_end_date', $date2 );

        update_post_meta( $productID, 'required_payment_percentage', $ListingPricePercentage );
        update_post_meta( $productID, 'next_payment_expected', $ListingWillBePaidOn );

        $activities = implode(", ", $ListingActivities[0]);
        update_post_meta( $productID, '_custom_product_activities', $activities );

        update_post_meta( $productID, '_price', $ListingPrice[0] );
        update_post_meta( $productID, '_regular_price', $ListingPrice[0]);

        $product = wc_get_product($productID);
        $current_products = $product->get_children();
        $doublePrice = $ListingPrice[0];

        update_post_meta( $current_products[0], '_manage_stock','Yes' );
        update_post_meta( $current_products[1], '_manage_stock','Yes' );
        update_post_meta( $current_products[2], '_manage_stock','Yes' );
        update_post_meta( $current_products[3], '_manage_stock','Yes' );

        //var_dump($current_products);
        //array(4) { [0]=> int(8497) [1]=> int(8498) [2]=> int(8499) [3]=> int(8500) }
//        var_dump($ListingPrice[0]); //10 double price full
//        var_dump($ListingPriceSingle[0]); //6 single full price
//        var_dump($ListingAvailability[0]);
//        var_dump($ListingAvailabilityDouble[0]);

        $ListingPricePercentage = substr($ListingPricePercentage[0], 0, -1);
        $ListingPricePercentage = intval($ListingPricePercentage);
        $ListingPricePercentage = $ListingPricePercentage/100;
        //priceRemaining

        //update price for child products
        //for double room, deposit
        $exec = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_regular_price'", $ListingPrice[0]*$ListingPricePercentage, $current_products[0] ) );
        $exec = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_price'", $ListingPrice[0]*$ListingPricePercentage, $current_products[0] ) );
        $execut = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_stock'", $ListingAvailability[0], $current_products[0] ) );
        $priceRemaining = $ListingPrice[0] - $ListingPrice[0]*$ListingPricePercentage;
        update_post_meta( $current_products[0], 'priceRemaining', $priceRemaining);

        //for double room, full price
        $execute = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_regular_price'", $doublePrice, $current_products[1] ) );
        $exec = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_price'", $doublePrice, $current_products[1] ) );
        $execut = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_stock'", $ListingAvailabilityDouble[0], $current_products[1] ) );

        //for single room, deposit
        $execute = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_regular_price'", $ListingPriceSingle[0]*$ListingPricePercentage, $current_products[2] ) );
        $exec = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_price'", $ListingPriceSingle[0]*$ListingPricePercentage, $current_products[2] ) );
        $execut = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_stock'", $ListingAvailabilityDouble[0], $current_products[2] ) );
        $priceRemaining = $ListingPriceSingle[0] - $ListingPriceSingle[0]*$ListingPricePercentage;
        update_post_meta( $current_products[2], 'priceRemaining', $priceRemaining);

        //for single room, full
        $execute = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_regular_price'", $ListingPriceSingle[0], $current_products[3] ) );
        $exec = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_price'", $ListingPriceSingle[0], $current_products[3] ) );
        $execut = $wpdb->query( $wpdb->prepare( "UPDATE `gzq_postmeta` SET meta_value=%d WHERE post_id=%s and meta_key='_stock'", $ListingAvailability[0], $current_products[3] ) );

    }
} );

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function woocommerce_custom_fields_display() {

    global $post;
    $product = wc_get_product($post->ID);
    $post_author = get_post_field('post_author', $post->ID);
    $Author_name = get_the_author_meta('display_name' , $post_author);
    $author_id = $post->post_author;
    if ($post_author) {
        $avatarUrl = get_avatar_url($author_id);
        echo "<p><img id='productAvatar' src='$avatarUrl' width='50' height='50' >";

        $FName = get_user_meta( $author_id, 'first_name', true );
        $LName = get_user_meta( $author_id, 'last_name', true );
        if (strlen($FName)) {
            if (strlen($LName)) {
                echo "".$FName." ".$LName;
            }
        } else {
            echo "".esc_html($Author_name)."</p>";
        }
    }


    $startDate = get_post_meta($post->ID, '_custom_start_date');
    $endDate = get_post_meta($post->ID, '_custom_end_date');
    if ($startDate) {
        if ($endDate) {
            $newStartDate = date("F d Y", strtotime($startDate[0]));
            $newEndDate = date("F d Y", strtotime($endDate[0]));
            echo "<p>Arrival Date: ".date('l', strtotime($startDate[0])).", ".esc_html($newStartDate). "<br>Departure Date: ".date('l', strtotime($endDate[0])).", ".esc_html($newEndDate)."</p>";
        }
    }

    $tagLine = get_post_meta($post->ID, '_custom_product_tagline', false );
    if ($tagLine) {
        //echo "<p>Tag Line: ".esc_html($tagLine[0])."</p>";
    }
//
//    $availability = get_post_meta($post->ID, '_stock', false );
//    if ($availability) {
//        echo "<p>Availability: ".esc_html($availability[0])."</p>";
//    }
}
add_action('woocommerce_before_variations_form', 'woocommerce_custom_fields_display');

function woocommerce_custom_fields_display_after() {
    global $post;
    $product = wc_get_product($post->ID); ?>

    <div class="w-100" id="whatsIncluded">
        <div class="pf-body">
            <h5 style="font-size: 18px">What's included</h5>
            <ul style="font-size:16px;">
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Arrival and departure transfers on Amorgos (port-hotel-port)
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Use of Spa facilities (sauna, hammam, jacuzzi, indoor seawater swimming pool, fitness center)
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Use of Yoga shalas and yoga equipment (mats, blocks, stripes, bolsters, blankets)
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Use of outdoor pool
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> 10% discount on Face and Body treatments
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Unlimited Internet access
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> One 30-minute relaxing massage
                </li>
            </ul>		</div>
    </div>

    <div class="element content-block" id="foodIncluded">
        <div class="pf-head">
            <div class="title-style-1">
                <i class="mi local_dining"></i>
                <h5>Food</h5>
            </div>
        </div>
        <div class="pf-body">
            <p style="font-size:17px;">The following dietary requirement(s) are served and/or catered for:</p><p>

            </p><ul style="font-size:16px;">
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Vegetarian
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Vegan
                </li>
                <li class="facility">
                    <i title="mi check" class="mi check"></i> Other dietary requirements on request
                </li>
            </ul>
        </div>
    </div>
    <?php $included = get_post_meta($post->ID, '_custom_product_include');
            if ($included[0]) { ?>
            <?php echo "<div class='element content-block' id='FoodIncludedInPrice'>
        <div class='pf-head'>
            <div class='title-style-1'>
                <h5>Food Included in the price</h5>
            </div>
        </div>
        <div class='pf-body'>
            <p style='font-size:17px;'></p>
            <ul style='font-size:16px;'>";
            foreach ($included[0] as $value) {
                echo "<li class='facility'>$value";
            }
            echo "</ul></div></div>";
            } ?>

    <?php $notInclude = get_post_meta($post->ID, '_custom_product_not_include');
            if ($notInclude[0]) { ?>
            <?php echo "<div class='element content-block' id='includedInPrice'>
        <div class='pf-head'>
            <div class='title-style-1'>
                <h5 class='productInfoTitle'>Included in the price</h5>
            </div>
        </div>
        <div class='pf-body'>
            <p style='font-size:17px;'></p>
            <ul style='font-size:16px;'>";
            echo "<li class='facility'>".esc_html($notInclude[0])."</li>";
            echo "</ul></div></div>";
            } ?>

    <div class="element content-block" id="CancellationPolicy">
        <div class="pf-head">
            <div class="title-style-1">
                <h5>Cancellation Policy</h5>
            </div>
        </div>
        <div class="pf-body">
            <p style="font-size:17px;">A reservation requires a deposit of 30% of the total price.<br />The deposit is non-refundable, if the booking is cancelled.<br/>
                The rest of the payment should be paid on arrival.</p>
        </div>
    </div>

    <?php
}
add_action('woocommerce_after_single_product', 'woocommerce_custom_fields_display_after');

//add_action( 'mylisting/user-listings/handle-action:delete', [ $this, 'handle_delete_action' ] );

function shop_page_redirect() {
    if( is_shop() ){
        wp_redirect( home_url( '/' ) );
        exit();
    }
}
add_action( 'template_redirect', 'shop_page_redirect' );


function custom_get_availability( $availability, $_product ) {
    global $product;
    $stock = $product->get_total_stock();

    if ( $_product->is_in_stock() ) $availability['availability'] = __($stock . ' SPOTS AVAILABLE', 'woocommerce');
    if ( !$_product->is_in_stock() ) $availability['availability'] = __('SOLD OUT', 'woocommerce');

    return $availability;
}
add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2);

function sv_remove_product_page_skus( $enabled ) {
    if ( is_product() ) {
        return false;
    }
    return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'sv_remove_product_page_skus' );

/* Remove Categories from Single Products */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


function woo_remove_product_tabs( $tabs ) {         // Remove the reviews tab
    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function bbloomer_redirect_checkout_add_cart() {
    return wc_get_checkout_url();
}
add_filter( 'woocommerce_add_to_cart_redirect', 'bbloomer_redirect_checkout_add_cart' );

// function that runs when shortcode is called
function yoga_orders() {

     do_action( 'mylisting/user-listings/before' ) ?>

     <div class="woocommerce">

     <div class="mlduo-account-menu">
     <?php do_action( 'woocommerce_account_navigation' ) ?>
     <div class="cts-prev"></div>
     <div class="cts-next"></div>

     <section class="i-section">
         <div class="container section-body">
             <div class="col-md-12">
                 <div class="woocommerce-MyAccount-content">
                     <div class="woocommerce-notices-wrapper"></div>
            <div class="row my-listings-tab-con">
                <div class="col-md-9 mlduo-welcome-message">
                    <h1><?php _ex( 'Your orders', 'Dashboard welcome message', 'my-listing' ) ?></h1>
                </div>
                <div class="col-md-3">
                    <?php
                    global $current_user;

                    $args = array(
                        'author'        =>  $current_user->ID,
                        'post_type'     =>  'job_listing',
                        'orderby'       =>  'post_date',
                        'order'         =>  'ASC',
                        'posts_per_page' => -1 // no limit
                    );

                    $current_user_posts = get_posts( $args );
                    $total = count($current_user_posts);
                    $result = '';

                    foreach ($current_user_posts as $listing):
                        $id = $listing->ID;
                        $listingType = get_post_meta( $id, '_case27_listing_type', true);
                        //get only retreats from listing types
                        if ($listingType == 'event') {
                            //get product id from listing
                            $productID = get_post_meta( $id, '_product-id', true );
                            // get the orders for each product
                            global $wpdb;
                            $result = $wpdb->get_results( "SELECT * FROM `gzq_wc_order_product_lookup` where product_id ='$productID'");
                        }
                    endforeach
                    ?>
                    </select>
                </div>
            </div>

            <div class="row my-listings-stat-box">

            </div>

            <div id="job-manager-job-dashboard">
                <?php if ( ! $result ) : ?>
                    <div class="no-listings">
                        <i class="no-results-icon material-icons">mood_bad</i>
                        <?php _e( 'You do not have any active listings.', 'my-listing' ); ?>
                    </div>
                <?php else : ?>
                <table class="job-manager-jobs">
                    <tbody>
                    <?php //print_r($result);
                    foreach ( $result as $order ): ?>
                    <?php $myOrder = wc_get_order( $order->order_id );
                    $productID = $order->product_id;
                    $url = get_permalink( $productID );?>
                    <tr class="item-id-<?php print_r($order->order_id) ?> item-product-na item-type-event">
                        <td class="l-type">
                            <div class="info listing-type">
                                <div class="value">
                                    Yoga Retreat: <?php $title = get_post_field( 'post_title', $order->product_id );
                                    print_r($title); ?>
                                </div>
                            </div>
                        </td>
                        <td class="c27_listing_logo">
                            <img src="https://yogawithaegialis.com/wp-content/themes/my-listing/assets/images/marker.jpg">
                        </td>
                        <td class="job_title">
                            <a href="<?php echo $url; ?>">Order id: <?php print_r($order->order_id) ?></a>
                        </td>
                        <td class="job_title">
                            <a href="<?php echo $url; ?>">Cost: <?php print_r($order->product_net_revenue) ?> €</a>
                        </td>
                        <td class="job_title">
                            <a href="<?php echo $url; ?>">Order Status: <?php  $order_status  = $myOrder->get_status();
                                if ($order_status == 'completed') {
                                    echo "<b style='color: green'>Completed<b>";
                                } else {
                                    echo "<b style='color: red'>".$order_status."<b>";
                                }?> </a>
                        </td>
                        <td class="job_title">
                            <a href="<?php echo $url; ?>">Customer Name: <?php echo "".$myOrder->get_billing_first_name()." ".$myOrder->get_billing_last_name().""; ?> </a>
                        </td>
                        <td class="job_title">
                            <a href="<?php echo $url; ?>">Email: <?php echo $myOrder->get_billing_email(); ?> </a>
                        </td>
                        <td class="listing-actions">
                            <ul class="job-dashboard-actions">

                                <li class="cts-listing-action-promote">
                                    <div>
                                        <form method="post" name="update_status">
                                            <button type="submit" name="marked_as_completed">Mark as Completed</button>
                                        </form>
                                        <?php
                                        if (isset($_POST["marked_as_completed"]))
                                        {
                                            $completed_status = $myOrder->get_id();
                                            $myOrder->update_status('completed', 'order_note');
                                        }
                                        ?>
                                    </div>
                                </li>
                                </li><li class="cts-listing-action-delete">
                                    <form method="post" name="update_status">
                                        <button type="submit" name="marked_as_canceled">Delete</button>
                                    </form>
                                    <?php
                                    if (isset($_POST["marked_as_canceled"]))
                                    {
                                        $completed_status = $myOrder->get_id();
                                        $myOrder->update_status('canceled', 'order_note');
                                    }
                                    ?>
                                </li>
                            </ul>
                        </td>
            </div>

            <td class="listing-info">
                <div class="info created-at">
                    <div class="label">Created:</div>
                    <div class="value"><?php print_r($order->date_created) ?></div>
                </div>
            </td>
            </tr>
            <?php endforeach ?>
            </tbody>
            </table>
            <?php endif ?>

            <nav class="job-manager-pagination">
            </nav>
                 </div>
             </div>
        </div>
     </div>
     </div>
    </section>
        <?php
}
// register shortcode
//add_shortcode('myOrders', 'yoga_orders');


// allow only one item in cart, when a product is added the previous one is removed
function woo_custom_add_to_cart( $cart_item_data ) {

    global $woocommerce;
    $woocommerce->cart->empty_cart();

    // Do nothing with the data and return
    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'woo_custom_add_to_cart' );


function notice_at_checkout() {

    global $woocommerce;

    $cart = WC()->cart->get_cart();
    $pid = 0;
    $price = 0;
    $remainingPrice = 0;
    $product =null;
    foreach( $cart as $cart_item_key => $cart_item ){
        $product = $cart_item['data'];
        // Now you have access to (see above)...
        $pid = $product->id;
        $price = get_post_meta( $pid, 'required_payment_percentage', true );
        $remainingPrice = get_post_meta( $pid, 'priceRemaining', true );
    }
    //7018, 7016, 7017
    if ($pid !== 7016) {
        if ($pid !== 7017) {
            if ($pid !== 7018) {
                echo "<div><h4 class='productInfoTitle'>Cancellation Policy</h4>
<p>A reservation requires a deposit of $price of the total price.<br/>The deposit is non-refundable, if the booking is cancelled.<br/>
The rest of the payment should be paid on arrival.</p></div>";
            }
        }
    }
}
add_action( 'woocommerce_checkout_after_customer_details', 'notice_at_checkout' );

function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );

function variation_price_custom_suffix( $variation_data, $product, $variation ) {

    //var_dump($variation_data);
    //echo $variation_data['remaining_payment'];
    $remainingPrice = get_post_meta( $variation_data[ 'variation_id' ], 'priceRemaining', true );
    $pricePercentage = get_post_meta( $product->id, 'required_payment_percentage', true );
    if ($remainingPrice > 0) {
        $variation_data['price_html'] .= ' <span class="price-suffix" style="font-size: 14px;">' . __("<br>The payment of the remaining amount of " . $remainingPrice . "€ must be arranged between you and the retreat teacher.", "woocommerce") . '</span>';
    }
    return $variation_data;
}
add_filter('woocommerce_available_variation', 'variation_price_custom_suffix', 10, 3 );


// 1. Add custom field input @ Product Data > Variations > Single Variation
add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_priceRemaining_to_variations', 10, 3 );
function bbloomer_add_priceRemaining_to_variations( $loop, $variation_data, $variation ) {
    woocommerce_wp_text_input( array(
        'id' => 'priceRemaining[' . $loop . ']',
        'class' => 'short',
        'label' => __( 'priceRemaining Field', 'woocommerce' ),
        'value' => get_post_meta( $variation->ID, 'priceRemaining', true )
    ) );
}

// 2. Save custom field on product variation save
add_action( 'woocommerce_save_product_variation', 'bbloomer_save_priceRemaining_variations', 10, 2 );
function bbloomer_save_priceRemaining_variations( $variation_id, $i ) {
    $priceRemaining = $_POST['priceRemaining'][$i];
    if ( isset( $priceRemaining ) ) update_post_meta( $variation_id, 'priceRemaining', esc_attr( $priceRemaining ) );
}

// 3. Store custom field value into variation data
add_filter( 'woocommerce_available_variation', 'bbloomer_add_priceRemaining_variation_data' );

function bbloomer_add_priceRemaining_variation_data( $variations ) {
    $variations['priceRemaining'] = '<div class="woocommerce_priceRemaining">priceRemaining: <span>' . get_post_meta( $variations[ 'variation_id' ], 'priceRemaining', true ) . '</span></div>';
    return $variations;
}

function yoga_custom_redirect () {

    $myAccountUrl = get_permalink( wc_get_page_id( 'myaccount' ));
    header( "refresh:5;url=$myAccountUrl" );
}
add_action( 'yoga_retreat_just_posted', 'yoga_custom_redirect' );

function notify_instructor( $order_id, $old_status, $new_status ) {

    if ( $new_status == "completed" ) {

        $order = new WC_Order($order_id);
        foreach ( $order->get_items() as $item_id => $item ) {

            $product_id = $item['product_id'];

            // Get the product object
            $product = wc_get_product( $product_id );
            $productTitle = $product->get_title();
            $post_author_id = get_post_meta($product_id, 'product_author');
            $user_info = get_userdata($post_author_id[0]);

            $phone = get_user_meta($post_author_id[0],'billing_phone',true);
            $username = $user_info->user_login;
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            $user_email   = $user_info->user_email;
            $variation_id = $item['variation_id'];
            $_product = wc_get_product( $variation_id );
            $price = $_product->get_price();

            $startDate = get_post_meta($product_id, '_custom_start_date');
            $startDate[0] = str_replace('-"', '/', $startDate[0]);
            $remainingPrice = get_post_meta( $variation_id, 'priceRemaining');

            $subject = "Booking confirmed - ".$first_name." ".$last_name;
            $body = "<html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' style='font-family:Montserrat, sans-serif'>
<head>
    <meta charset=\"UTF-8\">
    <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\">
    <meta name=\"x-apple-disable-message-reformatting\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta content=\"telephone=no\" name=\"format-detection\">
    <title>Your retreat listing is live!</title>
    <!--[if (mso 16)]>
    <style type=\"text/css\">
        a {text-decoration: none;}
    </style>
    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG></o:AllowPNG>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if !mso]> -->
    <link href=\"https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap\" rel=\"stylesheet\">
    <!--<![endif]-->
    <style type=\"text/css\">
        #outlook a {
            padding:0;
        }
        .ii a[href] {
            color: black;
        }
        .es-button {
            mso-style-priority:100!important;
            text-decoration:none!important;
        }
        a[x-apple-data-detectors] {
            color:inherit!important;
            text-decoration:none!important;
            font-size:inherit!important;
            font-family:inherit!important;
            font-weight:inherit!important;
            line-height:inherit!important;
        }
        .es-desk-hidden {
            display:none;
            float:left;
            overflow:hidden;
            width:0;
            max-height:0;
            line-height:0;
            mso-hide:all;
        }
        [data-ogsb] .es-button {
            border-width:0!important;
            padding:10px 30px 10px 30px!important;
        }
        @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1 { font-size:42px!important; text-align:center; line-height:120% } h2 { font-size:26px!important; text-align:center; line-height:120% } h3 { font-size:20px!important; text-align:center; line-height:120% } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:42px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class=\"gmail-fix\"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:16px!important; display:block!important; border-right-width:0px!important; border-left-width:0px!important; border-bottom-width:15px!important; border-top-width:15px!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important } .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } }
    </style>
</head>
<body style=\"width:100%;font-family:Montserrat, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;margin:0\">
<div class=\"es-wrapper-color\" style=\"background-color:#FFFFFF; text-align: center;\">
    <!--[if gte mso 9]>
    <v:background xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"t\">
        <v:fill type=\"tile\" color=\"#ffffff\"></v:fill>
    </v:background>
    <![endif]-->
    <table class=\"es-wrapper\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FFFFFF\">
        <tbody><tr>
            <td valign=\"top\" style=\"padding:0;margin:0\">
                <table cellpadding=\"0\" cellspacing=\"0\" class=\"es-header\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top\">
                    <tbody><tr>
                        <td align=\"center\" style=\"padding:0;margin:0\">
                            <table bgcolor=\"#ffffff\" class=\"es-header-body\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px\">
                                <tbody><tr>
                                    <td align=\"left\" style=\"margin:0;padding-bottom:10px;padding-top:20px;padding-left:20px;padding-right:20px\">
                                        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
                                            <tbody><tr>
                                                <td class=\"es-m-p0r\" valign=\"top\" align=\"center\" style=\"padding:0;margin:0;width:660px\">
                                                    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
                                                        <tbody><tr>
                                                            <td align=\"center\" style=\"padding:0;margin:0;font-size:0px\"><a target=\"_blank\" href=\"https://yogawithaegialis.com/\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#134F5C;font-size:14px\"><img class=\"adapt-img\" src=\"https://yogawithaegialis.com/wp-content/uploads/2021/07/29571625126399250.png\" alt=\"Logo\" style=\"display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic\" height=\"64\" title=\"Logo\"></a></td>
                                                        </tr>
                                                        </tbody></table></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table></td>
                    </tr>
                    </tbody>
                </table>";

            $body .= '<table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
         <tbody><tr> 
          <td align="center" style="padding:0;margin:0"> 
           <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px"> 
             <tbody><tr> 
              <td align="left" style="margin:0; padding:40px 20px 20px 20px;"> 
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                 <tbody><tr> 
                  <td align="center" valign="top" style="padding:0;margin:0;width:660px"> 
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tbody><tr> 
                      <td align="center" class="es-m-txt-l" style="padding:0;margin:0"><h2 style="margin:0;line-height:31px;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-size:26px;font-style:normal;font-weight:normal;color:#333333;text-align:center"><strong>Confirmed booking!&nbsp;👏</strong></h2></td> 
                     </tr> 
                     <tr> 
                      <td align="center" class="es-m-txt-l" style="margin:0;padding-top:5px;padding-bottom:5px"><p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:23px;color:#413e3e;font-size:15px">'.$productTitle.'</p></td> 
                     </tr> 
                     <tr> 
                      <td align="center" class="es-m-txt-l" style="margin:0;padding-bottom:5px;padding-top:10px"><p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">Great news! You have a confirmed booking from '. $first_name." ".$last_name.'.</p><p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">
                      The customer <b>paid you a deposit of '.$price.' €</b> and will arrive on '.$startDate[0].'.<br><br>Remember to arrange any pending details such as arrival information.</p>
                      <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">
                      <br>The customer must <strong>pay the remaining '.$remainingPrice[0].' €</strong>&nbsp;directly to you. Please inform them of how to proceed with the remaining payment.</p></td> 
                     </tr> 
                   </tbody></table></td> 
                 </tr> 
               </tbody></table></td> 
             </tr> 
             <tr> 
              <td align="left" style="margin:0; padding:40px 20px 20px 20px;"> 
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                 <tbody><tr> 
                  <td align="center" valign="top" style="padding:0;margin:0;width:660px"> 
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tbody><tr> 
                      <td align="center" class="es-m-txt-l" style="padding:0;margin:0"><h2 style="margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#333333;text-align:center">Customer details:</h2></td> 
                     </tr> 
                     <tr> 
                      <td align="center" class="es-m-txt-l" style="margin:0;padding-bottom:5px;padding-top:10px"><p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">Fullname: '. $first_name." ".$last_name.'<br>Email: '.$user_email.'<br>Phone No: '.$phone.'</p></td> 
                     </tr></tbody></table></td></tr> 
               </tbody></table></td></tr> 
           </tbody></table></td></tr></tbody></table>';


            $body .= '<table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
    <tbody><tr>
        <td align="center" style="padding:0;margin:0">
            <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                <tbody><tr>
                    <td align="left" style="padding:0;margin:0;padding-left:20px;padding-right:20px;padding-top:40px">
                        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody><tr>
                                <td align="center" valign="top" style="padding:0;margin:0;width:660px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tbody><tr>
                                            <td align="center" class="es-m-txt-l" style="padding:0;margin:0"><h2 style="margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#333333">Need assistance?</h2></td>
                                        </tr>
                                        <tr class="es-mobile-hidden">
                                            <td align="center" class="es-m-txt-c" style="padding:0;margin:0;padding-top:10px;padding-bottom:10px;font-size:0">
                                                <table border="0" width="40%" height="100%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:40% !important;display:inline-table" role="presentation">
                                                    <tbody><tr>
                                                        <td style="padding:0;margin:0;border-bottom:1px solid #cccccc;background:none;height:1px;width:100%;margin:0px"></td>
                                                    </tr>
                                                    </tbody></table></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>
                            </tbody></table></td>
                </tr>
                <tr>
                    <td align="left" style="padding:0;margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px">
                        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody><tr>
                                <td align="left" style="padding:0;margin:0;width:660px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tbody><tr>
                                            <td align="center" class="es-m-txt-l" style="padding:0;margin:0;padding-bottom:5px;padding-top:15px"><h3 style="margin:0;line-height:22px;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-size:18px;font-style:normal;font-weight:normal;color:#333333">Feel free to sen<span style="font-size:19px"></span>d us an email:</h3></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="es-m-txt-l" style="padding:0;margin:0;padding-top:10px;padding-bottom:10px"><span class="es-button-border" style="border-style:solid;border-color:#999999;background:#ffffff;border-width:1px;display:block;border-radius:0px;width:auto"><a href="mailto:support@yogawithaegialis.com" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:16px;border-style:solid;border-color:#ffffff;border-width:10px 30px 10px 30px;display:block;background:#ffffff;border-radius:0px;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center;border-left-width:30px;border-right-width:30px">support@yogawithaegialis.com</a></span></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>
                            </tbody></table></td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
<table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
    <tbody><tr>
        <td align="center" style="padding:0;margin:0">
            <table bgcolor="#ffffff" class="es-footer-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                <tbody><tr>
                    <td align="left" style="padding:0;margin:0;padding-left:20px;padding-right:20px">
                        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody><tr>
                                <td align="left" style="padding:0;margin:0;width:660px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tbody><tr>
                                            <td align="center" style="padding:0;margin:0;padding-top:10px;padding-bottom:20px;font-size:0">
                                                <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tbody><tr>
                                                        <td style="padding:0;margin:0;border-bottom:1px solid #cccccc;background:none;height:1px;width:100%;margin:0px"></td>
                                                    </tr>
                                                    </tbody></table></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>
                            </tbody></table></td>
                </tr>
                <tr>
                    <td align="left" style="padding:0;margin:0;padding-left:20px;padding-right:20px">
                        <!--[if mso]><table style="width:660px" cellpadding="0" cellspacing="0"><tr><td style="width:320px" valign="top"><![endif]-->
                        <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                            <tbody><tr>
                                <td class="es-m-p0r es-m-p20b" align="center" style="padding:0;margin:0;width:320px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tbody><tr>
                                            <td align="center" class="es-m-txt-l" style="padding:0;margin:0;padding-top:15px"><h3 style="margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333">Find us on social media</h3></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>
                            </tbody></table>
                        <!--[if mso]></td><td style="width:20px"></td><td style="width:320px" valign="top"><![endif]-->
                        <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                            <tbody><tr>
                                <td align="center" style="padding:0;margin:0;width:320px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tbody><tr>
                                            <td align="center" class="es-m-txt-l" style="padding:0;margin:0;padding-top:10px;padding-bottom:10px;font-size:0">
                                                <table cellpadding="0" cellspacing="0" class="es-table-not-adapt es-social" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tbody><tr>
                                                        <td align="center" valign="top" style="padding:0;margin:0;padding-right:30px"><a target="_blank" href="https://www.facebook.com/AegialisHotelSpa/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#134F5C;font-size:12px"><img title="Facebook" src="https://yogawithaegialis.com/wp-content/uploads/2021/07/facebook-square-black.png" alt="Fb" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                        <td align="center" valign="top" style="padding:0;margin:0"><a target="_blank" href="https://www.instagram.com/aegialis_hotel_spa" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#134F5C;font-size:12px"><img title="Instagram" src="https://yogawithaegialis.com/wp-content/uploads/2021/07/instagram-square-black.png" alt="Inst" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                    </tr>
                                                    </tbody></table></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>
                            </tbody></table>
                        <!--[if mso]></td></tr></table><![endif]--></td>
                </tr>
                <tr>
                    <td align="left" style="padding:20px;margin:0">
                        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody><tr>
                                <td align="center" valign="top" style="padding:0;margin:0;width:660px">
                                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                        <tbody><tr>
                                            <td align="center" class="es-m-txt-l" style="padding:0;margin:0"><p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:18px;color:#333333;font-size:12px">You are receiving this email because you have visited our site or asked us about the regular newsletter. Make sure our messages get to your Inbox (and not your bulk or junk folders).<br><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#134F5C;font-size:12px;line-height:18px;font-family:arial, \'helvetica neue\, helvetica, sans-serif" href="https://yogawithaegialis.com/privacy-policy/">Privacy police</a> | <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#134F5C;font-size:12px;line-height:18px;font-family:arial, \'helvetica neue\', helvetica, sans-serif" href="https://yogawithaegialis.com/unsubscribe">Unsubscribe</a></p></td>
                                        </tr>
                                        </tbody></table></td>
                            </tr>
                            </tbody></table></td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
</body>
</html>';


            //The email body content 8570 8568 8568
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail( $user_email, $subject, $body, $headers, array( '' ));
        }
    }
}
add_action( 'woocommerce_order_status_changed', 'notify_instructor', 5, 3 );

function custom_checkout_button_text() {

    // Set HERE your specific product ID
    $specific_product_id = array(7016, 7017, 7018);
    $found = false;

    // Iterating trough each cart item
    foreach (WC()->cart->get_cart() as $cart_item)
        if ($cart_item['product_id'] == $specific_product_id[0]) {
            $found = true; // product found in cart
            if ($cart_item['product_id'] == $specific_product_id[1]) {
                $found = true; // product found in cart
                }
            if ($cart_item['product_id'] == $specific_product_id[2]) {
                $found = true; // product found in cart
                }
            }

    // If product is found in cart items we display the custom checkout button
    if($found)
        return __( 'Promote listing', 'woocommerce' ); // custom text Here
    else
        return __( 'Confirm booking', 'woocommerce' ); // Here the normal text
}
add_filter( 'woocommerce_order_button_text', 'custom_checkout_button_text' );

function mp_modify_unsubscribe_confirmation_page( $HTML, $unsubscribeUrl ) {
    $HTML = '<hr>';
    $HTML .= '<center>You can <a href="'.$unsubscribeUrl.'">click here</a> to unsubscribe.</center>';
    $HTML .= '<hr>';
    return $HTML;
}
add_filter( 'mailpoet_unsubscribe_confirmation_page', 'mp_modify_unsubscribe_confirmation_page', 10, 2);

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Debt profile information", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="address"><?php _e("Debt"); ?></label></th>
            <td>
                <input type="number" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'debt', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your debt in euros."); ?></span>
            </td>
        </tr>
    </table>
<?php }
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }

    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'debt', $_POST['address'] );
}
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function user_debt_on_order_completed( $order_id ) {

    $order = new WC_Order( $order_id );
    $items = $order->get_items();
    $product_variation_id = '';
    foreach ( $items as $item ) {
        $product_name = $item['name'];
        $product_id = $item['product_id'];
        $product_variation_id = $item['variation_id'];
    }
    print_r($product_variation_id);
    $product = wc_get_product( $product_variation_id );
    $fullPrice = $product->get_price();
    $percentage = get_post_meta( $product_variation_id, 'required_payment_percentage');
    $percentage = substr($percentage, 0, -1); //removing '%'
    print_r($percentage);
    die;

}
//add_action( 'woocommerce_order_status_completed', 'user_debt_on_order_completed', 10, 1 );