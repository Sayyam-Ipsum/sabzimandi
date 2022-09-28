<?php

use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use Illuminate\Support\Carbon;

function send_email($to, $subject, $data, $blade): bool
{
    $send = true;

    try {
        Mail::send(sprintf('mails.%s', $blade), $data, function ($message) use($to, $subject){
            $message->to($to)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS', 'sayyamse@gmail.com'), env('APP_NAME', 'Sabzimandi'));
        });
    } catch (\Exception $e){
        $send = false;
    }

    return $send;
}

function showDate(string $d): string
{
    return date('d-M-Y', strtotime($d));
}

function showDateTime(string $d): string
{
    return Carbon::parse($d)->format('d-M-Y g:i A');
}

function customerRoleId()
{
    return Role::where('name', 'customer')->whereNull('deleted_at')->pluck('id')->first();
}
