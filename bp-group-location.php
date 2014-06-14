<?php
	
/**
 * The class_exists() check is recommended, to prevent problems during upgrade
 * or when the Groups component is disabled
 */
if ( class_exists( 'BP_Group_Extension' ) ) :
 
class Group_Location extends BP_Group_Extension {
	/**
	 * Your __construct() method will contain configuration options for 
	 * your extension, and will pass them to parent::init()
	 */
	function __construct() {
		$args = array(
			'slug' => 'location',
			'name' => 'Group Location'
		);
		parent::init( $args );
	}
 
	/**
	 * display() contains the markup that will be displayed on the main 
	 * plugin tab
	 */
	function display() {
		$group_id = bp_get_group_id();
		$setting = groups_get_groupmeta( $group_id, 'group_location' );
		$group_location = (isset($setting[0])) ? $setting[0] : '<a href=\"../admin/' . $this->slug . '\">?</a>';
		$group_location_lat = (isset($setting[1])) ? $setting[1] : '58.25';
		$group_location_long = (isset($setting[2])) ? $setting[2] : '13.06';
		
		wp_enqueue_style( 'group-location1', plugin_dir_url( __FILE__ ) . 'css/group-location.css' );
		wp_enqueue_style( 'group-location2', esc_url_raw('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css') );
		wp_enqueue_script( 'location=group-location', esc_url_raw('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js'), array('jquery') );

		?>

		<script>
		function map_init() {
			var map = L.map('group-map').setView([<?php echo $group_location_lat; ?>, <?php echo $group_location_long; ?>], 7);

			// Replace 'MapBoxID' with your actual map id from mapbox.com
			L.tileLayer('http://{s}.tiles.mapbox.com/v3/MapBoxID/{z}/{x}/{y}.png', {
				 attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
				 maxZoom: 14
			}).addTo(map);

			var marker = L.marker([<?php echo $group_location_lat; ?>, <?php echo $group_location_long; ?>]).addTo(map);

			marker.bindPopup("<b><?php bp_group_name(); ?></b><br><?php echo $group_location; ?>").openPopup();

		}
		jQuery(function() {
			map_init();
		});
		</script>

		<div id="group-map"></div>

		<?php
	}
	/**
	 * settings_screen() is the catch-all method for displaying the content 
	 * of the edit, create, and Dashboard admin panels
	 */
	function settings_screen( $group_id ) {
		var_dump($args);
		$setting = groups_get_groupmeta( $group_id, 'group_location' );
		$group_location = (isset($setting[0])) ? $setting[0] : '?';
		$group_location_lat = (isset($setting[1])) ? $setting[1] : '58.25';
		$group_location_long = (isset($setting[2])) ? $setting[2] : '13.06';
		?>
		
		<script>
		jQuery(function() {
			var map = L.map('group-map').setView([<?php echo $group_location_lat; ?>, <?php echo $group_location_long; ?>], 7);

			// Replace 'MapBoxID' with your actual map id from mapbox.com
			L.tileLayer('http://{s}.tiles.mapbox.com/v3/MapBoxID/{z}/{x}/{y}.png', {
			 	attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
				 maxZoom: 14
			}).addTo(map);
	
			new L.Control.GeoSearch({
			    provider: new L.GeoSearch.Provider.OpenStreetMap(),
			    position: 'topcenter',
			    showMarker: true
			}).addTo(map);
			
			map.on('geosearch_showlocation', function(result) {
				$("input[name=group_location]").val($('.leaflet-control-geosearch input').val());
				$("input[name=group_location_lat]").val(result.Location.Y);
				$("input[name=group_location_long]").val(result.Location.X);
			});
			
			var marker = L.marker([<?php echo $group_location_lat; ?>, <?php echo $group_location_long; ?>]).addTo(map);
			marker.bindPopup("<b><?php bp_group_name(); ?></b><br><?php echo $group_location; ?>").openPopup();

			$('.leaflet-control-geosearch input').on('keypress', function(e) {
				if (e.keyCode === 13) {
					// Don't submit form when pressing Enter, just get location data.
					e.preventDefault();
				}
			});

		});
		</script>
		<div id="group-location">
			<input type="hidden" name="group_location" id="group_location" value="<?php echo esc_attr( $group_location ) ?>" />
			<input type="hidden" name="group_location_lat" id="group_location_lat" value="<?php echo esc_attr( $group_location_lat ) ?>" />
			<input type="hidden" name="group_location_long" id="group_location_long" value="<?php echo esc_attr( $group_location_long ) ?>" />
		</div>
		<div id="group-map"></div>
		<?php
		wp_enqueue_style( 'group-location1', esc_url_raw('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css') );
		wp_enqueue_style( 'group-location2', plugin_dir_url( __FILE__ ) . 'css/l.geosearch.css' );
		wp_enqueue_style( 'group-location3', plugin_dir_url( __FILE__ ) . 'css/group-location.css' );
		wp_enqueue_script( 'location=group-location1', esc_url_raw('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js'), array('jquery') );
		wp_enqueue_script( 'location=group-location2', plugin_dir_url( __FILE__ ) . 'js/l.control.geosearch.js', array('jquery') );
		wp_enqueue_script( 'location=group-location3', plugin_dir_url( __FILE__ ) . 'js/l.geosearch.provider.openstreetmap.js', array('jquery') );
	}
 
	/**
	 * settings_screen_save() contains the catch-all logic for saving 
	 * settings from the edit, create, and Dashboard admin panels
	 */
	function settings_screen_save( $group_id ) { 
		if ( isset( $_POST['group_location'], $_POST['group_location_lat'], $_POST['group_location_long'] ) ) {
			$setting = array($_POST['group_location'], $_POST['group_location_lat'], $_POST['group_location_long']);
		}
 
		groups_update_groupmeta( $group_id, 'group_location', $setting );
	}
	
}
bp_register_group_extension( 'Group_Location' );

function global_groups_map() {
	
	?>
	<script>
	function map_init() {
		var map = L.map('group-map').setView([58, 14], 6);

		// Replace 'MapBoxID' with your actual map id from mapbox.com
		L.tileLayer('http://{s}.tiles.mapbox.com/v3/MapBoxID/{z}/{x}/{y}.png', {
			 attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
			 maxZoom: 14
		}).addTo(map);
		<?php if ( bp_has_groups( 'per_page=100' ) ) : while ( bp_groups() ) : bp_the_group();
		$group_id = bp_get_group_id();
		$setting = groups_get_groupmeta( $group_id, 'group_location' );
		$group_location = $setting[0];
		$group_location_lat = $setting[1];
		$group_location_long = $setting[2];

		if ( $group_location_lat && $group_location_long ) :
		?>

		var marker<?php echo $group_id ?> = L.marker([<?php echo $group_location_lat; ?>, <?php echo $group_location_long; ?>]).addTo(map);
		marker<?php echo $group_id ?>.bindPopup('<b><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></b><br><?php echo $group_location; ?>');
		<?php 
		endif;
		endwhile; endif;

		wp_enqueue_style( 'group-location', plugin_dir_url( __FILE__ ) . 'css/group-location.css' );
		wp_enqueue_style( 'location=group-location1', esc_url_raw('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css') );
		wp_enqueue_script( 'location=group-location', esc_url_raw('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js'), array('jquery') );

		?>
	}
	jQuery(function() {
		map_init();
	});
	</script>

	<div id="group-map"></div>

	<?php

}
add_action('bp_before_directory_groups_content', 'global_groups_map');

endif; // if ( class_exists( 'BP_Group_Extension' ) )
?>