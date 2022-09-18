<form action="/products/store/{{@$product->id}}" method="post" id="product-form" name="product-form">
    @csrf
    <div class="row">

        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">
                <span class="required">Name</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{@$product->name}}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="unit" class="form-label">
                <span class="required">Unit</span>
            </label>
            <input type="text" class="form-control" id="unit" placeholder="Unit" name="unit" value="{{@$product->unit}}">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-primary"><i class="far fa-save mr-1"></i>Save</button>
        </div>

    </div>

</form>

<script>
    $(document).ready(function () {
        $("#product-form").validate({
            rules: {
                name: {
                    required: true,
                },
                unit: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is Required*",
                },
                unit: {
                    required: "Unit is Required*",
                },
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });

</script>
