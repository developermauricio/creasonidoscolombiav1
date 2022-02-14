@extends('layouts.app')
@push('css')
    {{--    <script src="/app-assets/vendors/js/extensions/plyr.min.js"></script>--}}
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/plyr.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/extensions/ext-component-media-player.css">
@endpush
@push('js')

    {{--    <script src="/app-assets/js/scripts/extensions/ext-component-media-player.js"></script>--}}
@endpush
@section('title', 'Subsanador')

@section('content')
{{--    <h1>Hola subsanador proyectos</h1>--}}
    <subsanador-project-component></subsanador-project-component>
@endsection

