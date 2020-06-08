@extends('layouts.app')
@section('page-title','Main page')
@section('content')
   <div class="container">
       <new-slider-component :films="{{json_encode($schedule)}}"></new-slider-component>
       <carousel-component :films = "{{$films}}"></carousel-component>
       <list-component :films="{{$films}}"></list-component>
   </div>
@endsection
