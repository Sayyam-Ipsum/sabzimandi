<form action="/products/store/{{@$product->id}}" method="post" id="product-form" name="product-form">
    @csrf
    <div class="row">

        <div class="col-md-12 mb-3">
            <label for="name" class="form-label">
                <span class="required">Name</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{@$product->name}}">
        </div>

        <div class="col-md-12 mb-3">
            <label for="unit" class="form-label">
                <span class="required">Unit</span>
            </label>
            <select class="form-control select2" name="unit" id="unit"             >
                <option value="">Select Role</option>
                    @foreach(@$units as $unit)
                    <option value="{{$unit->id}}" {{@$product->unit_id_fk == $unit->id ? 'selected' : ''}}>{{$unit->name}}</option>
                    @endforeach
            </select>
            <label class="error" id="unit-error" for="unit"></label>
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
                    required: "Please Select Unit*",
                },
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });

</script>
