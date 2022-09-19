@extends('templates.index')

@section('page-title')
    POS
@stop

@section('title')
    POS
@stop

@section('page-actions')

@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="row productRow">
                @foreach(@$products as $key => $product)
                    <div class="col-2 p-0 p-1">
                        <button class="btn btn-block btn-success py-2 product-btn" data-product="{{$product}}">
                            <h6 class="m-0">{{$product->name}}</h6>
                            {{--                            <p class="m-0"><b>{{$product->sale_price}}</b></p>--}}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <select class="form-control select2 mb-2" name="customer">
                    <option value="">Select Customer</option>
                    @foreach(@$customers as $key => $customer)
                        <option value="{{@$customer->id}}">{{@$customer->name}}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-success table-hover align-middle posTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Unit</th>
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
                        <td colspan="2">Total Amount</td>
                        <td class="totalAmountTD font-weight-bold" colspan="4">0</td>
                    </tr>
                </tfoot>
            </table>
            <div class="bg-light text-right d-grid">
                <button class="btn btn-success checkoutBtn">Checkout</button>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        var productArray = [];
        var totalAmount = 0;
        var productCheck = true;
        $(".checkoutBtn").hide();

        $(".productRow").on('click', '.product-btn', function () {
            productCheck = true;
            $("#noProductRow").hide();
            var product = $(this).data('product');

            if ($("tr.tableRow").length + 1 <= 1) {
                var row = "";
                row += `<tr class="tableRow">`;
                row += `<td class="proId d-none">${product.id}</td>`;
                row += `<td class="proName">${product.name}</td>`;
                row += `<td class="">${product.unit ? product.unit : 'N/A'}</td>`;
                row += `<td class="proQty"><input type="number" onkeyup="quantityChange(this)" class="form-control form-control-sm" name="qty" placeholder="${product.unit}" id="quantity"></td>`;
                row += `<td class="proTotal"><input type="number" onkeyup="totalChange(this)" class="form-control form-control-sm" name="total" placeholder="total" id="total"></td>`;
                row += `<td class="proCancel"><button onclick="deleteProduct(this)" class="btn"><i class="fa fa-times"></i></button></td>`;
                row += `</tr>`;
                $("#productTableBody").append(row);
                checkTotal();
            } else {
                $("tr.tableRow").each(function () {
                    if ($(this).find("td.proName").text() == product.name) {
                        $(this).find("td.proQty").find("input[name='qty']").val(parseInt($(this).find("td.proQty").find("input[name='qty']").val()) + 1);
                        productCheck = false;
                    }
                });

                if (productCheck) {
                    var row = "";
                    row += `<tr class="tableRow">`;
                    row += `<td class="proId d-none">${product.id}</td>`;
                    row += `<td class="proName">${product.name}</td>`;
                    row += `<td class="">${product.unit ? product.unit : 'N/A'}</td>`;
                    row += `<td class="proQty"><input type="number" onkeyup="quantityChange(this)" class="form-control form-control-sm" name="qty" placeholder="${product.unit}" id="quantity"></td>`;
                    row += `<td class="proTotal"><input type="number" onkeyup="totalChange(this)" class="form-control form-control-sm" name="total" placeholder="total" id="total"></td>`;
                    row += `<td class="proCancel"><button  onclick="deleteProduct(this)" class="btn"><i class="fa fa-times"></i></button></td>`;
                    row += `</tr>`;
                    $("#productTableBody").append(row);
                    checkTotal();
                }
            }
        });

        function checkTotal()
        {
            if(totalAmount > 0) {
                $(".checkoutBtn").fadeIn();
            } else {
                $(".checkoutBtn").fadeOut();
            }
        }
        function quantityChange(ctl) {
        }

        function totalChange(cwt)
        {
            totals();
        }

        function totals(){
            totalAmount = 0;
            $("tr.tableRow").each(function (){
                let itemValue = $(this).find("td.proTotal").find("input[name='total']").val();
                if(parseInt(itemValue) > 0) {
                    totalAmount = totalAmount + parseInt(itemValue);
                }
            });
            $(".totalAmountTD").text(totalAmount);
            checkTotal();
        }

        function deleteProduct(ctl) {
            $(ctl).parents("tr").remove();
            totals();
            if($("tr.tableRow").length < 1) {
                $("#noProductRow").show();
            }
        }

        $("select[name='customer']").on('change', function () {
            if ($(this).val() == '') {
                $("#customer-error").show();
            } else {
                $("#customer-error").hide();
            }
        });

        $(".checkoutBtn").click(function () {
            // $(".dimmer").show();
            if ($("select[name='customer']").val() == '') {
                toast('Please Select Customer', 'error');
            } else {
                $("tr.tableRow").each(function () {
                    var obj = {};
                    obj['id'] = parseInt($(this).find("td.proId").text());
                    obj['name'] = $(this).find("td.proName").text();
                    obj['qty'] = parseInt($(this).find('td.proQty').find('input[name="qty"]').val());
                    obj['total'] = parseInt($(this).find('td.proTotal').find('input[name="total"]').val());
                    productArray.push(obj);
                });

                console.log(productArray);
                {{--$.ajax({--}}
                {{--    url: "{{url('/sale/')}}",--}}
                {{--    type: "POST",--}}
                {{--    data: {--}}
                {{--        'customer_id': $("select[name='customer']").val(),--}}
                {{--        'products': productArray,--}}
                {{--        'total': totalAmount,--}}
                {{--        'discount': discount,--}}
                {{--        'net_total': grandTotal--}}
                {{--    },--}}
                {{--    cache: false,--}}
                {{--    success: function (data) {--}}
                {{--        if (data.success == 1) {--}}
                {{--            $(".dimmer").hide();--}}
                {{--            window.location = `{{url('print-invoice')}}/${data.sale_id}`;--}}
                {{--            setTimeout(function () {--}}
                {{--                window.location.reload();--}}
                {{--            }, 4000);--}}
                {{--        } else {--}}
                {{--            alert("Internal Server Eror");--}}
                {{--        }--}}
                {{--    }--}}
                {{--});--}}
            }
        });

    </script>
@stop
