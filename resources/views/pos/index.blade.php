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
                    <td class="totalAmountTD" colspan="4">0</td>
                </tr>
{{--                <tr>--}}
{{--                    <td colspan="2">Discount</td>--}}
{{--                    <td class="discountTD" colspan="3"><input type="text" class="discount-input" name="discount"--}}
{{--                                                              value=""></td>--}}
{{--                </tr>--}}
{{--                <tr class="table-active">--}}
{{--                    <td colspan="2">Grand Total</td>--}}
{{--                    <td class="grandTotalTD" colspan="3">0</td>--}}
{{--                </tr>--}}
                </tfoot>
            </table>
            <div id="customer-error">
                <p class="text-white bg-danger p-2 rounded"><i class="fa fa-exclamation me-1"></i> Please Select
                    Customer*</p>
            </div>
            <div class="bg-light text-right d-grid">
                <button class="btn btn-success checkoutBtn">Checkout</button>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        var productArray = [];
        var rows;
        var totalAmount = 0;
        var discount = 0;
        var grandTotal = 0;
        $(".discount-input").val(0);
        var productCheck = true;
        $(".checkoutBtn").hide();
        $("#customer-error").hide();

        $(".productRow").on('click', '.product-btn', function () {
            $(".checkoutBtn").fadeIn();
            productCheck = true;
            $("#noProductRow").hide();
            var product = $(this).data('product');

            if ($("tr.tableRow").length + 1 <= 1) {
                var row = "";
                row += `<tr class="tableRow">`;
                row += `<td class="proId d-none">${product.id}</td>`;
                row += `<td class="proName">${product.name}</td>`;
                row += `<td class="">${product.unit ? product.unit : 'N/A'}</td>`;
                row += `<td class="proQty"><input type="number" onkeyup="quantityChange(this)" class="form-control form-control-sm" name="qty" placeholder="${product.unit}" id="quantity" value="0"></td>`;
                row += `<td class="proTotal"><input type="number" onkeyup="totalChange(this)" class="form-control form-control-sm" name="total" placeholder="total" id="total"></td>`;
                row += `<td class="proCancel"><button onclick="deleteProduct(this)" class="btn"><i class="fa fa-times"></i></button></td>`;
                row += `</tr>`;
                $("#productTableBody").append(row);
                totals();
            } else {
                $("tr.tableRow").each(function () {
                    if ($(this).find("td.proName").text() == product.name) {
                        $(this).find("td.proQty").find("input[name='qty']").val(parseInt($(this).find("td.proQty").find("input[name='qty']").val()) + 1);
                        // $(this).find("td.proTotal").find("input[name='qty']").val( parseInt($(this).find("td.proPrice").text()) * parseInt($(this).find("td.proQty").find("input[name='qty']").val()));
                        productCheck = false;
                    }
                });

                if (productCheck) {
                    var row = "";
                    row += `<tr class="tableRow">`;
                    row += `<td class="proId d-none">${product.id}</td>`;
                    row += `<td class="proName">${product.name}</td>`;
                    row += `<td class="">${product.unit ? product.unit : 'N/A'}</td>`;
                    row += `<td class="proQty"><input type="number" onkeyup="quantityChange(this)" class="form-control form-control-sm" name="qty" placeholder="${product.unit}" id="quantity" value="0"></td>`;
                    row += `<td class="proTotal"><input type="number" onkeyup="totalChange(this)" class="form-control form-control-sm" name="total" placeholder="total" id="total"></td>`;
                    row += `<td class="proCancel"><button  onclick="deleteProduct(this)" class="btn"><i class="fa fa-times"></i></button></td>`;
                    row += `</tr>`;
                    $("#productTableBody").append(row);
                    totals();
                }

            }

        });

        function quantityChange(ctl) {
            // if($(ctl).parents("tr").children("td.proQty").children("input[name='qty']").val() <= 0){
            //     console.log(('Please Add Quantity'));
            //     $(ctl).parents("tr").children("td.proQty").children("input[name='qty']").val(0);
            // }
            //
            // $(ctl).parents("tr").children("td.proTotal").text(parseInt($(ctl).parents("tr").children("td.proPrice").text()) * parseInt($(ctl).parents("tr").children("td.proQty").children("input[name='qty']").val())) ;
            // totals();
        }

        // $(".discount-input").on('keyup', function (){
        //     if($(this).val() === ''){
        //         discount = 0;
        //         $(this).val(0);
        //     }
        //     discount = parseInt($(this).val());
        //     grandTotal = totalAmount - discount;
        //     $(".grandTotalTD").text(grandTotal);
        //
        // });
        //
        function totalChange(cwt)
        {
            totals();
        }

        function totals(){
            totalAmount = 0;

            $("tr.tableRow").each(function (){
                console.log('test');
                console.log(parseInt($(this).find("td.proTotal").find("input[name='qty']").val()));
                totalAmount = totalAmount + parseInt($(this).find("td.proTotal").find("input[name='qty']").val());
            });

            $(".totalAmountTD").text(totalAmount);

        }

        function deleteProduct(ctl) {
            $(ctl).parents("tr").remove();
            totals();
        }

        $("select[name='customer']").on('change', function () {
            if ($(this).val() == '') {
                $("#customer-error").show();
            } else {
                $("#customer-error").hide();
            }
        });

        $(".checkoutBtn").click(function () {
            $(".dimmer").show();
            if ($("select[name='customer']").val() == '') {
                $("#customer-error").show();
                $(".dimmer").hide();
            } else {
                $("tr.tableRow").each(function () {
                    var obj = {};
                    obj['id'] = parseInt($(this).find("td.proId").text());
                    obj['name'] = $(this).find("td.proName").text();
                    obj['price'] = parseInt($(this).find('td.proPrice').text());
                    obj['qty'] = parseInt($(this).find('td.proQty').find('input[name="qty"]').val());
                    obj['total'] = parseInt($(this).find('td.proTotal').text());
                    productArray.push(obj);
                });

                $.ajax({
                    url: "{{url('/sale/')}}",
                    type: "POST",
                    data: {
                        'customer_id': $("select[name='customer']").val(),
                        'products': productArray,
                        'total': totalAmount,
                        'discount': discount,
                        'net_total': grandTotal
                    },
                    cache: false,
                    success: function (data) {
                        if (data.success == 1) {
                            $(".dimmer").hide();
                            window.location = `{{url('print-invoice')}}/${data.sale_id}`;
                            setTimeout(function () {
                                window.location.reload();
                            }, 4000);
                        } else {
                            alert("Internal Server Eror");
                        }
                    }
                });
            }
        });

    </script>
@stop
