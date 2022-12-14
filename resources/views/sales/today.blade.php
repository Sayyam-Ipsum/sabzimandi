@extends('templates.index')

@section('page-title')
    Today Sale
@stop

@section('title')
    today sale
@stop

@section('page-actions')
@stop

@section('content')
    <div>
        <table id="data-table" class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                columnsDefs: [{
                    orderable: true
                }],
                ajax: {
                    url: "/sales/today",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'total',
                        name: 'total',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                    },
                ]
            });
        });

        //-- View
        $("#data-table").on('click', '.btn-view', function() {
            var id = $(this).data('id');
            open_modal('/sales/' + id);
        });
    </script>
@stop
