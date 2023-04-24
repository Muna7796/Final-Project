@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('site/css/user/bloodbanklist.css')}}">
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('List of Blood Bank') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Blood Bank Name</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <th>Distance</th>
                                       
                                </thead>
                                <tbody>
                                    @if($bloodbanks->count())
                                    @php $userinfo = App\Models\User::find(Auth()->user()->id); @endphp
                                        @foreach($bloodbanks as $item)

                                        	@php
                                        		 $distance = App\Models\Distance::getDistanceBetweenPointsNew($userinfo->lat, $userinfo->lng, $item->lat, $item->lng);
                                        	@endphp
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->address}}</td>
                                                <td>{{$item->phone }}</td>
                                                <td>{{$distance}} KM Far from You</td>
                                            </tr> 
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4"> No any blood bank listed</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
    </div>
    <div class="row" style="min-height: 300px;">
        <div class="col-md-12">
             <div class="card" style="margin-top:10px">
                    <div class="card-header">{{ __('Search Nearest Blood Bank from anywhere') }}</div>
                    <div class="card-body">
                        <div class="row">
                           <form id="distance-form" method="GET" action="{{route('user.getFindNearestBloodbank') }}">
                                @csrf
                                <label for="location">Location:</label>
                                <input type="text" id="location" name="location" required>
                                <button type="submit">Find Shortest Distance</button>
                            </form>
                            @if($result != Null)
                                <h3>{{$result}}</h3>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@stop
@section('js')

@stop