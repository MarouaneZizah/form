<?php
	session_start();

	require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );
	include_once( ABSPATH . 'wp-includes/pluggable.php' );

	// error_reporting(1);
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);

	$method = $_SERVER['REQUEST_METHOD'];

	switch ($method) {
		case 'POST':
			$message = "";

			foreach ($_POST['payload'] as $data) {
				$message .= $data['name']." : ".sanitize_text_field( $data["value"] )."</br>";
			}

			$subject = "New contact";
			$to 	 = get_option( 'admin_email' );
			$headers = "From: Admin <$to>" . "\r\n";

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