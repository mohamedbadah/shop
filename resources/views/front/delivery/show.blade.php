<x-front-layout title="delivery order">
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{$order->number}}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="index.html">Shop</a></li>
                            <li>Order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>
    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div id="map" height="50vh"></div> 
                </div>
            </div>
        </div>
    </section>
    <script>
   // Initialize and add the map
function initMap() {
  // The location of Uluru
  const location = { lat: -25.344, lng: 131.031 };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: location,
  });
  // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: location,
    map: map,
  });
}

window.initMap = initMap;
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCW6sRmfvtRmle8QzcN775zpiMVw0xxfmA&callback=initMap&v=weekly"
      defer
    ></script>
</x-front-layout>