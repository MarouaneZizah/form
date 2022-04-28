<?php
session_start();

require_once(explode("wp-content", __FILE__)[0]."wp-load.php");
include_once(ABSPATH.'wp-includes/pluggable.php');

//error_reporting(1);
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $form_id      = $_GET['id'];
    $content_post = get_post($form_id);

    if (!$content_post) {
        echo "Form doesn't exist";
        return;
    }

    $content           = $content_post->post_content;
    $content_formatted = maybe_unserialize($content);

    wp_send_json($content_formatted);
}
else {
    echo "Methode not allowed";
}
?>