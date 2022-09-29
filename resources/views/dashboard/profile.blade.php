@extends('templates.index')

@section('page-title')
    Profile
@stop

@section('title')
    profile
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form action="{{url('profile')}}" method="post" name="profile-form" id="profile-form">
                @csrf
                <input type="hidden" name="id" value="{{auth()->user()->id}}">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label class="form-label required" for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="John Doe"
                                   value="{{auth()->user()->name}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label class="form-label required" for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="example@gmail.com" value="{{auth()->user()->email}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                   placeholder="Example: 03053609490" value="{{auth()->user()->phone}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="address">Address</label>
                            <input type="address" class="form-control" name="address" id="address" placeholder="Address"
                                   value="{{auth()->user()->address}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="role">Role</label>
                            <input type="text" class="form-control" name="role" id="role"
                                   value="{{auth()->user()->role->name}}" disabled>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <button class="btn btn-success px-5" type="submit"><i class="fa fa-save mr-2"></i>Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">

        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#profile-form").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        // minlength: 12,
                        // maxlength: 12,
                        // phone: true
                    },
                },
                messages: {
                    name: {
                        required: "Name is Required*",
                    },
                    email: {
                        required: "Email is Required*",
                        email: "Please Enter Valid Email Address"
                    },
                    phone: {
                        // minlength: "Phone Number should be 12 digits min",
                        // maxlength: "Phone Number should be 12 digits max",
                        // phone: "Phone Number should be 11 digits",
                    },
                },
                submitHandler: function (form) {
                    return true;
                }
            });
        });
    </script>
@stop
