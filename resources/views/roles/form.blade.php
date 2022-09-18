<form action="/roles/store/{{@$role->id}}" method="post" id="role-form" name="role-form">
    @csrf
    <div class="row">

        <div class="col-md-12 mb-3">
            <label for="name" class="form-label">
                <span class="required">Name</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="Sales Manager" name="name" value="{{@$role->name}}"
                   required>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-primary"><i class="far fa-save mr-1"></i>Save</button>
        </div>

    </div>

</form>

<script>
    $(document).ready(function () {
        $("#role-form").validate({
            rules: {
                name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is Required*",
                },
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });

</script>
