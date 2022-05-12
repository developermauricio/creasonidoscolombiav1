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
    <!--=====================================
		LISTA DE USUARIOS REGISTRADOS
    ======================================-->
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <table
                    class="datatables-all-users hover table-responsive datatables-basic table table-striped"
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
    <!--=====================================
        MODAL CREAR USUARIOS
    ======================================-->
    <div class="modal fade text-left modal-primary" id="modal-new-user" data-backdrop="static" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <create-user-component></create-user-component>
        </div>
    </div>
    <!--=====================================
        MODAL MOSTRAR USUARIOS
    ======================================-->
    <div class="modal fade text-left modal-primary" id="modal-show-user" data-backdrop="static" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <show-user-component id="show-user-component" idUser></show-user-component>
        </div>
    </div>
@endsection

@push('js')
    <script src="/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    {{--    <script src="/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js"></script>--}}
    <script src="/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
    <script src="/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endpush

@push('js')
    <script>
        $(function () {
            let table = null;
            setTimeout(() => {
                     table = $('.datatables-all-users').DataTable({

                        "processing": true,
                        "lengthMenu": [7, 10, 25, 50, 75, 100],
                        // "scrollY": 800,
                        // "scrollX": true,
                        // "responsive": true,
                        // "scrollCollapse": true,
                        // "paging": false,
                        // "fixedColumns": {
                        //     "leftColumns": 2,
                        // },
                        "pageLength": 10,
                        "autoWidth": false,
                        "columnDefs": [{
                            "defaultContent": "-",
                            "targets": "_all"
                        }],
                        "drawCallback": function (settings) {
                            feather.replace();
                        },
                        // "columnDefs": [
                        //     {"width": '10%', targets: 0},
                        // ],
                        "order": [[1, 'asc']],

                        "ajax": {
                            url: "{{route('get.api.users')}}",
                        },
                        "columns": [
                            {"data": "id"},
                            {
                                render: function (data, type, JsonResultRow, meta) {
                                    if (JsonResultRow.name === null) {
                                        return '<span class="label label-danger text-center" style="color:#F05E7D !important">Ningún valor por defecto</span>'
                                    } else {
                                        return `<span class="label text-center font-weight-bold"><a href="/${window.lang}/customers/profile/${JsonResultRow.slug}">${JsonResultRow.name} ${JsonResultRow.last_name}</a></span>`;
                                    }
                                },
                            },
                            {
                                render: function (data, type, JsonResultRow, meta) {
                                    if (JsonResultRow.roles === null) {
                                        return '<span class="label label-danger text-center" style="color:#F05E7D !important">Ningún valor por defecto</span>'
                                    } else {
                                        return JsonResultRow.roles.map(function (obj) {
                                            return `<div class="badge badge-primary">${obj.name}</div>`
                                        }).join("-")
                                    }
                                },
                            },
                            {
                                render: function (data, type, JsonResultRow, meta) {
                                    if (JsonResultRow.document === null) {
                                        return '<span class="label label-danger text-center" style="color:#F05E7D !important">Ningún valor por defecto</span>'
                                    } else {
                                        return `<span class="label text-center font-weight-bold">${JsonResultRow.document}</span>`;
                                    }
                                },
                            },
                            {
                                render: function (data, type, JsonResultRow, meta) {
                                    if (JsonResultRow.email === null) {
                                        return '<span class="label label-danger text-center" style="color:#F05E7D !important">Ningún valor por defecto</span>'
                                    } else {
                                        return `<span class="label text-center font-weight-bold">${JsonResultRow.email}</span>`;
                                    }
                                },
                            },
                            {
                                render: function (data, type, JsonResultRow, meta) {
                                    if (JsonResultRow.phone === null) {
                                        return '<span class="label label-danger text-center" style="color:#F05E7D !important">Ningún valor por defecto</span>'
                                    } else {
                                        return `<span class="label text-center font-weight-bold">${JsonResultRow.phone}</span>`;
                                    }
                                },
                            },


                            {
                                render: function (data, type, JsonResultRow, meta) {
                                    if (JsonResultRow.state === "1") {
                                        return '<div class="badge badge-pill badge-glow badge-success">Activo</div>'
                                    } else {
                                        return `<div class="badge badge-pill badge-glow badge-danger">Inactivo</div>`;
                                    }
                                },
                            },{
                                render: function (data, type, JsonResultRow, meta) {
                                    return '<div class="demo-inline-spacing text-center"><button data-target="#modal-show-user" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Más Información" type="button" class="btn btn-show-user btn-icon btn-primary"><i data-feather="eye"></i><span class="mt-2"></span></button></div>'

                                }
                                ,
                            }
                        ],


                        "language": {
                            "sProcessing": "Procesando"
                            , "sLengthMenu": "Mostrar _MENU_ Registros"
                            , "sZeroRecords": "No se encontraron resultados"
                            , "sEmptyTable": "No hay datos"
                            , "sInfo": "Mostrando  _END_ de _TOTAL_ registros"
                            , "sInfoEmpty": "{{ __('mostrando_registros_del_cero') }}"
                            , "sInfoFiltered": "(filtrado de un total de _MAX_ registros)"
                            , "sInfoPostFix": ""
                            , "sSearch": "Buscar:"
                            , "sUrl": ""
                            , "sInfoThousands": ","
                            , "sLoadingRecords": "Cargando"
                            , "oPaginate": {
                                "sFirst": "Primero"
                                , "sLast": "Último"
                                , "sNext": "Siguiente"
                                , "sPrevious": "Anterior"
                            }
                            , "oAria": {
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente"
                                , "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        },
                        "dom":
                            '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        // "displayLength": 7,
                        "buttons": [
                            {
                                "extend": 'collection',
                                "className": 'btn btn-outline-secondary theme-light dropdown-toggle mr-2',
                                "text": feather.icons['share'].toSvg({class: 'font-small-4 mr-50'}) + 'Exportar',
                                "buttons": [
                                    {
                                        "extend": 'print',
                                        "text": feather.icons['printer'].toSvg({class: 'font-small-4 mr-50'}) + 'Imprimir',
                                        "className": 'dropdown-item',
                                        "exportOptions": {columns: [0, 1, 3, 4, 5, 6, 7, 8]},
                                        "customize": function (win) {
                                            console.log(window.url, window.logo_ligth)
                                            $(win.document.body)
                                                .css('font-size', '10pt')
                                                .prepend(
                                                    `<div align='center' style="text-align: center;top:50%;"><img width="550" src="${window.url}${window.logo_ligth}" style=" opacity: 12%;" /></div>`
                                                );

                                            $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                        }
                                    },
                                    {
                                        "extend": 'csv',
                                        "text": feather.icons['file-text'].toSvg({class: 'font-small-4 mr-50'}) + 'Csv',
                                        "className": 'dropdown-item',
                                        "exportOptions": {columns: [0, 1, 3, 4, 5, 6, 7, 8]}
                                    },
                                    {
                                        "extend": 'excel',
                                        "text": feather.icons['file'].toSvg({class: 'font-small-4 mr-50'}) + 'Excel',
                                        "className": 'dropdown-item',
                                        "exportOptions": {columns: [0, 1, 3, 4, 5, 6, 7, 8]}
                                    },
                                    {
                                        "extend": 'pdf',
                                        "text": feather.icons['clipboard'].toSvg({class: 'font-small-4 mr-50'}) + 'Pdf',
                                        "className": 'dropdown-item',
                                        "exportOptions": {columns: [0, 1, 3, 4, 5, 6, 7, 8]},
                                        "orientation": 'landscape',
                                        "customize": function (doc) {
                                            doc.content.splice(1, 0, {
                                                margin: [0, 0, 0, 12],
                                                alignment: 'center',
                                                image: window.logo_base_64
                                            });
                                        }
                                    },
                                    {
                                        "extend": 'copy',
                                        "text": feather.icons['copy'].toSvg({class: 'font-small-4 mr-50'}) + 'Copiar',
                                        "className": 'dropdown-item',
                                        "exportOptions": {columns: [0, 1, 3, 4, 5, 6, 7, 8]}
                                    }
                                ],
                                // init: function (api, node, config) {
                                //     $(node).removeClass('btn-secondary');
                                //     $(node).parent().removeClass('btn-group');
                                //     setTimeout(function () {
                                //         $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                                //     }, 50);
                                // }
                            },
                            {
                                text: feather.icons['plus'].toSvg({class: 'mr-50 font-small-4'}) + 'Nuevo Usuario',
                                className: 'create-new btn btn-primary',
                                attr: {
                                    'data-target': '#modal-new-user',
                                    'data-toggle': 'modal'
                                },
                                init: function (api, node, config) {
                                    $(node).removeClass('btn-secondary');
                                }
                            }
                        ],

                    })
                    let text = 'Usuarios Registrados'
                    $('div.head-label').html(`<h6 class="mb-0">${text}</h6>`);
                    table.on('order.dt search.dt', function () {
                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                }, 10);
            $('.datatables-all-users').on('click', '.btn-show-user', function (e) {
                var dataTableUser = table.row($(this).parents('tr')).data();
                $('#traerDatosBotonCustomer').val(dataTableUser.id).click();
                $('#show-user-component').attr("id-user", dataTableUser.id)
                // $('#traerDatosBotonCustomer').val(dataTableCustomer.id).click();
                // $('#componet-show-customer').attr("id-customer", dataTableCustomer.id)
            });
        });

    </script>
@endpush
