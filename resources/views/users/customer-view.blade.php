@extends('templates.index')

@section('page-title')
    Customer
@stop

@section('title')
    customer
@stop

@section('content')
    <div class="card mt-3">
        <div class="card-body p-0 p-2">
            <form action="{{url('profile')}}" method="post" name="profile-form" id="profile-form">
                @csrf
                <input type="hidden" name="id" value="{{@$customer->id}}">
                <input type="hidden" name="role" value="{{@$customer->role_id_fk}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" placeholder="John Doe" value="{{@$customer->name}}"
                                   name="name" id="name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" placeholder="test@gmail.com"
                                   value="{{@$customer->email}}"
                                   name="email" id="email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="text" class="form-control" placeholder="03053609490"
                                   value="{{@$customer->phone}}"
                                   name="phone" id="phone">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" placeholder="sadiqabad"
                                   value="{{@$customer->address}}"
                                   name="address" id="address">
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-sm btn-success px-3"><i class="far fa-save mr-2"></i>Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 my-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <span class="d-block"><i class="fa fa-dollar-sign"></i></span>
                            <span class="d-block">Total</span>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{@$account->total}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 my-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <span class="d-block"><i class="fa fa-dollar-sign"></i></span>
                            <span class="d-block">Paid</span>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{@$account->receive}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 my-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <span class="d-block"><i class="fa fa-dollar-sign"></i></span>
                            <span class="d-block">Remaining</span>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{@$account->remain}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header bg-light p-0 p-2">
                    <h5 class="m-0 p-1">Sales</h5>
                </div>
                <div class="card-body p-0 p-1">
                    @if(sizeof(@$sales) > 0)
                        <div class="accordian">
                            @foreach(@$sales as $key => $sale)
                                <div class="border-1 m-1">
                                    <div class="">
                                        <button
                                            class="btn btn-success w-100 d-flex justify-content-between align-items-center"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#my{{$key}}"
                                            aria-expanded="{{$key == 0 ? 'true' : 'false'}}"
                                            aria-controls="my{{$key}}">
                                            <div class="w-50 d-flex justify-content-between align-items-center">
                                                <span>{{$key+1}} - {{showDateTime($sale->created_at)}}</span>
                                                <span class="font-weight-bold">Total: {{$sale->total}}</span>
                                            </div>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div id="my{{$key}}" class="collapse {{$key == 0 ? 'show' : 'false'}}">
                                        <div class="accordion-body p-1 m-1 shadow-sm border">
                                            <table class="table table-sm">
                                                <tr class="bg-light">
                                                    <th colspan="3">Products</th>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                </tr>
                                                @if(sizeof($sale->items) > 0)
                                                    @foreach(@$sale->items as $item)
                                                        <tr>
                                                            <td>{{$item->product ? $item->product->name : 'N/A'}}</td>
                                                            <td>{{$item->quantity}} -
                                                                ({{$item->product ? $item->product->unit ? $item->product->unit->name : 'N/A' : 'N/A'}}
                                                                )
                                                            </td>
                                                            <td>Rs. {{$item->amount}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="bg-light">
                                                        <th colspan="3">No Items Found!</th>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>
                            <p class="text-center">No Sale Found!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header bg-light p-0 p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0 p-1">Payments</h5>
                        <button class="btn btn-sm btn-success btn-payment" data-id="{{@$customer->id}}"><i
                                class="far fa-plus-square mr-1"></i>Payment
                        </button>
                    </div>
                </div>
                <div class="card-body p-0 p-1">
                    <div class="p-2">
                        <table id="payment-table" class="table table-sm table-striped">
                            <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(is_iterable(@$customer->payments))
                                @foreach(@$customer->payments as $key => $payment)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{showDateTime($payment->created_at)}}</td>
                                        <td>{{$payment->total}}</td>
                                        <td>{{$payment->receive}}</td>
                                        <td>{{$payment->remain}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Payment Found!</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#payment-table").DataTable({
                processing: true,
            });

            // Payment
            $(".btn-payment").on('click', function () {
                var id = $(this).data('id');
                open_modal('/sales/payment/' + id);
            });
        });
    </script>
@stop
