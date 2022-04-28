<?php

add_action( 'parse_request', function( $wp ){
    // The regex can be changed depending on your needs
    if ( preg_match( '#^better-form/view/([0-9]+)#', $wp->request, $matches ) ) {
        // Get the Leaf Number
        $form_id = $matches[1];

        // Define it for my-plugin's index.php
        $_GET['form_id'] = urldecode($form_id);

        // Load your file - make sure the path is correct.
        include_once WP_CONTENT_DIR . '/plugins/better-form/render.php';
        exit; // and exit
    }

    if ( preg_match( '#^better-form/edit/([0-9]+)#', $wp->request, $matches ) ) {
        // Get the Leaf Number
        $form_id = $matches[1];

        // Define it for my-plugin's index.php
        $_GET['form_id'] = urldecode($form_id);

        // Load your file - make sure the path is correct.
        include_once WP_CONTENT_DIR . '/plugins/better-form/form.php';
        exit; // and exit
    }
});