@extends('templates.email')

@section('content')
<p>Hello {{ $user->name}},</p>
<p>We received a request to reset your Store Password</p>
<p>Click the link below to set a new password:</p>
<p><a href="{{ url('/reset/'.$token) }}">Reset Password</a></p>
<p>Team Sabzimandi</p>
<p>If you don’t want to reset your password, you can ignore this email. If you have any issues logging in with your new password, you can contact us 24/7 at support@digitalfarmermarket.com.</p>
@stop
