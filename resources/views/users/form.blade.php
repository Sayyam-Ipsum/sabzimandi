<form action="/users/store/{{@$user->id}}" method="post" id="user-form" name="user-form">
    @csrf
    <div class="row">

        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">
                <span class="required">Name</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="John Doe" name="name" value="{{@$user->name}}"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">
                <span class="required">Email</span>
            </label>
            <input type="email" class="form-control" id="email" placeholder="example@gmail.com" name="email" value="{{@$user->email}}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">
                <span>Phone<small>(Optional)</small></span>
            </label>
            <input type="phone" class="form-control" id="phone" placeholder="Example: 03053609490" name="phone" value="{{@$user->phone}}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="role_id" class="form-label">
                <span class="required">Role</span>
            </label>
            <select class="form-control select2" name="role_id" id="role_id"             >
                <option value="">Select Role</option>
                @if(@$customer == 1)
                    @foreach(@$roles as $role)
                        @if($role->id == (int) customerRoleId())
                            <option value="{{$role->id}}" selected>
                                {{$role->name}}
                            </option>
                        @endif

                    @endforeach
                @else
                    @foreach(@$roles as $role)
                        @if($role->id != (int) customerRoleId())
                            <option value="{{$role->id}}" {{@$user->role->id == $role->id ? 'selected' : ''}}>
                                {{$role->name}}
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
            <label class="error" id="role_id-error" for="role_id"></label>
        </div>

        <div class="col-md-12 mb-3">
            <label for="address" class="form-label">
                <span>Address<small>(Optional)</small></span>
            </label>
            <input type="address" class="form-control" id="address" placeholder="sadiqabad" name="address" value="{{@$user->address}}">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-primary"><i class="far fa-save mr-1"></i>Save</button>
        </div>

    </div>

</form>

<script>
    $(document).ready(function () {
        $("#user-form").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                role_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is Required*",
                },
                email: {
                    required: "Email is Required*",
                    email: 'Please enter valid email address',
                },
                role_id: {
                    required: "Please select Role*",
                },
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });

</script>
