<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Markers</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTqVv8bnWtcApNQ7VCErEt8r2N5gPs5TM&libraries=geometry&callback=initialize">
    </script>
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <style>#map_canvas{
    width: 1330px;
    height: 700px;

    
}
 /* Add a CSS transition to the marker's icon property */
 .bus-marker {
      transition: transform 0.5s ease-in-out; /* Adjust the duration and easing as needed */
    }
</style>
</head> 
<body>
<?php
$mobile=96868686;
?>
<script type="text/javascript">
    
    function initialize() {
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            center: {lat: 23.30851346316578, lng:  83.21424789428713},
            zoom: 16
        });

      
          // Create a custom marker icon for the bus
  var busIcon = {
    url: 'car.gif', // Replace with the actual path to your bus icon image
    scaledSize: new google.maps.Size(50, 50), // Adjust the size as needed
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(25, 50) // Adjust the anchor point
  };
  var bharat = {
    url: 'bharat.png', // Replace with the actual path to your bus icon image
    scaledSize: new google.maps.Size(50, 50), // Adjust the size as needed
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(25, 50) // Adjust the anchor point
  };

  var marker = new google.maps.Marker({
  position: { lat: 23.30851346316578, lng: 83.21424789428713 },
  map: map,
  draggable: true,
  icon: busIcon // Set the custom bus icon here
});
var marker2 = new google.maps.Marker({
  position: { lat: 23.31851346316578, lng: 83.21424789428713 },
  map: map,
  draggable: true,
  icon: bharat // Set the custom bus icon here
});
console.log(marker.center); 

        /* Event Listener */
        google.maps.event.addListener(marker, 'dragend', function (event) {
            let latitude = event.latLng.lat();
            let longitude = event.latLng.lng();
            console.log(latitude, longitude);

            // Send the latitude and longitude to the server-side PHP script
            // for the point in polygon check
            $.ajax({
                url: 'polygon.php',
                method: 'POST',
                data: {latitude: latitude, longitude: longitude},
                success: function (response) {
                    if (response === 'Point inside') {
                        alert(response);
                        console.log('Point is inside the polygon');
                    } else {
                        console.log('Point is outside the Polygon');
                    }
                },
                error: function () {
                    console.log('Error occurred while checking point in the Polygon.');
                }
            });
        });

        /* Define the polygon coordinates */
    var polygonCoords = [
        { lat: 23.31481938082571, lng: 83.21939773559572},
        { lat: 23.307173417137452, lng:  83.22107143402101},
        { lat: 23.304887425102784, lng:  83.22042770385744},
        { lat: 23.303744414351616, lng:  83.21772403717043},
        { lat: 23.30342909931245, lng:   83.2148916244507}
        
        
         
        // 
    ];
console.log('Polygon Coordinates',polygonCoords);
    var polygon = new google.maps.Polygon({
        paths: polygonCoords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#33FFEC',
        fillOpacity: 0.35
    });
    polygon.setMap(map);
//     let contentString =
//     '<style>'+
// 'table, th, td {'+
//   'border:1px solid black;'+'bacground-color:black;'+
// '}'+
// '</style>'+
//     '<body>'+
// '<h2>Mahindra Suv</h2>'+
// '<table style="width:100%">'+
//   '<tr>'+
//     '<th>Owner</th>'+
//     '<th>Contact</th>'+
//     '<th>Address</th>'+
//   '</tr>'+
//   '<tr>'+
//     '<td>Alfreds Futterkiste</td>'+
//     '<td>  ${mobile} </td>'+
//     '<td>Germany</td>'+
//   '</tr>'+
// '</table>'+

// '<p>To understand the example better, we have added borders to the table.</p>'+

// '</body>';
let contentString =`<table class="table table-bordered table-striped table-hover table-warning ">
<thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>vijendra</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>`;

 const infowindow = new google.maps.InfoWindow({
    content: contentString,
    ariaLabel: {lat: 23.30851346316578, lng:  83.21424789428713},
  });
//   const marker = new google.maps.Marker({
//     position: uluru,
//     map,
//     title: "Uluru (Ayers Rock)",
//   });

  marker.addListener("click", () => {
    infowindow.open({
      anchor: marker,
      map,
    });
  });

    }
    
</script>
<div id="map_canvas"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
