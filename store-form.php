<?php
session_start();

require_once(explode("wp-content", __FILE__)[0]."wp-load.php");
include_once(ABSPATH.'wp-includes/pluggable.php');

//error_reporting(1);
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $_POST = json_decode(file_get_contents("php://input"), true);

    $form_id = $_GET['id'];

    $assets     = $_POST["gjs-assets"];
    $components = $_POST["gjs-components"];
    $css        = $_POST["gjs-css"];
    $html       = $_POST["gjs-html"];
    $styles     = $_POST["gjs-styles"];

    $form = get_post($form_id);

    $id = wp_update_post([
        'ID'           => $form_id,
        'post_title'   => 'Form',
        'post_type'    => 'game_form',
        'post_content' => maybe_serialize([
            "assets"     => $assets,
            "components" => $components,
            "css"        => $css,
            "html"       => $html,
            "styles"     => $styles,
        ]),
    ]);

    echo "Form is submitted $id";
}
else {
    echo "Method not allowed";
}
?>