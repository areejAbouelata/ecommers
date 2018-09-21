@extends('layout.master')

@section('content')

    <h1>selling Your Home </h1>
    <form action="/flyers-store" method="post" enctype="multipart/form-data">


        @include('flyers.form')
    <div class="row">
        @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li> {{$error}}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    </form>
@stop