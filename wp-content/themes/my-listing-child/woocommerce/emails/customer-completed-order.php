<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<?php

foreach ( $order->get_items() as $item_id => $item ) {

    $product_id = $item['product_id'];

    // Get the product object
    $product = wc_get_product($product_id);
    $productTitle = $product->get_title();
    $post_author_id = get_post_meta($product_id, 'product_author');
    $user_info = get_userdata($post_author_id[0]);

    $phone = get_user_meta($post_author_id[0], 'billing_phone', true);
    $username = $user_info->user_login;
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $user_email = $user_info->user_email;
    $variation_id = $item['variation_id'];
    $_product = wc_get_product($variation_id);
    $price = $_product->get_price();

    $startDate = get_post_meta($product_id, '_custom_start_date');
    $startDate[0] = str_replace('-"', '/', $startDate[0]);
    $endDate = get_post_meta($product_id, '_custom_end_date');
    $endDate[0] = str_replace('-"', '/', $endDate[0]);
    $remainingPrice = get_post_meta($variation_id, 'priceRemaining');

    $listing_id = get_post_meta( $product_id, 'listingId');
}

?>

    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
        <tbody><tr>
            <td align="center" style="padding:0;Margin:0">
                <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                    <tbody><tr>
                        <td align="left" style="Margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px;padding-top:40px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tbody><tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tbody><tr>
                                                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:33px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:22px;font-style:normal;font-weight:normal;color:#333333;text-align:left"><strong>Thank you&nbsp;<?php echo $username; ?>, your booking for <?php echo $productTitle; ?> has been confirmed!</strong></h2></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table></td>
                    </tr>
                    <tr>
                        <td align="left" style="padding:20px;Margin:0">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tbody><tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tbody><tr>
                                                <td align="center" class="es-m-txt-l" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#333333;text-align:left">Reservation details:</h2></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0;padding-bottom:5px;padding-top:10px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">
                                                        Check-in: <?php echo $startDate[0]; ?> 2:00 PM
                                                        <br>Check-out: <?php echo $endDate[0]; ?> 12:00 PM
                                                        <br>Your reservation: <?php echo $productTitle; ?><br>
                                                        Paid: <?php echo $price; ?> €&nbsp; (deposit payment)
                                                        <br>Remaining amount: <?php echo $remainingPrice[0]; ?> €</p></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table></td>
                    </tr>
                    <tr>
                        <td align="left" style="Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;padding-bottom:30px">
                            <!--[if mso]><table style="width:660px" cellpadding="0" cellspacing="0"><tr><td style="width:324px" valign="top"><![endif]-->
                            <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                <tbody><tr>
                                    <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:324px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tbody><tr>
                                                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px"><strong>Get in touch with the retreat organizer</strong>
                                                        <br><?php echo $first_name." ".$last_name; ?>
                                                        <br><?php echo $user_email; ?>
                                                        <br><?php echo $phone; ?></p></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table>
                            <!--[if mso]></td><td style="width:10px"></td><td style="width:326px" valign="top"><![endif]-->
                            <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                <tbody><tr>
                                    <td align="left" style="padding:0;Margin:0;width:326px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tbody><tr>
                                                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px"><strong>Get in touch with Aegialis (hotel)</strong><br>Aegialis Hotel &amp; Spa<br><a target="_blank" href="mailto:info@aegialis.com" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#134F5C;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif">info@aegialis.com</a><br><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#134F5C;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif" href="tel:00302285073393">+30 22850 73393</a><br></p></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table>
                            <!--[if mso]></td></tr></table><![endif]--></td>
                    </tr>
                    </tbody></table></td>
        </tr>
        </tbody></table>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
