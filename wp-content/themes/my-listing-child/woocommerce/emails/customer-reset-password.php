<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
        <tbody><tr>
            <td align="center" style="padding:0;Margin:0">
                <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                    <tbody><tr>
                        <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;padding-top:30px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tbody><tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tbody><tr>
                                                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:32px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:21px;font-style:normal;font-weight:normal;color:#333333;text-align:center"><b>Password reset request</b></h2></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table></td>
                    </tr>
                    <tr>
                        <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tbody><tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tbody><tr>
                                                <td align="center" class="es-m-txt-l" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">Someone has requested a new password for your account on Yoga with Aegialis If you didn't make this request, just ignore this email. If you'd like to proceed:</p></td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:0;Margin:0;padding-top:15px"><span class="es-button-border" style="border-style:solid;border-color:#999999;background:#1d1c1c;border-width:0px;display:inline-block;border-radius:0px;width:auto"><a href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>" class="es-button es-button-1" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#ffffff;font-size:16px;border-style:solid;border-color:#1d1c1c;border-width:10px 30px;display:inline-block;background:#1d1c1c;border-radius:0px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center">Reset Password</a></span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="es-m-txt-l" style="padding:0;Margin:0;padding-bottom:5px;padding-top:10px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Can't see the button? <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#134F5C;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>">click here to reset your password</a></p></td>
                                            </tr>
                                            </tbody></table></td>
                                </tr>
                                </tbody></table></td>
                    </tr>
                    </tbody></table></td>
        </tr>
        </tbody></table>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
//if ( $additional_content ) {
//	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
//}

do_action( 'woocommerce_email_footer', $email );
