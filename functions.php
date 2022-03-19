<?php

add_action( 'parse_request', function( $wp ){
    // The regex can be changed depending on your needs
    if ( preg_match( '#^better-form/view/([0-9]+)#', $wp->request, $matches ) ) {
        // Get the Leaf Number
        $form_id = $matches[1];

        // Define it for my-plugin's index.php
        $_GET['form_id'] = urldecode($form_id);

        // Load your file - make sure the path is correct.
        include_once WP_CONTENT_DIR . '/plugins/form/render.php';
        exit; // and exit
    }

    if ( preg_match( '#^better-form/edit/([0-9]+)#', $wp->request, $matches ) ) {
        // Get the Leaf Number
        $form_id = $matches[1];

        // Define it for my-plugin's index.php
        $_GET['form_id'] = urldecode($form_id);

        // Load your file - make sure the path is correct.
        include_once WP_CONTENT_DIR . '/plugins/form/form.php';
        exit; // and exit
    }
});

/*function custom_rewrite_basic()
{
    add_rewrite_rule('better-form/edit/([0-9]+)/?', 'wp-content/plugins/form/form.php?form_id=$matches[1]', 'top');
    add_rewrite_rule('better-form/view/([0-9]+)/?', 'wp-content/plugins/form/render.php?form_id=$matches[1]', 'top');
}*/

//add_action('init', 'custom_rewrite_basic', 10, 0);

/*function better_form_query_vars($query_vars)
{
    $query_vars[] = 'form_id';

    return $query_vars;
}*/

//add_filter('query_vars', 'better_form_query_vars');