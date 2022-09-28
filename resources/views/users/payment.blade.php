<form action="/payment" method="post" id="payment-form" name="payment-form">
    @csrf
    <input type="hidden" name="payment_id" value="{{@$payment->id}}">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label for="total" class="form-label">
                <span class="required">Total Amount</span>
            </label>
            <input type="number" class="form-control" id="total" placeholder="Total Amount" name="total"
                   value="{{@$payment->remain == 0 ? @$payment->total : @$payment->remain}}"
                   required readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label for="payable" class="form-label">
                <span class="required">Payable</span>
            </label>
            <input type="number" class="form-control" id="payable" placeholder="Payable" name="payable" value="">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-primary" {{@$payment->total == 0 ? 'disabled' : ''}}><i class="far fa-save mr-1"></i>Save</button>
        </div>

    </div>

</form>

<script>
    $(document).ready(function () {
        $("#payment-form").validate({
            rules: {
                total: {
                    required: true,
                },
                payable: {
                    required: true,
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
    });

</script>
