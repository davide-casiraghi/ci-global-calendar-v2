@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin=""/>
@stop

@section('javascript')
    @parent

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>

    <script src="{{asset('images/leaflet-color-markers/js/leaflet-color-markers.js')}}" ></script>

    <script>
        var map = L.map('mapid').setView(
            [
                {{ $userLat }},
                {{ $userLng }}
            ],
                {{ config('leaflet.zoom_level') }}
        );

        var baseUrl = "{{ url('/') }}";

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        /*L.marker([51.5, -0.09]).addTo(map)
        .bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();
        */

        //L.geoJson({!!$activeEventMarkersJSON!!}).addTo(map);
        L.geoJson({!!$activeEventMarkersJSON!!},{
            pointToLayer: function(feature,latlng){
                var icon_color = feature.properties.IconColor;
                var marker = L.marker(latlng,{icon: window[icon_color]});  //Icon colors are defined in /images/leaflet-color-markers/js/leaflet-color-markers.js
                //var marker = L.marker(latlng,{icon: greenIcon});
                //var marker = L.marker(latlng);

                console.log(feature.properties.NextDate);
                marker.bindPopup(
                    '<b><a href="'+feature.properties.Link+'">' +feature.properties.Title + '</a></b>' +
                    '<br/>' +
                    feature.properties.Category +
                    '<br/>' +
                    feature.properties.NextDate +
                    '<br/><br/>' +
                    '<b>' + feature.properties.VenueName + '</b>' +
                    '<br/>' +
                    feature.properties.City +' - '+ feature.properties.Address +
                    '<br/>'
                );
                return marker;
            }
        }).addTo(map);

    </script>

@stop

@section('content')

    <div class="text-lg mx-auto mt-10 mb-10 px-10 text-gray-500">
        <h1 class="leading-6 text-3xl font-semibold text-gray-700">
            CIGC Geomap
        </h1>

        {{-- GEOMAP --}}
        <div class="card mt-6">
            <div class="min-h-screen" id="mapid" style="z-index:1;"></div>
        </div>

        {{-- Legend --}}
        <div class="grid grid-cols-4 md:grid-cols-10 gap-4 mt-10">
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-green.png')}}" alt="green marker">
                <br>
                Regular Jam
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-yellow.png')}}" alt="yellow marker">
                <br>
                Special Jam
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-gold.png')}}" alt="gold marker">
                <br>
                Class
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-orange.png')}}" alt="orange marker">
                <br>
                Workshop
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-red.png')}}" alt="red marker">
                <br>
                Festival <br> Camp <br> Journey
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-blue.png')}}" alt="green marker">
                <br>
                Underscore
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-violet.png')}}" alt="violet marker">
                <br>
                Performance <br> Lecture <br> Conference <br> Film <br> Other event
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-grey.png')}}" alt="grey marker">
                <br>
                Lab
            </div>
            <div class="col-span-1 md:col-span-2 text-center">
                <img class="inline" src="{{asset('images/leaflet-color-markers/img/marker-icon-black.png')}}" alt="black marker">
                <br>
                Teachers Meeting
            </div>
        </div>

        <div class="bg-yellow-100 rounded-lg py-5 px-6 mt-8 text-base text-yellow-700 mb-3" role="alert">
            <b>For event organizers</b>
            If the venue of your event doesn't show up correctly, please check that all the data of the venue's address such as street or postcode are specified.
            <br>
            We are still working to improve the geo-coding of Chinese and Japanese venues.
        </div>
    </div>

@endsection