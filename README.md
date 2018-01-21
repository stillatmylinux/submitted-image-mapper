# submitted-image-mapper
Integrates with AppPresser AppGeo and AppCamera plugins to allow users to submit images and display them on a Google Map

# Install plugin into WordPress
Upload zip file or FTP files to wp-content/plugins.  You might want to remove '-master' from the folder name since you are downloading from Github.

# Activate and configure
Activate the WordPress plugin and go to the settings page located under the AppPresser menu.  Look for the submenu named SIM Settings.  Add your Google API key, lat and long to center your map.  Create two pages: one as a thank you page for submitted photos and another for the drop marker page.

# Pages
You need to create these four pages in your WordPress site:

*Thank you* - This page will display the photo uploaded

*Drop marker page* - This page will display a utility to allow users to added the location of the photo in cases where the geolocation was not available on the photo.

*Recent Map* - This page displays a Google map with markers of the photos submitted in the last three hours.

*Archive Map* - This page diaplay a Google map with markers of the photos submitted in the last three months.

# Shortcodes
Place this short code on the pages you created:

[mapper-recent] - Recent Map page

[sim-need-location-map] - Drop marker page

[mapper-archive] - Archive Map page

[sim-thankyou] - Thank you page