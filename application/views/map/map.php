<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-search-strip">
        <h3>Search for Properties</h3>
    </div>
    <div class="map">
        <div>
            <div class="spacer-small"></div>
            <img src="<?php echo site_url('') . 'assets/img/'; ?>icon-residential.png" width="15" height="13" /> Residential&nbsp;
            <img src="<?php echo site_url('') . 'assets/img/'; ?>icon-commercial.png" width="15" height="13" /> Commercial&nbsp;
            <img src="<?php echo site_url('') . 'assets/img/'; ?>icon-land.png" width="15" height="13" /> Land&nbsp;
            <img src="<?php echo site_url('') . 'assets/img/'; ?>icon-hotel.png" width="15" height="13" /> Hotel
        </div>
        <div class="spacer-small"></div>
        <div class="clearfix"></div>
        <div id="divmap" style="height:585px;"></div>
    </div>
    <div class="spacer" style="background-color:#fff;"></div>
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<?php $this->load->view('footer_summary'); ?>

<style>
img {
  max-width: none;
}
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&key="></script>
<script type="text/javascript">
<?php if(isset($location)) { ?>
var geocoder;
<?php } ?>
var map;
var lat = '<?php echo $latitude; ?>';
var lng = '<?php echo $longitude; ?>';
var ccctr = 0;
<?php if( !empty($latitude) && !empty($longitude) ) { ?>
var latlng = new google.maps.LatLng('<?php echo $latitude; ?>', '<?php echo $longitude; ?>');
<?php } else { ?>
var latlng = new google.maps.LatLng(1.2847777247510794, 103.85152816772461); //Singapore
<?php } ?>   
google.maps.event.addDomListener(window, "load", function() {

    <?php if(isset($location)) { ?>
    geocoder = new google.maps.Geocoder();
    <?php } ?>

    map = new google.maps.Map(document.getElementById("divmap"), {
      center: latlng,
      zoom: 12,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    <?php if(isset($location)) { ?>
    geocoder.geocode( { 'address': '<?php echo $location; ?>'}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
        } else {
          console.log('Geocode was not successful for the following reason: ' + status);
        }
      });
    <?php } ?>

    google.maps.event.addListener(map, "center_changed", function () { 
        if(++ccctr == 2) {
            var mce = map.getCenter();
            lat = mce.lat();
            lng = mce.lng();
            load_properties_map();
            ccctr = 0;
        }
    });
}); 
    
head.ready(function() {
    load_properties_map();
});
</script>