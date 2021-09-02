<?php

namespace MyListing\Src\Notifications;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Message_Received_User_Notification extends Base_Notification {

	public $message, $sender_listing, $receiver_listing;

	public static function hook() {
		add_action( 'mylisting/messages/send-notification', function( $message ) {
			return new self( [ 'message' => $message ] );
		} );
	}

	public static function settings() {
		return [
			'name' => _x( 'Notify users when they receive a new private message', 'Notifications', 'my-listing' ),
			'description' => _x( 'Send an email to the user when they receive new private messages.', 'Notifications', 'my-listing' ),
		];
	}

	/**
	 * Validate and prepare notification arguments.
	 *
	 * @since 2.1
	 */
	public function prepare( $args ) {
		if ( empty( $args['message'] ) || ! $args['message'] instanceof \MyListing\Ext\Messages\Messages ) {
			throw new \Exception( 'Invalid message provided.' );
		}

		$this->message = $args['message'];

        $listing_id = absint( $this->message->get_listing_id() );
        $listing = \MyListing\Src\Listing::get( $listing_id );
        if ( $listing_id && $listing ) {
			// check if sender or receiver is a listing profile
        	if ( absint( $this->message->sender->ID ) === absint( $listing->get_author_id() ) ) {
        		$this->sender_listing = $listing;
        	} elseif ( absint( $this->message->receiver->ID ) === absint( $listing->get_author_id() ) ) {
        		$this->receiver_listing = $listing;
        	}
        }
	}

	public function get_mailto() {
		return $this->message->receiver->user_email;
	}

	public function get_subject() {
		if ( $this->sender_listing ) {
			return sprintf(
				_x( 'You received an inquiry %s.', 'Notifications', 'my-listing' ),
				esc_html( $this->sender_listing->get_name() )
			);
		} elseif ( $this->receiver_listing ) {
			return sprintf(
				_x( 'New message received from %s on %s.', 'Notifications', 'my-listing' ),
				esc_html( $this->message->sender->display_name ),
				esc_html( $this->receiver_listing->get_name() )
			);
		} else {
			return sprintf(
				_x( 'New message received from %s.', 'Notifications', 'my-listing' ),
				esc_html( $this->message->sender->display_name )
			);
		}
	}

	public function get_message() {
		$template = new Notification_Template;

		$template->add_paragraph( sprintf(
			_x( '<div align="center" style="font-size: 22px;">Hey %s,</div>', 'Notifications', 'my-listing' ),
			esc_html( $this->message->receiver->first_name )
		) );

		if ( $this->sender_listing ) {
			$template->add_paragraph( sprintf(
				_x( '<div align="center" style="font-size: 22px;">You received an inquiry from %s:</div>', 'Notifications', 'my-listing' ),
				esc_html( $this->sender_listing->get_name() )
			) );
		} elseif ( $this->receiver_listing ) {
			$template->add_paragraph( sprintf(
				_x( '<div align="center" style="font-size: 15px;">You have received a new message from user %s on listing <strong>%s</strong>:</div>', 'Notifications', 'my-listing' ),
				esc_html( $this->message->sender->display_name ),
				esc_html( $this->receiver_listing->get_name() )
			) );
		} else {
			$template->add_paragraph( sprintf(
				_x( '<div align="center" style="font-size: 15px;">You have received a new message from user %s:</div>', 'Notifications', 'my-listing' ),
				esc_html( $this->message->sender->display_name )
			) );
		}

		$template->add_paragraph( '<div align="center" style="font-size: 22px;"><em>'.wp_kses( stripslashes( $this->message->message ), ['br', 'a'] ).'</em></div>' );

		$template
			->add_break()
			->add_primary_button( sprintf(
				_x( '<div align="center" style="font-size: 22px;">Reply now </div>', 'Notifications', 'my-listing' ),
				get_bloginfo('name')
			), home_url('/') );

		return $template->get_body();
	}

}