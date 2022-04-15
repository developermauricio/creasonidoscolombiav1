@extends('layouts.app')
@push('css')
{{--    <script src="/app-assets/vendors/js/extensions/plyr.min.js"></script>--}}
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/plyr.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/extensions/ext-component-media-player.css">
@endpush
@push('js')

{{--    <script src="/app-assets/js/scripts/extensions/ext-component-media-player.js"></script>--}}
@endpush
@section('title', 'Registro')

@section('content')
    <!-- <h1>Hola curador estas en tus proyectos</h1> -->
    {{-- @dd(App\User::getCurador(auth()->user()->id)) --}}
    <curador-project-component :user="{{ \App\User::getCurador(auth()->user()->id)}}"></curador-project-component>
{{--    <curador-project-component></curador-project-component>--}}
@endsection


