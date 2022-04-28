<?php
//    error_reporting(1);
//    ini_set('display_errors', '1');
//    ini_set('display_startup_errors', '1');
//    error_reporting(E_ALL);

	require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );
	include_once( ABSPATH . 'wp-includes/pluggable.php' );

	$method = $_SERVER['REQUEST_METHOD'];

	switch ($method) {
		case 'POST':
            $emails     = sanitize_text_field($_POST['emails']);
            $origin_url = sanitize_text_field($_POST['origin_url']);

            if(!$emails) {
                $email = get_option( 'admin_email' );
            }

			$message = "";

			foreach ($_POST['data'] as $data) {
				$message .= $data['name']." : ".sanitize_text_field( $data["value"] )."\n";
			}

            $message .= "Source : ".$origin_url."\n";

			$subject = "New contact";
			$to 	 = $emails;
			$headers = "From: Admin <".get_option('admin_email').">" . "\r\n";

			// If email has been process for sending, display a success message
			if ( wp_mail($to, $subject, $message, $headers ) ) {
				echo "<div><p>Thanks for contacting me, expect a response soon.</p></div>";
			} else {
				echo 'An unexpected error occurred';
			}

			break;

		default:
			echo "Methode not supported";

			break;
	}
?>