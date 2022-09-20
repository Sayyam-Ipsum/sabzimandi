<?php

use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use Illuminate\Support\Carbon;

function send_email($to, $subject, $data, $blade){
    try {
        Mail::send(sprintf('mails.%s', $blade), $data, function ($message) use($to, $subject){
            $message->to($to)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS', 'sayyamse@gmail.com'), env('APP_NAME', 'Sabzimandi'));
        });
    }
    catch (\Exception $e){
        return false;
    }
    return true;
}

function showDate($d)
{
    return date('d-M-Y', strtotime($d));
}

function showDateTime($d)
{
    return Carbon::parse($d)->format('d-M-Y g:i A');
}

function customerRoleId()
{
    return Role::where('name', 'customer')->whereNull('deleted_at')->pluck('id')->first();
}
