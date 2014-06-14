# BP Group Location #

BP Group Location is a plugin for [BuddyPress](http://buddypress.org) that allows you to add a location (name, lat, long) to a BuddyPress group. It uses (a remotely hosted version of) the wonderful [Leaflet](http://leafletjs.com/) library, in companion with [Leaflet.GeoSearch](https://github.com/smeijer/L.GeoSearch) and its OpenStreetmap add-on. The latter files are included here as well and comes under the same license.

If you want to update or host these files yourself, as of right now you have to download them manually and hack the plugin accordingly. The same goes with changing the map provider from OpenStreetmap to something else that Leaflet.GeoSearch supports.

The global map on the Groups Directory page currently shows up to 100 group markers. If you want to raise this level you must hack the plugin (or contribute here by adding support for e.g. marker clusters :)

#### Requirements
* WordPress 3.9.1 (earlier might work, haven't tested)
* BuddyPress 2.0 (earlier might work, haven't tested)
* A [Mapbox](http://mapbox.com/) map ID
* JavaScript turned on

#### Getting Started
* Install plugin
* Hack plugin to add your MapBox ID (anyone want to help out with admin settings for this?)
* Edit your group and go to Admin -> Group Location
* Search for a place by typing something in the search field, get results by pressing pressing Enter
* Save the group. You should now be able to see the group

***

#### Translations

None yet. Not prepared to be localised yet either (anyone care to help out here?)
