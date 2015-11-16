<?php
$l="fr"; 
if (isset($_COOKIE['l']))
	$l=$_COOKIE['l'];
if (isset($_GET['l']))
	if ($_GET['l']!=""){ 
		setcookie ("l",$_GET['l'], time() - 3600);
		setcookie ("l",$_GET['l'], time() + 31536000, "/");
		$l=$_GET['l'];
	}
$lgs=array("ar","bn","br","ca","cs","da","de","el","en","eo","es","fa","fi","fr","he","hi","id","it","ja","jv","ko","mu","nl","pa","pl","pt","ru","sw","sv","te","th","tr","uk","vi","zh");

include "../functions.php";
include "../traduction.php";
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#000000">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Crotos - Callisto</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css">
    <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css">
    <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css">
    <link rel="stylesheet" href="assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.css">
    <link rel="stylesheet" href="assets/css/app.css">

  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          
          <div class="navbar-icon-container">
            <a href="#" class="navbar-icon pull-right visible-xs" id="nav-btn"><i class="fa fa-bars fa-lg white"></i></a>
            <a href="#" class="navbar-icon pull-right visible-xs" id="sidebar-toggle-btn"><i class="fa fa-search fa-lg white"></i></a>
          </div>
          <a href="/crotos/"  class="navbar-brand" id="ico_crotos"><img src="assets/img/crotos_med.jpg" /></a><span class="navbar-brand" id="cal_title"> <a href="/crotos/">Crotos</a> – <a href="/crotos/callisto">Callisto</a></span>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="search" id="form">
            <div class="form-group has-feedback">
           <select name="l" id="lg" onChange="document.getElementById('form').submit()">
<?php
for ($i=0;$i<count($lgs);$i++){
	/* Easter egg */if (($lgs[$i]=="mu")&&($l!="mu")) echo "<!-- ";
    echo "			<option value=\"".translate($lgs[$i],"lang_code")."\"";
	if ($l==translate($lgs[$i],"lang_code"))
		 echo " selected=\"selected\"";
	echo " >".translate($lgs[$i],"lg")."</option>\n";	
	/* Easter egg */if (($lgs[$i]=="mu")&&($l!="mu")) echo " -->";
}
?>
		</select>
        	
              <input id="searchbox" type="text" placeholder="" class="form-control">
              <span id="searchicon" class="fa fa-search form-control-feedback"></span>
            </div>
          </form>-->
          <ul class="nav navbar-nav">
            <li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="list-btn"><i class="fa fa-list white"></i>&nbsp;&nbsp;</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div id="container">
      <div id="sidebar">
        <div class="sidebar-wrapper">
          <div class="panel panel-default" id="features">
            <div class="panel-heading">
              <h3 class="panel-title">&nbsp;
              <button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn"><i class="fa fa-chevron-left"></i></button></h3>
            </div>
            <div class="sidebar-table">
              <table class="table table-hover" id="feature-list">
                <tbody class="list"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div id="map"></div>
    </div>
    <div id="loading">
      <div class="loading-indicator">
        <div class="progress progress-striped active">
          <div class="progress-bar progress-bar-info progress-bar-full"></div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="featureModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-primary" id="feature-title"></h4>
          </div>
          <div class="modal-body" id="feature-info"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">X</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="attributionModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">
              <a href="https://twitter.com/shona_gon">/* / */</a>, powered by  <a href="hopenstreetmap.org" title="OpenStreetMap">OpenStreetMap</a>, <a href="http://www.mapquest.com" title="Mapquest">Mapquest</a>, <a href="http://leafletjs.com/" title="Leaflet">Leaflet</a>,  <a href='http://bryanmcbride.com'>bryanmcbride.com</a>, <a href="http://www.wikidata.org" title="Wikidata">Wikidata</a>, <a href="http://commons.wikimedia.org" title="Wikimedia Commons">Wikimedia Commons</a>, al. and <3
            </h4>
            <p>Ce truc a été codé à Paris 11e, le week-end du 13 novembre 2015. Pour continuer à aimer, créer, s'émerveiller et partager. En mémoire de toutes ces vies fauchées</p>
          </div>
          <div class="modal-body">
            <div id="attribution"></div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	<script>
