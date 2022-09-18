@extends('templates.email')
@section('content')

    <p>Welcome {{ $user->name}},</p>
    <p>Now you are part of Sabzimandi.</p>
    <p>You can set new password from given below link:</p>

    <p>If you have any issues logging in with your new password, you can contact us 24/7 at <a href="mailto:support@ipsumlive.com" >support@ipsumlive.com</a></p>

    <p>Team Ipsum.Live</p>
@stop
