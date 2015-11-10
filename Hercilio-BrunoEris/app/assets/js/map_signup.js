var map,
    myLatlng;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -9.654576, lng: -35.711623},
        zoom: 16
    });
  // Place a draggable marker on the map
    var marker = new google.maps.Marker({
        position: {lat: -9.654576, lng: -35.711623},
        map: map,
        draggable:true,
        title:"Arraste para a posição de sua empresa."
    });
    var geocoder = new google.maps.Geocoder();
    //get marker position and store in hidden input
    // google.maps.event.addListener(marker, 'dragend', function (evt) {
    //     document.getElementById("latInput").value = evt.latLng.lat().toFixed(6);
    //     document.getElementById("lngInput").value = evt.latLng.lng().toFixed(6);
    //     document.getElementById("endInput").value = evt.formated_address;
    //     console.log(evt);
    // });

    // geocoder.geocode({'latLng': myLatlng }, function(results, status) {
    // if (status == google.maps.GeocoderStatus.OK) {
    // if (results[0]) {
    // $('#latitude,#longitude').show();
    // $('#address').val(results[0].formatted_address);
    // $('#latitude').val(marker.getPosition().lat());
    // $('#longitude').val(marker.getPosition().lng());
    // }
    // console.log(results[0]);
    // }
    // });

    google.maps.event.addListener(marker, 'dragend', function() {

    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
    if (results[0]) {
    $('#endInput').val(results[0].formatted_address);
    $('#latInput').val(marker.getPosition().lat());
    $('#lngInput').val(marker.getPosition().lng());
    }
    console.log(results[0]);
    }
    });
    });
}
