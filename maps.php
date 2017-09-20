<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="style.php" />
<?php
// Echo session variables that were set on previous page
$a = $_SESSION["Latitud_x"];
$b = $_SESSION["Longitud_x"];
?>
</head>
<body>
  <div id="map"></div>
    <script>
      c = Number(<?php echo $a; ?>);
      d = Number(<?php echo $b; ?>);

      function downloadUrl(url,callback) {
        var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;
        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing();
            callback(request, request.status);
          }
        };
        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}

      function initMap(){

        // Change this depending on the name of your PHP or XML file
        downloadUrl('http://localhost/p1/credencial.php', function(data) {
          xml = data.responseXML;
          markers_ = xml.documentElement.getElementsByTagName('location_');
          Array.prototype.forEach.call(markers_, function(location_Elem) {
            Lat = location_Elem.getAttribute('Lat');
            Lng = location_Elem.getAttribute('Lng');
            Fecha = location_Elem.getAttribute('Fecha');
            Hora = location_Elem.getAttribute('Hora');
            point = new google.maps.LatLng(
                parseFloat(location_Elem.getAttribute('Lat')),
                parseFloat(location_Elem.getAttribute('Lng')));
            infowincontent = document.createElement('div');
            strong = document.createElement('strong');
            strong.textContent = Fecha
            infowincontent.appendChild(strong);
            infowincontent.appendChild(document.createElement('br'));

            var text = document.createElement('text');
            text.textContent = Hora
            infowincontent.appendChild(text);
            var markers = [
            {
              coords: point,
              iconImage:'http://localhost/p1/camion_g.png',
              content:'<h1>Camión id=1</h1>'
            }
            ];
            // Loop through markers
            for(var i = 0;i < markers.length;i++){
            // Add marker
            addMarker(markers[i]);}
            // Add Marker Function
            function addMarker(props){
              var marker = new google.maps.Marker({
                  position:props.coords,
                  map:map,
              });
            // Check for customicon
              if(props.iconImage){
              // Set icon image
              marker.setIcon(props.iconImage);
              }
              // Check content
              if(props.content){
                var infoWindow = new google.maps.InfoWindow({
                    content:props.content
                });
              marker.addListener('click', function(){
              infoWindow.open(map, marker);
              });
              }}
            });
          });

          // Map options
          var options = {
              zoom:16,
              center:{lat:c,lng:d}}

          // New map
          var map = new google.maps.Map(document.getElementById('map'), options);

        }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGIDk3Mifck_bsY5wqXxhW0YmNlIn-7iI&callback=initMap">
    </script>

  </body>
</html>
