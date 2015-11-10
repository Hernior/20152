function initialize() {
  var geocoder,
      map,
      marker,
      myLatlng,
      directionsDisplay,
      zoomLevel,
      directionsService = new google.maps.DirectionsService();

  map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -9.6655325, lng: -35.7324382},
      zoom: 16
  });

  var marker = new google.maps.Marker({
      position: {lat: -9.6655325, lng: -35.7324382},
      map: map
  });

  function loadPontos() {
    $.ajax({
      url : "../../controllers/JSONCompanies.php",
      dataType : "json",
      success : function(data){
        console.log("Sucesso!");
        console.log(data);

        $.each(data, function(key, val) {
          console.log(val);

          google.maps.event.addDomListener(window, 'load', function() {
            var myLatlng = new google.maps.LatLng(val.latitude, val.longitude);

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: '../../assets/img/bread.png'
            });

            var conteudo = '<div><div class="logoCompany"><img class="img-circle" src="../../assets/img/company/'+val.logo+'" alt="SEM FOTO"></div>'+
                              '<b><h4>'+val.nome+'</b></h6>'+
                              '<h6>Status: <b>Aberto</b></h6>'+
                              '<div class="define-width-list"></div>'+
                              '<div class="list-group">'+
                                '<a class="list-group-item text-center active link_ajax" href="newOrder.php?company='+val.id+'">'+
                                  'Efetuar Pedido'+
                                '</a>'+
                                '<div class="list-group-item">'+
                                  '<span class="text-center"><b>'+val.frase+'</b></span><br>'+
                                  '<span class="text-center">Telefone: '+val.telefone+'</span>'+
                                '</div>'+
                              '</div>'+
                            '</div>';

            var infoWindow = new google.maps.InfoWindow({
               content: conteudo
            });

            google.maps.event.addListener(marker, 'click', function() {
              infoWindow.open(map, marker);
            });
            google.maps.event.addListener(map, 'click', function() {
              infoWindow.close();
            });
          });
        });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        console.log("Erro!");
        console.log(XMLHttpRequest.responseText);
        console.log(textStatus);
        console.log(errorThrown);
      }
    });
  }
  loadPontos();
}
