@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css"
          href="/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
          href="/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
@endpush

@section('title', 'Usuarios')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <table
                    class="datatables-all-clients hover datatablescreategica table-responsive datatables-basic table table-striped"
                    style="width:100%">
                    <thead>
                    <tr>
                        <th style="max-width: 30% !important;">id</th>
                        <th>Nombre y Apellidos</th>
                        <th>Rol</th>
                        <th>Identificación</th>
                        <th>Correo electrónico</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <tr class="tr-filter-dekstop-provider">
                        <th></th>
                        <th></th>
                        <th class="filter-2" style="max-width: 30% !important;"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="filter-6"></th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

