@extends('templates.index')

@section('page-title')
    POS
@stop

@section('title')
    POS
@stop

@section('page-actions')
    @include('partials.add-button', ['class_name' => 'btn-add', 'text' => 'new customer'])
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="row productRow">
                @foreach(@$products as $key => $product)
                    <div class="col-3 p-0 p-1 mb-1">
                        <button class="btn btn-outline-success w-100 py-5 product-btn" data-product="{{$product}}">
                            {{$product->name}}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-1">
                <select class="form-control select2 mb-2" name="customer" onchange="getCustomerPayment(this)">
                    <option value="">Select Customer</option>
                    @foreach(@$customers as $key => $customer)
                        <option value="{{@$customer->id}}">{{@$customer->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-1">
                <table class="table table-success table-hover align-middle posTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        {{--                        <th>Unit</th>--}}
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tr id="noProductRow">
                        <td colspan="5" class="text-center table-active">No Product in Cart</td>
                    </tr>
                    <tbody id="productTableBody">
                    </tbody>
                    <tfoot>
                    <tr class="table-active">
                        <td colspan="1">Total Amount</td>
                        <td class="totalAmountTD font-weight-bold" colspan="4">0</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="bg-light text-right d-grid">
                <button class="btn btn-success checkoutBtn">Checkout</button>
            </div>
            <div class="card payment-box">
                <div class="card-header bg-light p-0 p-2">
                    <h5 class="m-0 p-1">Add Payment</h5>
                </div>
                <form action="/payment" method="post" id="payment-form" name="payment-form">
                    @csrf
                    <input type="hidden" name="payment_id" id="payment_id">
                    <div class="card-body row p-0 p-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="total">Total</label>
                                <input type="number" class="form-control form-control-sm" name="total"
                                       id="total" readonly placeholder="Total">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="payable">Payable</label>
                                <input type="number" class="form-control form-control-sm" name="payable"
                                       id="payable" placeholder="Payable">
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-dollar-sign mr-1"></i>Pay</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        // Create Customer
        $(".btn-add").click(function () {
            open_modal('{{url('users/create?customer=1')}}');
        });

        var productArray = [];
        var totalAmount = 0;
        var productCheck = true;
        $(".checkoutBtn").hide();
        $(".payment-box").hide();

        $(".productRow").on('click', '.product-btn', function () {
            productCheck = true;
            $("#noProductRow").hide();
            var product = $(this).data('product');

            if ($("tr.tableRow").length + 1 <= 1) {
                var row = "";
                row += `<tr class="tableRow">`;
                row += `<td class="proId d-none">${product.id}</td>`;
                row += `<td class="proName">${product.name}</td>`;
                // row += `<td class="">${product.unit ? product.unit : 'N/A'}</td>`;
                row += `<td class="proQty"><input type="number" onkeyup="quantityChange(this)" class="form-control form-control-sm" name="qty" placeholder="${product.unit.name}" id="quantity"></td>`;
                row += `<td class="proTotal"><input type="number" onkeyup="totalChange(this)" class="form-control form-control-sm" name="total" placeholder="total" id="total"></td>`;
                row += `<td class="proCancel"><button onclick="deleteProduct(this)" class="btn"><i class="fa fa-times"></i></button></td>`;
                row += `</tr>`;
                $("#productTableBody").append(row);
                checkTotal();
            } else {
                $("tr.tableRow").each(function () {
                    if ($(this).find("td.proName").text() == product.name) {
                        // console.log('hello');
                        // $(this).find("td.proQty").find("input[name='qty']").val(parseInt($(this).find("td.proQty").find("input[name='qty']").val()) + 1);
                        productCheck = false;
                        console.log('false');
                    }
                });

                if (productCheck) {
                    var row = "";
                    row += `<tr class="tableRow">`;
                    row += `<td class="proId d-none">${product.id}</td>`;
                    row += `<td class="proName">${product.name}</td>`;
                    // row += `<td class="">${product.unit ? product.unit : 'N/A'}</td>`;
                    row += `<td class="proQty"><input type="number" onkeyup="quantityChange(this)" class="form-control form-control-sm" name="qty" placeholder="${product.unit.name}" id="quantity"></td>`;
                    row += `<td class="proTotal"><input type="number" onkeyup="totalChange(this)" class="form-control form-control-sm" name="total" placeholder="total" id="total"></td>`;
                    row += `<td class="proCancel"><button  onclick="deleteProduct(this)" class="btn"><i class="fa fa-times"></i></button></td>`;
                    row += `</tr>`;
                    $("#productTableBody").append(row);
                    checkTotal();
                }
            }
        });

        function checkTotal() {
            if (totalAmount > 0) {
                $(".checkoutBtn").fadeIn();
            } else {
                $(".checkoutBtn").fadeOut();
            }
        }

        function quantityChange(ctl) {
            // console.log($(ctl).parents("tr").children("td.proQty").children("input[name='qty']").val());
            // if(typeof parseInt($(ctl).parents("tr").children("td.proQty").children("input[name='qty']").val()) != 'number') {
            //     toast('Quantity must be Number', 'warning');
            // }
        }

        function totalChange(cwt) {
            totals();
        }

        function totals() {
            totalAmount = 0;
            $("tr.tableRow").each(function () {
                let itemValue = $(this).find("td.proTotal").find("input[name='total']").val();
                if (parseFloat(itemValue) > 0) {
                    totalAmount = totalAmount + parseFloat(itemValue);
                }
            });
            $(".totalAmountTD").text(totalAmount);
            checkTotal();
        }

        function deleteProduct(ctl) {
            $(ctl).parents("tr").remove();
            totals();
            if ($("tr.tableRow").length < 1) {
                $("#noProductRow").show();
            }
        }

        $(".checkoutBtn").click(function () {
            let me = true;
            blockUI();
            if ($("select[name='customer']").val() == '') {
                toast('Please Select Customer', 'warning');
                unblockUI();
            } else {
                $("tr.tableRow").each(function () {
                    var obj = {};
                    obj['id'] = parseInt($(this).find("td.proId").text());
                    obj['name'] = $(this).find("td.proName").text();
                    if ($(this).find('td.proQty').find('input[name="qty"]').val() == '') {
                        toast('Quantity must be Number', 'warning');
                        me = false;
                        unblockUI();
                        return '';
                    }
                    obj['qty'] = parseFloat($(this).find('td.proQty').find('input[name="qty"]').val());
                    if ($(this).find('td.proTotal').find('input[name="total"]').val() == '') {
                        toast('Total must be Number', 'warning');
                        me = false;
                        unblockUI();
                        return '';
                    }
                    obj['total'] = parseFloat($(this).find('td.proTotal').find('input[name="total"]').val());
                    productArray.push(obj);
                });
                if (me) {
                    $.ajax({
                        url: "{{url('/pos')}}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'customer_id': $("select[name='customer']").val(),
                            'products': productArray,
                            'total': totalAmount,
                        },
                        cache: false,
                        success: function (res) {
                            unblockUI();
                            if (res.success == 1) {
                                toast(res.message, 'success');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 500);
                            }
                            if (res.success == 2) {
                                toast(res.message, 'error');
                            }
                            if (res.success == 3) {
                                toast(res.message, 'error');
                            }
                        }
                    });
                }

            }
        });

        function getCustomerPayment(cwt) {
            var customer_id = cwt.options[cwt.selectedIndex].value;
            $.ajax({
                url: "{{url('pos/payment')}}/" + customer_id,
                type: "GET",
                dataType: "json",
                cache: false,
                success: function (res) {
                    if (res.success == 1) {
                        if (res.data.payment) {
                            $("#payment_id").val(res.data.payment.id);
                            $("#total").val(res.data.payment.remain == 0 ? res.data.payment.remain : res.data.payment.remain);
                        } else {
                            $("#total").val(0);
                        }
                        $(".payment-box").fadeIn();
                    }
                }
            });
        }

        $("#payment-form").validate({
            rules: {
                total: {
                    required: true,
                },
                payable: {
                    required: true,
                    payableGreaterThanZero: true,
                    payableValueLessThanTotal: true
                },
            },
            messages: {
                total: {
                    required: "Total is Required*",
                },
                payable: {
                    required: "Payable is Required*",
                },
            },
            submitHandler: function (form) {
                return true;
            }
        });

    </script>
@stop
