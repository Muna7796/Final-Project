@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('List of Blood Bank') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Blood Bank Name</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <th>Distance</th>
                                    </tr>
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
</div>
@stop
@section('js')

@stop