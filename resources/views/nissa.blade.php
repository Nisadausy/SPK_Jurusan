@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Love Message</h1>
        @for($i = 1; $i <= 100; $i++)
            <p>I love you</p>
        @endfor
    </div>
@endsection