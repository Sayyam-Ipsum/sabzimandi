@extends('templates.index')

@section('page-title')
    Customers
@stop

@section('title')
    customers
@stop

@section('page-actions')
    @include('partials.add-button', ['class_name' => 'btn-add', 'text' => 'new customer'])
@stop

@section('content')
    <div>
        <table id="data-table" class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
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
                    url: "/customers",
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'address',
                        name: 'address',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                    },
                ]
            });
        });

        // Sales
        $("#data-table").on('click', '.btn-sales', function() {
            var id = $(this).data('id');
            open_modal('/sales?customer=' + id);
        });

        //-- Edit
        $("#data-table").on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            open_modal('/users/edit/' + id + '?customer=1');
        });

        // Create
        $(".btn-add").click(function() {
            open_modal('{{url('users/create?customer=1')}}');
        });

        // Status
        $("#data-table").on('click', '.btn-status', function () {
            var id = $(this).data('id');
            Swal.fire({
                html: "Are you sure?",
                icon: "warning",
                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText: "No",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger',
                },
            }).then((result) => {
                if (!result.value) return;
                $.ajax({
                    url: "{{url('users/status')}}/" + id,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success: function (res) {
                        if (res.success == 1) {
                            toast(res.message, 'success');
                            setTimeout(function (){
                                window.location.reload();
                            }, 500);
                        } else {
                            toast(res.message, 'error');
                        }
                    }
                });
            });
        });

    </script>
@stop
