@extends('admin.template')
@section('content')
<link rel="stylesheet" href="{{asset('site/css/geolocation.css')}}">
<div class="container">
    <div class="row justify-content-center">
        <!-- if boold information  not exisit then only show -->
       
            <div class="col-md-12">
                 <div class="card">
                <div class="card-header">{{ $bank->name }}</div>

                <div class="card-body">
                	
                			 @if(session('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-primary" role="alert">
                                        {{ session('message') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                		
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Uplaod {{$bank->name}} Location</h5>
                           <div>
                           	 <form action="{{route('admin.postBloodbankgeolocation', $bank->id)}}" method="post"> 
            @csrf
            <div class="mapform" >
                <div class="row">
                    <div class="col-5">
                        <input type="text" class="form-control" placeholder="lat" name="lat" id="lat">
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control" placeholder="lng" name="lng" id="lng">
                    </div>
                </div>

                <div id="map" style="height:400px; width: 800px;" class="my-3"></div>

              
            </div>

            <input type="submit" class="btn btn-primary">
        </form>
                           </div>
                        
                        </div>
                       
                   </div>

                
                </div>
            </div>
            </div>
        
    </div>
</div>
@stop
@section('js')
  <script>
                    let map;
                    
                    function initMap() {
                        map = new google.maps.Map(document.getElementById("map"), {
                            center: { lat: 27.692931749822886, lng: 85.32599781852055 },
                            zoom: 8,
                            scrollwheel: true,
                        });
                        const uluru = { lat: 27.692931749822886, lng: 85.32599781852055 };
                        let marker = new google.maps.Marker({
                            position: uluru,
                            map: map,
                            draggable: true
                        });
                        google.maps.event.addListener(marker,'position_changed',
                            function (){
                                let lat = marker.position.lat()
                                let lng = marker.position.lng()
                                $('#lat').val(lat)
                                $('#lng').val(lng)
                            })
                        google.maps.event.addListener(map,'click',
                        function (event){
                            pos = event.latLng
                            marker.setPosition(pos)
                        })
                    }
                </script>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
                        type="text/javascript"></script>
@stop