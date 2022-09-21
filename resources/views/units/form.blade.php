<form action="/units/store/{{@$unit->id}}" method="post" id="unit-form" name="unit-form">
    @csrf
    <div class="row">

        <div class="col-md-12 mb-3">
            <label for="name" class="form-label">
                <span class="required">Name</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{@$unit->name}}">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-primary"><i class="far fa-save mr-1"></i>Save</button>
        </div>

    </div>

</form>

<script>
    $(document).ready(function () {
        $("#unit-form").validate({
            rules: {
                name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is Required*",
                }
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });

</script>
