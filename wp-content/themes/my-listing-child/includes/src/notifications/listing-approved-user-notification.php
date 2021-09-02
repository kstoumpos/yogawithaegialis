<?php

namespace MyListing\Src\Notifications;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Listing_Approved_User_Notification extends Base_Notification {

	public
		$listing,
		$author;

	public static function hook() {
		add_action( 'transition_post_status', function( $new_status, $old_status, $post ) {
			// validate listing
			if ( ! ( $post && $post->post_type === 'job_listing' ) ) {
				return;
			}

			// only run this when a listing gets published from the following statuses: preview, pending, pending_payment, and expired.
			if ( ! ( $new_status === 'publish' && in_array( $old_status, [ 'preview', 'pending', 'pending_payment', 'expired' ], true ) ) ) {
				return;
			}

			return new self( [ 'listing-id' => $post->ID ] );
		}, 40, 3 );
	}

	public static function settings() {
		return [
			'name' => _x( 'Notify users on listing approvals', 'Notifications', 'my-listing' ),
			'description' => _x( 'Send an email to the user whenever one of their submitted listings has been approved and published.', 'Notifications', 'my-listing' ),
		];
	}

	/**
	 * Validate and prepare notification arguments.
	 *
	 * @since 2.1
	 */
	public function prepare( $args ) {
		if ( empty( $args['listing-id'] ) ) {
			throw new \Exception( 'No listing ID provided.' );
		}

		$listing = \MyListing\Src\Listing::force_get( $args['listing-id'] );
		if ( ! ( $listing && $listing->get_author() && $listing->get_status() === 'publish' ) ) {
			throw new \Exception( 'Invalid listing ID: #'.$args['listing-id'] );
		}

		$this->listing = $listing;
		$this->author = $listing->get_author();
	}

	public function get_mailto() {
		return $this->author->user_email;
	}

	public function get_subject() {
		return sprintf( _x( 'You retreat listing is live ✔️', 'Notifications', 'my-listing' ), esc_html( $this->listing->get_name() ) );
	}

	public function get_message() {
		$template = new Notification_Template;

		$template->add_paragraph( sprintf(
			_x( '<div align="center" style="margin-top: -30px;margin-bottom: 40px;"><span style="margin: 0;line-height:30px;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;font-size:25px;font-style:normal;font-weight:normal;color:#333333">Your retreat listing is live!<br></span></div>', 'Notifications', 'my-listing' ),
			esc_html( $this->author->first_name )
		) );

		$template->add_paragraph( sprintf(
			_x( '<div align="center" style="margin-bottom: -10px;padding-top:5px;padding-bottom:5px;padding-right:40px background-color: white;"><span style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;line-height:24px;color:#333333;font-size:16px">Hey %s we have some great news for you!<br>Your yoga retreat listing %s has been approved and published!</span></div><br>', 'Notifications', 'my-listing' ),
            esc_html( $this->author->first_name ),
            esc_html( $this->listing->get_name() )
		) );

        $template->add_break()->add_primary_button(
            _x( '<div align="center" style="font-size: 16px;
                color: aliceblue;
                border-style: solid;
                border-color: #999999;
                background: #000000;
                border-width: 1px;
                display: inline-block;
                border-radius: 0;
                width: auto;
                padding: 10px 10px 10px 10px;">View yoga retreat</div><br>', 'Notifications', 'my-listing' ),
            esc_url( $this->listing->get_link() )
        );

		return $template->get_body();
	}

}