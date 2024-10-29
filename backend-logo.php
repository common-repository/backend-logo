<?php
/*
Plugin Name: Backend Login Logo
Plugin URI: http://www.mretzlaff.com/
Description: Set your own WordPress backend login logo
Author: M. Retzlaff
Version: 1.1
Author URI: http://www.mretzlaff.com/
Update Server: http://www.mretzlaff.com/mySoftware/wp/backend-logo/
*/

/*
This plugin is (c) Copyright 2009 by M. Retzlaff (www.mretzlaff.com).
Changes, copies and reproductions are not allowed without written permission by the author.
All rights reserved. Alle Rechte vorbehalten.
Some components are copyright by their authors and not under effect of this plugin.
Your donation (http://www.mretzlaff.com/donate/) will help to upgrade and update this plugin.
All your wishes regarding this plugin can be written to: "plugin-wishes@mretzlaff.com"
*/

function wp_backend_login() {
	// Get the logo folder within the plugin path
	$path = sprintf("%s/wp-content/plugins/backend-logo/logo/",
		$_SERVER["DOCUMENT_ROOT"]);

	// Detect the default login logo
	$def = "default." . (file_exists($path."default.gif") ? "gif" : "jpg");

	// Generate the logo filename for the current domain
	$jpg = sprintf("%s%s.jpg",
		$path,
		$_SERVER["SERVER_NAME"]);
	$gif = sprintf("%s%s.gif",
		$path,
		$_SERVER["SERVER_NAME"]);

	// Overwrite the CSS style
	echo "<style>\nh1 a {\n background: url('";	

	// If there exists a domain specific logo-file, use that one.
	// Otherwise use the default logo
	if (file_exists($gif))
		echo sprintf("/wp-content/plugins/backend-logo/logo/%s.gif", $_SERVER["SERVER_NAME"]);
	else
	if (file_exists($jpg))
		echo sprintf("/wp-content/plugins/backend-logo/logo/%s.jpg", $_SERVER["SERVER_NAME"]);
	else
		echo "/wp-content/plugins/backend-logo/logo/$def";

	echo "') no-repeat top center; }\n";
	echo "</style>\n";
}

function bll_PluginLinks($links, $file) {
	global $domain;

	$plugin = plugin_basename(__FILE__);
 	if ($file == $plugin) {
		return array_merge(
			$links,
			array(sprintf('<a href="http://www.mretzlaff.com/forum/" target="mre_website">%s</a>', __("Forum", $domain))),
			array(sprintf('<a href="http://www.mretzlaff.com/donate/" target="mre_website">%s</a>', __("Donate", $domain)))
		);
	}
 
	return $links;
}

add_action('login_head', 'wp_backend_login');
add_filter("plugin_row_meta", "bll_PluginLinks", 10, 2);

?>