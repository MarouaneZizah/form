<?php
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/fontawesome/css/all.min.css">';
echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/bulma.css">';
echo '<script src="'.plugin_dir_url(__FILE__).'js/axios.min.js"></script>';

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
			<?php foreach ($forms as $form) {
				echo '<tr>';
				echo '<td>'.$form->ID.'</td>';
				echo '<td>'.$form->post_title.'</td>';
				echo '<td>'.'</td>';
				echo '<td>'.$form->post_date.'</td>';
				echo '<td>
						<a href="/wp-content/plugins/form/form.php?id='. $form->ID .'" target="_blank">Edit</a>
						<a href="/wp-content/plugins/form/render.php?id='. $form->ID .'" target="_blank">View</a>
					</td>';
				echo '</tr>';
			}?>
		</tbody>
	</table>