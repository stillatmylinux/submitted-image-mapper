<div class="sim-map-content">
	<p><b><?php echo $data->location ?></b></p>
	<div>
		<p><?php echo $data->description ?></p>
		<?php
			if($data->image) {
				echo '<img style="margin-top:3px" src="'.$data->image.'">';
			}
		?>
		<p>Credit: <?php echo $data->name ?><br>
		(<?php echo $data->getDate() ?>).</p>
		<?php if(current_user_can('edit_posts')) edit_post_link('Edit', '', '', $data->getPost()->ID); ?>
	</div>
</div>