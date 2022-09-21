@extends('templates.index')

@section('page-title')
    Sales
@stop

@section('title')
    sales
@stop

@section('page-actions')
@stop

@section('content')
    <div class="row my-2">
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label">From:</label>
                <input type="date" class="form-control" name="min" id="min">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label">To:</label>
                <input type="date" class="form-control" name="max" id="max">
            </div>
        </div>
        <div class="col-lg-4">
            <label class="text-light">test</label><br>
            <button class="btn btn-sm btn-success mt-1 mr-1" id="btn-filter"><i class="fa fa-filter mr-1"></i>Filter</button>
            <button class="btn btn-sm btn-secondary mt-1" id="btn-clear"><i class="fa fa-sync mr-1"></i>Clear</button>
        </div>
    </div>
    <div>
        <table id="data-table" class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>Date</th>
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
        // var minDate, maxDate;


        $(document).ready(function() {
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var min = $("#min").val() ? new Date(moment($("#min").val(), 'DD-MM-YYYY')) : '';
                    var max = $("#max").val() ? new Date(moment($("#max").val(), 'DD-MM-YYYY')) : '';
                    var date = data[0] ? new Date(moment(data[0], 'DD-MM-YYYY')) : '';
                    if (
                        ( min === '' && max === '' ) ||
                        ( min === '' && date <= max ) ||
                        ( min <= date   && max === '' ) ||
                        ( min <= date   && date <= max )
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            var table = $('#data-table').DataTable({
                processing : true,
                columnDefs : [{
                    orderable: true,
                }],
                serveSide : true,
                ajax: {
                    url: "/sales",
                },
                columns: [
                    {
                        data: 'date',
                        name: 'date',
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

            $('#btn-filter').on('click', function () {
                table.draw();
            });
            $('#btn-clear').on('click', function () {
                $("#min, #max").val('');
                table.draw();
            });
        });

        //-- View
        $("#data-table").on('click', '.btn-view', function() {
            var id = $(this).data('id');
            open_modal('/sales/' + id);
        });

    </script>
@stop
