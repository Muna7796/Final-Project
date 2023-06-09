@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('site/css/user/contribution.css')}}">

<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Your Contribution') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Donate Date</th>
                                        <th>Donate Blood</th>
                                        <th>Donate at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($donates->count())
                                        @foreach($donates as $item)
                                            <tr>
                                                <td>{{$item->donate_date}}</td>
                                                <td>
                                                    {{$item->blood_group}}
                                                </td>
                                                <td>{{$item->donate_at }}</td>
                                            </tr> 
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4"> No any contribution yet</td>
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