# submitted-image-mapper
Integrates with AppPresser AppGeo and AppCamera plugins to allow users to submit images and display them on a Google Map

# Install plugin into WordPress
Upload zip file or FTP files to wp-content/plugins.  You might want to remove '-master' from the folder name since you are downloading from Github.

# Activate and configure
Activate the WordPress plugin and go to the settings page located under the AppPresser menu.  Look for the submenu named SIM Settings.  Add your Google API key, lat and long to center your map.  Create two pages: one as a thank you page for submitted photos and another for the drop marker page.

# Pages
You need to create these four pages in your WordPress site:

**Submit photos page** - The form where users choose to upload or take a photo

**Thank you** - This page will display the photo uploaded

**Drop marker page** - This page will display a utility to allow users to added the location of the photo in cases where the geolocation was not available on the photo.

**Recent Map** - This page displays a Google map with markers of the photos submitted in the last three hours.

**Archive Map** - This page diaplay a Google map with markers of the photos submitted in the last three months.

# Shortcodes
Place this short code on the pages you created:

**[app-camera action="new" post_type="submitted-pic"]** - Submit photos page

**[mapper-recent]** - Recent Map page

**[sim-need-location-map]** - Drop marker page

**[mapper-archive]** - Archive Map page

**[sim-thankyou]** - Thank you page

# AppPresser Custom JS
AppPresser has a feature where you can add custom javascript to the builder on myapppresser.com.  You need to use this feature.  Log into your myapppresser.com account and navigate to the customizer and to the settings tab and scroll down to the custom js field.  Now you need to upload the custom.js file to that field.  Locate the custom.js file in this plugin located under the js/ folder, js/custom.js.

**Cordova Camera plugin with EXIF**
The app needs to be built with a different cordova camera plugin.  This setting is in the app's config.xml file.  To replace this you need to download the zip file from general tab on your app at myapppresser.com:

https://myapppresser.com/{{YOUR-SUBSITE}}/apps/{{YOUR-APP}}/#settings

1. Download the latest zip
2. Unzip the file
3. Open config.xml
4. Find this line:

<plugin name="cordova-plugin-camera" source="npm" spec="2.3.1">

5. Replace it with this line:

<plugin name="cordova-plugin-camera-with-exif" source="npm">

6. Save the file
7. Zip the app files again
8. Upload the zip file at https://build.phonegap.com/

You'll have to do these steps after each time you run the builder in myapppresser.com because it will overwrite the config.xml file.