<?php
echo "var l=\"".$l."\";\n";
echo "var depicts=\"".mb_ucfirst(translate($l,"180"))."\";\n";
echo "var museum=\"".mb_ucfirst(translate($l,"195"))."\";\n";
echo "var artwork=\"".mb_ucfirst(translate($l,"artwork"))."\";\n";
echo "var result=\"".mb_ucfirst(translate($l,"result"))."\";\n";
echo "var results=\"".mb_ucfirst(translate($l,"results"))."\";\n";

?>
    </script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.5/typeahead.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
    <script src="assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js"></script>
    <!--<script src="assets/js/app.js"></script>
    <script src="assets/js/app_fr.js"></script>-->
<script>
$( document ).ready(function() {
var map, featureList, depictSearch = [], museumSearch = [], artworkSearch = [];

function isInt(value) {
 var x;
 return isNaN(value) ? !1 : (x = parseFloat(value), (0 | x) === x);
}

$(window).resize(function() {
  sizeLayerControl();
});

$(document).on("click", ".feature-row", function(e) {
  $(document).off("mouseout", ".feature-row", clearHighlight);
  sidebarClick(parseInt($(this).attr("id"), 10));
});

$(document).on("mouseover", ".feature-row", function(e) {
  highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
});

$(document).on("mouseout", ".feature-row", clearHighlight);

$("#about-btn").click(function() {
  $("#aboutModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#full-extent-btn").click(function() {
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#legend-btn").click(function() {
  $("#legendModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#login-btn").click(function() {
  $("#loginModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#list-btn").click(function() {
  $('#sidebar').toggle();
  map.invalidateSize();
  return false;
});

$("#nav-btn").click(function() {
  $(".navbar-collapse").collapse("toggle");
  return false;
});

$("#sidebar-toggle-btn").click(function() {
  $("#sidebar").toggle();
  map.invalidateSize();
  return false;
});

$("#sidebar-hide-btn").click(function() {
  $('#sidebar').hide();
  map.invalidateSize();
});

function sizeLayerControl() {
  $(".leaflet-control-layers").css("max-height", $("#map").height() - 50);
}

function clearHighlight() {
  highlight.clearLayers();
}

function sidebarClick(id) {
  var layer = markerClusters.getLayer(id);
  map.setView([layer.getLatLng().lat, layer.getLatLng().lng], 17);
  layer.fire("click");
  /* Hide sidebar and go to the map on small screens */
  if (document.body.clientWidth <= 767) {
    $("#sidebar").hide();
    map.invalidateSize();
  }
}

function syncSidebar() {
  /* Empty sidebar features */
  $("#feature-list tbody").empty();

  /* Loop through museums layer and add only features which are in the map bounds */
  depicts.eachLayer(function (layer) {
    if (map.hasLayer(depictLayer)) {
      if (map.getBounds().contains(layer.getLatLng())) {
		$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/depicts.png"></td><td>'+ layer.feature.properties.l + ' <span class="nb">(<span class="feature-name depicts">' + layer.feature.properties.n + '</span>)</span></td><td style="vertical-align: middle;"><a href="/crotos/?p180=' + layer.feature.properties.q + '"><img src="assets/img/crotos_ico.png" alt="" /></a></td></tr>');
      }
    }
  });
  museums.eachLayer(function (layer) {
    if (map.hasLayer(museumLayer)) {
      if (map.getBounds().contains(layer.getLatLng())) {
        $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/museum.png"></td><td>'+ layer.feature.properties.l + ' <span class="nb">(<span class="feature-name">' + layer.feature.properties.n + '</span>)</span></td><td style="vertical-align: middle;"><a href="/crotos/?p195=' + layer.feature.properties.q + '"><img src="assets/img/crotos_ico.png" alt="" /></a></td></tr>');
      }
    }
  });
  artworks.eachLayer(function (layer) {
    if (map.hasLayer(artworkLayer)) {
      if (map.getBounds().contains(layer.getLatLng())) {
        $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/artwork.png"></td><td class="feature-name">'+ layer.feature.properties.l + '</td><td style="vertical-align: middle;"><a href="http://tools.wmflabs.org/reasonator/?lang=' + l + '&q=' + layer.feature.properties.q + '"><img src="assets/img/reas_ico.png" alt="" /></a></td></tr>');
      }
    }
  });
  /* Update list.js featureList */
  featureList = new List("features", {
    valueNames:["feature-name"]
  });
  var toto=featureList.get("features")[0];
  var typedata;
  for(var key in toto) {
	 typedata=toto[key]["feature-name"];
	 break;
  }
  if (isInt(typedata)){
  featureList.sort("feature-name", {
    order: "desc"
  });
  }
  else{
  featureList.sort("feature-name", {
    order: "asc"
  });
  }
}

/* Basemap Layers */
var mapquestOSM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
  maxZoom: 19,
  subdomains: ["otile1", "otile2", "otile3", "otile4"],
  attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
});


/* Overlay Layers */
var highlight = L.geoJson(null);
var highlightStyle = {
  stroke: false,
  fillColor: "#00FFFF",
  fillOpacity: 0.7,
  radius: 10
};



/* Single marker cluster layer to hold all clusters */
var markerClusters = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: true,
  showCoverageOnHover: false,
  zoomToBoundsOnClick: true,
  disableClusteringAtZoom: 9
});
/* Empty layer placeholder to add to layer control for listening when to add/remove museums to markerClusters layer */
var depictLayer = L.geoJson(null);
var depicts = L.geoJson(null, {
  pointToLayer: function (feature, latlng) {
    return L.marker(latlng, {
      icon: L.icon({
        iconUrl: "assets/img/depicts.png",
        iconSize: [24, 28],
        iconAnchor: [12, 28],
        popupAnchor: [0, -25]
      }),
      title: feature.properties.l,
      riseOnHover: true
    });
  },
  onEachFeature: function (feature, layer) {
    if (feature.properties) {
      var content = "<table class='table table-striped table-bordered table-condensed snipet'>" + "<tr><td><a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\">" + layer.feature.properties.l + "</a> <a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\"><img src=\"assets/img/reas_ico.png\" alt=\"\" /></a></td></tr>";
	  if (feature.properties.t!=""){
	    content = content + "<tr><td><a href=\"/crotos/?p180=" + layer.feature.properties.q + "\"><img src=\"https://upload.wikimedia.org/wikipedia/commons/" + layer.feature.properties.t + "\" /></a>";
		content = content + " <a href=\"https://commons.wikimedia.org/wiki/File:" + layer.feature.properties.i + "\"><img src=\"assets/img/commons_ico.png\" class=\"cms_ico\"/></a></td></tr>";
		
	  }
      content = content + "<tr><td><a href=\"/crotos/?p180=" + layer.feature.properties.q + "\">" + feature.properties.n + " ";
	  if (feature.properties.n==1)
	    content = content + result;
	  else
	    content = content + results;
	  content = content + "</a> <a href=\"/crotos/?p180=" + layer.feature.properties.q + "\"><img src=\"assets/img/crotos_ico.png\" alt=\"\" /></a></td></tr>";
	  content = content + "<table>";
      layer.on({
        click: function (e) {
          $("#feature-title").html(feature.properties.l);
          $("#feature-info").html(content);
          $("#featureModal").modal("show");
          highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
        }
      });
	 $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/depicts.png"></td><td>'+ layer.feature.properties.l + ' <span class="nb">(<span class="feature-name depicts">' + layer.feature.properties.n + '</span>)</span></td><td style="vertical-align: middle;"><a href="/crotos/?p180=' + layer.feature.properties.q + '"><img src="assets/img/crotos_ico.png" alt="" /></a></td></tr>');
      depictSearch.push({
        name: layer.feature.properties.l,
        source: "Depicts",
        id: L.stamp(layer),
        lat: layer.feature.geometry.coordinates[1],
        lng: layer.feature.geometry.coordinates[0]
      });
    }
  }
});
$.getJSON("data/depicts_" + l + ".geojson", function (data) {
  depicts.addData(data);
  map.addLayer(depictLayer);
});

/* Empty layer placeholder to add to layer control for listening when to add/remove museums to markerClusters layer */
var museumLayer = L.geoJson(null);
var museums = L.geoJson(null, {
  pointToLayer: function (feature, latlng) {
    return L.marker(latlng, {
      icon: L.icon({
        iconUrl: "assets/img/museum.png",
        iconSize: [24, 28],
        iconAnchor: [12, 28],
        popupAnchor: [0, -25]
      }),
      title: feature.properties.l,
      riseOnHover: true
    });
  },
  onEachFeature: function (feature, layer) {
    if (feature.properties) {
	  var content = "<table class='table table-striped table-bordered table-condensed snipet'>" + "<tr><td><a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\">" + layer.feature.properties.l + "</a> <a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\"><img src=\"assets/img/reas_ico.png\" alt=\"\" /></a></td></tr>";
	  if (feature.properties.t!=""){
	    content = content + "<tr><td><a href=\"/crotos/?p195=" + layer.feature.properties.q + "\"><img src=\"https://upload.wikimedia.org/wikipedia/commons/" + layer.feature.properties.t + "\" /></a>";
		content = content + " <a href=\"https://commons.wikimedia.org/wiki/File:" + layer.feature.properties.i + "\"><img src=\"assets/img/commons_ico.png\" class=\"cms_ico\"/></a></td></tr>";
		
	  }
      content = content + "<tr><td><a href=\"/crotos/?p195=" + layer.feature.properties.q + "\">" + feature.properties.n + " ";
	  if (feature.properties.n==1)
	    content = content + result;
	  else
	    content = content + results;
	  content = content + "</a> <a href=\"/crotos/?p195=" + layer.feature.properties.q + "\"><img src=\"assets/img/crotos_ico.png\" alt=\"\" /></a></td></tr>";
	  if (feature.properties.u!="")
	    content = content + "<tr><td><a class='url-break' href='" + feature.properties.u + "' target='_blank'>" + feature.properties.u + "</a></td></tr>";
	  content = content + "<table>";
      layer.on({
        click: function (e) {
          $("#feature-title").html(feature.properties.l);
          $("#feature-info").html(content);
          $("#featureModal").modal("show");
          highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
        }
      });
	 $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/museum.png"></td><td>'+ layer.feature.properties.l + ' <span class="nb">(<span class="feature-name">' + layer.feature.properties.n + '</span>)</span></td><td style="vertical-align: middle;"><a href="/crotos/?p195=' + layer.feature.properties.q + '"><img src="assets/img/crotos_ico.png" alt="" /></a></td></tr>');
      museumSearch.push({
        name: layer.feature.properties.l,
        source: "Museums",
        id: L.stamp(layer),
        lat: layer.feature.geometry.coordinates[1],
        lng: layer.feature.geometry.coordinates[0]
      });
    }
  }
});
$.getJSON("data/museums_" + l + ".geojson", function (data) {
  museums.addData(data);
});

/* Empty layer placeholder to add to layer control for listening when to add/remove museums to markerClusters layer */
var artworkLayer = L.geoJson(null);
var artworks = L.geoJson(null, {
  pointToLayer: function (feature, latlng) {
    return L.marker(latlng, {
      icon: L.icon({
        iconUrl: "assets/img/artwork.png",
        iconSize: [24, 28],
        iconAnchor: [12, 28],
        popupAnchor: [0, -25]
      }),
      title: feature.properties.l,
      riseOnHover: true
    });
  },
  onEachFeature: function (feature, layer) {
    if (feature.properties) {
	  var content = "<table class='table table-striped table-bordered table-condensed snipet'>" + "<tr><td><a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\">" + layer.feature.properties.l + "</a> <a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\"><img src=\"assets/img/reas_ico.png\" alt=\"\" /></a></td></tr>";
	  if (feature.properties.t!=""){
	    content = content + "<tr><td><a href=\"http://tools.wmflabs.org/reasonator/?lang=" + l + "&q=" + layer.feature.properties.q + "\"><img src=\"https://upload.wikimedia.org/wikipedia/commons/" + layer.feature.properties.t + "\" /></a>";
		content = content + " <a href=\"https://commons.wikimedia.org/wiki/File:" + layer.feature.properties.i + "\"><img src=\"assets/img/commons_ico.png\" class=\"cms_ico\"/></a></td></tr>";
		
	  }
	  if (feature.properties.c!="")
        content = content + "<tr><td>" + feature.properties.c + "</td></tr>";
	  content = content + "<table>";
      layer.on({
        click: function (e) {
          $("#feature-title").html(feature.properties.l);
          $("#feature-info").html(content);
          $("#featureModal").modal("show");
          highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
        }
      });
	 $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/artwork.png"></td><td class="feature-name">'+ layer.feature.properties.l + '</td><td style="vertical-align: middle;"><a href="http://tools.wmflabs.org/reasonator/?lang=' + l + '&q=' + layer.feature.properties.q + '"><img src="assets/img/reas_ico.png" alt="" /></a></td></tr>');
      artworkSearch.push({
        name: layer.feature.properties.l,
        source: "Artworks",
        id: L.stamp(layer),
        lat: layer.feature.geometry.coordinates[1],
        lng: layer.feature.geometry.coordinates[0]
      });
    }
  }
});
$.getJSON("data/artworks_" + l + ".geojson", function (data) {
  artworks.addData(data);
});


map = L.map("map", {
  zoom: 3,
  center: [20.0, 0.0],
  layers: [mapquestOSM, markerClusters, highlight],
  zoomControl: false,
  attributionControl: false
});

/* Layer control listeners that allow for a single markerClusters layer */
map.on("overlayadd", function(e) {
  if (e.layer === depictLayer) {
    markerClusters.addLayer(depicts);
    syncSidebar();
  }	
  if (e.layer === museumLayer) {
    markerClusters.addLayer(museums);
    syncSidebar();
  }
  if (e.layer === artworkLayer) {
    markerClusters.addLayer(artworks);
    syncSidebar();
  }
});

map.on("overlayremove", function(e) {
  if (e.layer === depictLayer) {
    markerClusters.removeLayer(depicts);
    syncSidebar();
  }
  if (e.layer === museumLayer) {
    markerClusters.removeLayer(museums);
    syncSidebar();
  }
  if (e.layer === artworkLayer) {
    markerClusters.removeLayer(artworks);
    syncSidebar();
  }
});

/* Filter sidebar feature list to only show features in current map bounds */
map.on("moveend", function (e) {
  syncSidebar();
});

/* Clear feature highlight when map is clicked */
map.on("click", function(e) {
  highlight.clearLayers();
});

/* Attribution control */
function updateAttribution(e) {
  $.each(map._layers, function(index, layer) {
    if (layer.getAttribution) {
      $("#attribution").html((layer.getAttribution()));
    }
  });
}
map.on("layeradd", updateAttribution);
map.on("layerremove", updateAttribution);

var attributionControl = L.control({
  position: "bottomright"
});
attributionControl.onAdd = function (map) {
  var div = L.DomUtil.create("div", "leaflet-control-attribution");
  div.innerHTML = "<a href='#' onclick='$(\"#attributionModal\").modal(\"show\"); return false;'>Blah</a>";
  return div;
};
map.addControl(attributionControl);

var zoomControl = L.control.zoom({
  position: "bottomright"
}).addTo(map);

/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({
  position: "bottomright",
  drawCircle: true,
  follow: true,
  setView: true,
  keepCurrentZoomLevel: true,
  markerStyle: {
    weight: 1,
    opacity: 0.8,
    fillOpacity: 0.8
  },
  circleStyle: {
    weight: 1,
    clickable: false
  },
  icon: "fa fa-location-arrow",
  metric: false,
  strings: {
    title: "My location",
    popup: "You are within {distance} {unit} from this point",
    outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
  },
  locateOptions: {
    maxZoom: 18,
    watch: true,
    enableHighAccuracy: true,
    maximumAge: 10000,
    timeout: 10000
  }
}).addTo(map);

/* Larger screens get expanded layer control and visible sidebar */
if (document.body.clientWidth <= 767) {
  var isCollapsed = true;
} else {
  var isCollapsed = false;
}

var baseLayers = {
  "Street Map": mapquestOSM
};

var groupedOverlays = {
  " ": {
	"<img src='assets/img/depicts.png' width='24' height='28'>&nbsp;<?php echo mb_ucfirst(translate($l,"180")) ?>": depictLayer,
    "<img src='assets/img/museum.png' width='24' height='28'>&nbsp;<?php echo mb_ucfirst(translate($l,"195")) ?>": museumLayer,
    "<img src='assets/img/artwork.png' width='24' height='28'>&nbsp;<?php echo mb_ucfirst(translate($l,"artwork")) ?>": artworkLayer
  }
};

var layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
  collapsed: isCollapsed
}).addTo(map);

/* Highlight search box text on click */
$("#searchbox").click(function () {
  $(this).select();
});

/* Prevent hitting enter from refreshing the page */
$("#searchbox").keypress(function (e) {
  if (e.which == 13) {
    e.preventDefault();
  }
});

$("#featureModal").on("hidden.bs.modal", function (e) {
  $(document).on("mouseout", ".feature-row", clearHighlight);
});

/* Typeahead search functionality */
$(document).one("ajaxStop", function () {
  $("#loading").hide();
  sizeLayerControl();
  featureList = new List("features", {valueNames:["depicts"]});
  featureList.sort("depicts", {order:"desc"});
  
  var depictsBH = new Bloodhound({
    name: "Depicts",
    datumTokenizer: function (d) {
      return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: depictSearch,
    limit: 10
  });
  	
  var museumsBH = new Bloodhound({
    name: "Museums",
    datumTokenizer: function (d) {
      return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: museumSearch,
    limit: 10
  });
  
  var artworksBH = new Bloodhound({
    name: "Artworks",
    datumTokenizer: function (d) {
      return Bloodhound.tokenizers.whitespace(d.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: artworkSearch,
    limit: 10
  });

  depictsBH.initialize();
  museumsBH.initialize();
  artworksBH.initialize();
  
  /* instantiate the typeahead UI */
  $("#searchbox").typeahead({
    minLength: 3,
    highlight: true,
    hint: false
  }, {
    name: "Depicts",
    displayKey: "name",
    source: depictsBH.ttAdapter(),
    templates: {
      header: "<h4 class='typeahead-header'><img src='assets/img/depicts.png' width='24' height='28'>&nbsp;<?php echo mb_ucfirst(translate($l,"180")) ?></h4>",
      suggestion: Handlebars.compile(["{{name}}"].join(""))
    }
  }, {
    name: "Museums",
    displayKey: "name",
    source: museumsBH.ttAdapter(),
    templates: {
      header: "<h4 class='typeahead-header'><img src='assets/img/museum.png' width='24' height='28'>&nbsp;<?php echo mb_ucfirst(translate($l,"195")) ?></h4>",
      suggestion: Handlebars.compile(["{{name}}"].join(""))
    }
  }, {
    name: "Artworks",
    displayKey: "name",
    source: artworksBH.ttAdapter(),
    templates: {
      header: "<h4 class='typeahead-header'><img src='assets/img/artwork.png' width='24' height='28'>&nbsp;<?php echo mb_ucfirst(translate($l,"artwork")) ?></h4>",
      suggestion: Handlebars.compile(["{{name}}"].join(""))
    }
  }).on("typeahead:selected", function (obj, datum) {
    if (datum.source === "Depicts") {
      if (!map.hasLayer(depictLayer)) {
        map.addLayer(depictLayer);
      }
      map.setView([datum.lat, datum.lng], 17);
      if (map._layers[datum.id]) {
        map._layers[datum.id].fire("click");
      }
    }
	
	if (datum.source === "Museums") {
      if (!map.hasLayer(museumLayer)) {
        map.addLayer(museumLayer);
      }
      map.setView([datum.lat, datum.lng], 17);
      if (map._layers[datum.id]) {
        map._layers[datum.id].fire("click");
      }
    }
	
	if (datum.source === "Artworks") {
      if (!map.hasLayer(artworkLayer)) {
        map.addLayer(artworkLayer);
      }
      map.setView([datum.lat, datum.lng], 17);
      if (map._layers[datum.id]) {
        map._layers[datum.id].fire("click");
      }
    }
	
    if ($(".navbar-collapse").height() > 50) {
      $(".navbar-collapse").collapse("hide");
    }
  }).on("typeahead:opened", function () {
    $(".navbar-collapse.in").css("max-height", $(document).height() - $(".navbar-header").height());
    $(".navbar-collapse.in").css("height", $(document).height() - $(".navbar-header").height());
  }).on("typeahead:closed", function () {
    $(".navbar-collapse.in").css("max-height", "");
    $(".navbar-collapse.in").css("height", "");
  });
  $(".twitter-typeahead").css("position", "static");
  $(".twitter-typeahead").css("display", "block");
});

// Leaflet patch to make layer control scrollable on touch browsers
var container = $(".leaflet-control-layers")[0];
if (!L.Browser.touch) {
  L.DomEvent
  .disableClickPropagation(container)
  .disableScrollPropagation(container);
} else {
  L.DomEvent.disableClickPropagation(container);
}



});
</script>
  </body>
</html>
