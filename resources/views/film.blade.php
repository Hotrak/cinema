{{--{{dd($film->getSchedule())}}--}}
@extends('layouts.app')
@section('page-title','Main page')
@section('content')
    <div class="container">
        <carousel-component :films="{{$films}}"></carousel-component>
        <film-component :film="{{$film}}"></film-component>
        <session-component :datat="{{json_encode($film->getSchedule())}}" :film="{{$film}}" :films="{{$films}}"></session-component>
        <trailer-component :url="{{json_encode($film->video_url)}}"></trailer-component>
        <comment-component :film_id="{{json_encode($film->id)}}"></comment-component>
    </div>
@endsection

