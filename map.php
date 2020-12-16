<style>
    #map {
        height: 400px;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div class="row">
<div id="map" class="col-lg-12"></div>
</div>


<!-- Replace YOUR_API_KEY here by your key above -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmSXczIGtm-tQoEZQTivnS8vdketE7_M8&callback=initMap" async defer>

</script>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 10.778770594304671,
                lng: 106.66061929934857
            },
            zoom: 13
        });

        var latLng1 = {
            lat: 10.778637794880723,
            lng: 106.65918702847331
        }

        var marker1 = new google.maps.Marker({
            position: latLng1,
            animation:google.maps.Animation.BOUNCE,
            map: map,
        });

        var latLng2 = {
            lat: 10.776346208390587,
            lng: 106.66953853618632
        }

        var marker2 = new google.maps.Marker({
            position: latLng2,
            map: map,
            animation:google.maps.Animation.BOUNCE
        });

        var latLng3 = {
            lat: 10.761450471145679, 
            lng: 106.64606539897794
        }

        var marker3 = new google.maps.Marker({
            position: latLng3,
            map: map,
            animation:google.maps.Animation.BOUNCE
        });

       
    }
</script>