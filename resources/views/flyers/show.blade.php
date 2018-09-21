@extends('layout.master')
@section('content')
    <h1>
        {{$flyer->street}}
    </h1>
    <h2>${{$flyer->price}}</h2>
    <p>
        {{$flyer->description}}
    </p>
<div class="row">
    <div class="col-md-10">

        @foreach( $flyer->photos as $photo)
            <img src="{{$photo->path}}" alt="" width="30%" height="200px" style="display: inline; margin-left: 3%">
        @endforeach

    </div></div>
    <br>
    <hr>
    <div>
        @if(auth()->check())
        @if(auth()->user()->owns($flyer))
        <form
                action="{{route('store-photo-path' ,[$flyer->zip , $flyer->street] )}}"
                method="post" enctype="multipart/form-data" class="dropzone">
        {{csrf_field()}}
            {{--<input type="file" name="photo" />--}}

        </form>
            @endif
        @endif

    </div>
    <div>
        <br><br><br><br>
    </div>
@stop