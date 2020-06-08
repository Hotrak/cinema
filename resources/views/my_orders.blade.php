{{--{{dd($orders)}}--}}
@extends('layouts.app')
@section('page-title','Main page')
@section('content')
    <div class="container">
        <carousel-component :films="{{$films}}"></carousel-component>
        <order-component></order-component>
    </div>
@endsection

