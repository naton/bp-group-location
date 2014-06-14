<?php
/*
Plugin Name: BP Group Location
Plugin URI: https://github.com/naton/bp-group-location
Description: Adds geo location to BuddyPress groups (and a mashup map to their directory page)
Author: Anton Andreasson
Version: 1.0
Author URI: http://andreasson.org/
*/

/* Only load code that needs BuddyPress to run once BP is loaded and initialized. */
function group_location_init() {
	require( dirname( __FILE__ ) . '/bp-group-location.php' );
}
add_action( 'bp_include', 'group_location_init' );
