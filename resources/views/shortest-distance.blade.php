@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Shortest Distance Finder</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/shotestdistance.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</head>

<body>
    <div class="container">
        <h1>Shortest Distance Finder</h1>
        <form id="distance-form" method="POST" action="{{ url('/test') }}">
            @csrf

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <button type="submit">Find Shortest Distance</button>
        </form>
    </div>
</body>

</html>
@endsection