<?php
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/bulma.css">';

$forms = get_posts([
    'post_type'   => 'game_form',
    'post_status' => 'all',
]);

?>

<table class="table">
    <thead>
    <th>ID</th>
    <th>Nom</th>
    <th>Shortcode</th>
    <th>Created at</th>
    <th>Actions</th>
    </thead>
    <tbody>';
    <?php
    foreach ($forms as $form) {
        echo '<tr>';
        echo '<td>'.$form->ID.'</td>';
        echo '<td>'.$form->post_title.'</td>';
        echo '<td>'.'</td>';
        echo '<td>'.$form->post_date.'</td>';
        echo '<td>
                <a href="/better-form/edit/'.$form->ID.'" target="_blank">Edit</a>
                <a href="/better-form/view/'.$form->ID.'" target="_blank">View</a>
            </td>';
        echo '</tr>';
    } ?>
    </tbody>
</table>