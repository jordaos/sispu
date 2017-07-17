function initMap() {
var customMapType = new google.maps.StyledMapType([
    {
        "featureType": "landscape",
        "stylers": [
            {"hue": "#FFBB00"},
            {"saturation": 43.400000000000006},
            {"lightness": 37.599999999999994},
            {"gamma": 1}
        ]
    },
    {
        "featureType": "road.highway",
        "stylers": [
            {"hue": "#FFC200"},
            {"saturation": -61.8},
            {"lightness": 45.599999999999994},
            {"gamma": 1}
        ]
    },
    {
        "featureType": "road.arterial",
        "stylers": [
            {"hue": "#FF0300"},
            {"saturation": -100},
            {"lightness": 51.19999999999999},
            {"gamma": 1}
        ]
    },
    {
        "featureType": "road.local",
        "stylers": [
            {"hue": "#FF0300"},
            {"saturation": -100},
            {"lightness": 52},
            {"gamma": 1}
        ]
    },
    {
        "featureType": "water",
        "stylers": [
            {"hue": "#0078FF"},
            {"saturation": -13.200000000000003},
            {"lightness": 2.4000000000000057},
            {"gamma": 1}
        ]
    },
    {
        "featureType": "poi",
        "stylers": [
            {"hue": "#00FF6A"},
            {"saturation": -1.0989010989011234},
            {"lightness": 11.200000000000017},
            {"gamma": 1}
        ]
    }
], {
    name: 'Mapa personalizado'
});
var customMapTypeId = 'custom_style';

var myLatLng = {lat: -4.970232, lng: -39.015817};//VARIÁVEL QUE DEFINE O CENTRO DO MAPA

    map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 14,
        disableDefaultUI: true,
        zoomControl: true
    });

/* CRIANDO POLIGONO */
 // Construct the polygon.
  var polygonQxd = new google.maps.Polygon({
    paths: qxdCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.00001,
    cursor:'move'
  });
  polygonQxd.setMap(map);


/* CRIANDO A JANELA DE INFORMAÇÕES (APENAS UMA, PARA NÃO SER PERMITIDO ABRIR MUITAS)*/
    var infowindow1 = new google.maps.InfoWindow();

/* CRIANDO OS PONTOS NO MAPA */
    var allMarkers = initMarkers(map);//LISTA COM TODOS OS MARKERS
    var newMaker = new google.maps.Marker({
        title: 'Sugestão!'
    });

/* AO CLICAR NO MAPA, FECHA AS JANELAS ABERTAS */
    map.addListener('click', function() {
        infowindow1.close();
    });


    //ICONS
    // Create the DIV to hold the control and call the CenterControl() constructor
    // passing in this DIV.
    var menuControlDiv = document.createElement('div');
    menuControlDiv.style.margin = '15px';

    menuControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(menuControlDiv);


    // ADICIONAR PONTO
    var bntAdd = document.createElement('div');
    bntAdd.style.width = '40px';
    bntAdd.style.height = '40px';
    bntAdd.style.cursor = 'pointer';
    bntAdd.style.marginBottom = '22px';
    bntAdd.style.textAlign = 'center';
    bntAdd.style.backgroundImage = 'url(view/_img/icons/add.png)';
    bntAdd.style.backgroundSize = '100% 100%';
    bntAdd.title = 'Adicionar um novo ponto';
    bntAdd.setAttribute('id', 'bntAdd');
    menuControlDiv.appendChild(bntAdd);
    
    //FIM - ADICIONAR PONTO

    //CANCELAR ADICIONAR PONTO

    var bntCancel = document.createElement('div');
    bntCancel.style.width = '40px';
    bntCancel.style.height = '40px';
    bntCancel.style.cursor = 'pointer';
    bntCancel.style.marginBottom = '22px';
    bntCancel.style.textAlign = 'center';
    bntCancel.style.display = 'none';
    bntCancel.style.backgroundImage = 'url(view/_img/icons/delete.png)';
    bntCancel.style.backgroundSize = '100% 100%';
    bntCancel.title = 'Adicionar um novo ponto';
    bntCancel.setAttribute('id', 'bntAdd');
    menuControlDiv.appendChild(bntCancel);

    //FIM - CANCELAR ADICIONAR PONTO

    //EVENTO ADD{
    bntAdd.addEventListener('click', function() {
        for(i = 0; i < allMarkers.length; i++){
            allMarkers[i].setMap(null);
        }

        bntCancel.style.display = 'block';//APARECER BOTAO CANCELAR
        bntAdd.style.display = 'none';//OCULTAR BOTAO ADD

        map.mapTypes.set(customMapTypeId, customMapType);
        map.setMapTypeId(customMapTypeId);

        polygonQxd.setOptions({cursor:'pointer'});

        /* PEGAR COORDENADAS DO CLICK */
        eventoClick = google.maps.event.addListener(polygonQxd, "click", function (e) {
            //lat and lng is available in e object
            var latLng = e.latLng;
            newMaker.setPosition(latLng);
            newMaker.setMap(map);

            /* GEOCODER PARA O FORMULÁRIO */
            var geocoder = new google.maps.Geocoder;
            geocodeLatLng(geocoder, map, infowindow1, latLng, newMaker);

            /* ABRIR FORMULÁRIO */
            $("#selecionarPonto").addClass("dialog--open");
        });
        
        var controlUI = document.getElementById('controlCancel');

        centerControlDiv.style.display = 'block';
        if(controlUI == null){
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
        }
    });
    //}FIM - EVENTO ADD

    //EVENTO CANCELAR ADD{
    bntCancel.addEventListener('click', function() {
        for(i = 0; i < allMarkers.length; i++){//Voltar os markers novamente
            allMarkers[i].setMap(map);
        }

        bntCancel.style.display = 'none';//OCULTAR BOTAO CANCELAR
        bntAdd.style.display = 'block';//APARECER BOTAO ADD

        google.maps.event.removeListener(eventoClick);//Remover o  evento de ->
        //<- SELECIONAR UM PONTO NO MAPA QUANDO ESCOLHE "SELECIONAR PONTO"
        google.maps.event.clearListeners(map, eventoClick);


        newMaker.setMap(null);//Remove o MARKER do ponto selecionado

        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);//Voltar o estilo do mapa ao padrão.
        centerControlDiv.style.display = 'none';//Ocultar o botão "cancelar"

        map.setZoom(14);
        polygonQxd.setOptions({cursor:'move'});
    });
    //} FIM - EVENTO CANCELAR ADD

}

function geocodeLatLng(geocoder, map, infowindow, latlng, newMaker) {
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                map.setZoom(17);
                //Preencher formulário com o local escolhido:
                $("#localSugerido").val(results[1].formatted_address);
                $("#latitude").val(latlng.lat());
                $("#longitude").val(latlng.lng());
                infowindow.setContent(results[1].formatted_address);
                infowindow.open(map, newMaker);
            } else {
                window.alert('Endereço não encontrado.');
            }
        } else {
            window.alert('Não é possível realizar a busca neste local. Tente novamente.');
        }
    });
}
