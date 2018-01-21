<?php

class SimAdminPage {

	public function hooks() {
		add_action('admin_menu', array($this, 'admin_init'));
	}

	public function admin_init() {
		add_submenu_page( 'apppresser_settings', 'Submit Image Settings', 'SIM Settings', 'manage_options', 'sim-settings', array($this, 'setting_page') );
	}

	public function setting_page() {

		if(isset($_POST['sim-thankyou-page'], $_POST['sim-drop-marker-page'], $_POST['sim-google-api'])) {
			update_option('sim-thankyou-page', $_POST['sim-thankyou-page']);
			update_option('sim-drop-marker-page', $_POST['sim-drop-marker-page']);
			update_option('sim-google-api', $_POST['sim-google-api']);
		}

		$sim_google_api = get_option('sim-google-api');
		
		?>
		<form action="<?php echo esc_url( admin_url( 'admin.php?page=sim-settings' ) ); ?>" method="post" dir="ltr">
			<div class="wrap sim_settings">
			<h2>Submit Image Settings</h2>
			<p></p>

			<label for="sim-google-api">
				<input type="text" class="regular-text" name="sim-google-api" value="<?php echo $sim_google_api ?>"> Google API key
			</label>

			<p>Select pages where you have placed the shortcodes.</p>

			<label for="sim-thankyou-page">
			<?php
			$this->page_dropdown( 'sim-thankyou-page' );

			?>Thank you page</label>
			
			<br><br>
			
			<label for="sim-drop-marker-page">
			<?php
			$this->page_dropdown( 'sim-drop-marker-page' );

			?>Drop marker page</label>
			</div>

			<p><input type="submit" class="button-primary" value="Save Settings"></p>
		</form>
		<?php
	}

	public function page_dropdown( $setting_key ) {

		$selected_page = get_option( $setting_key );

		?>
		<select name="<?php echo $setting_key ?>"> 
			<option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option> 
			<?php
				$pages = get_pages(); 
				foreach ( $pages as $page ) {
					$option = '<option value="' . $page->ID . '" ';
					$option .= ( $page->ID == $selected_page ) ? 'selected="selected"' : '';
					$option .= '>';
					$option .= $page->post_title;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select>
		<?php
	}
}