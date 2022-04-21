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

<div class="modal fade text-left" id="modal-changed-password" tabindex="-1" role="dialog"
     aria-labelledby="modal-changed-password" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel173">Cambiar contraseña</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1>Cambiar contraseña</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

