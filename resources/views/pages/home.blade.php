@extends('layout.master')


@section('content')

<header class="jumbotron my-4">
 <h1>Project flyer</h1>
 <h1 class="display-3">A Warm Welcome!</h1>
 <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam  eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
 @if(auth()->check())
 <a href="/flyers/create" class="btn btn-primary btn-lg">Create Flyer
 </a>
  @else
  <a href="{{route('login')}}" class="btn btn-primary btn-lg">sign in
  </a>

 @endif
</header>

 @stop