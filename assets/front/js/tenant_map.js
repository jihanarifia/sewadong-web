<script type="text/javascript">
  $(document).ready(function(){
    google.maps.event.addDomListener(window, 'load', initMap);
  });
  function initMap() {

  // Specify features and elements to define styles.
  var styleArray = [
  {"featureType":"water","elementType":"all","stylers":[{"hue":"#7fc8ed"},{"saturation":55},{"lightness":-6},{"visibility":"on"}]},{"featureType":"water","elementType":"labels","stylers":[{"hue":"#7fc8ed"},{"saturation":55},{"lightness":-6},{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"hue":"#83cead"},{"saturation":1},{"lightness":-15},{"visibility":"on"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#f3f4f4"},{"saturation":-84},{"lightness":59},{"visibility":"on"}]},{"featureType":"landscape","elementType":"labels","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbbbbb"},{"saturation":-100},{"lightness":26},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#ffcc00"},{"saturation":100},{"lightness":-35},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#ffcc00"},{"saturation":100},{"lightness":-22},{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"hue":"#d7e4e4"},{"saturation":-60},{"lightness":23},{"visibility":"on"}]}
  ];

  // Create a map object and specify the DOM element for display.
  var map = new google.maps.Map(document.getElementById('googleMap'), {
    center: {lat: -6.331357, lng: 107.122141},
    scrollwheel: true,
    // Apply the map style array to the map.
    styles: styleArray,
    zoom: 8
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCr_MHRq3r-aIxVLa1M7RLcrznk2C0CDw8&callback=initMap&v=3.23"></script>