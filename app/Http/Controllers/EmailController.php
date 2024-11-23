<?php

namespace App\Http\Controllers;

use App\Mail\optemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function generateOTP() : int {

        $otp = rand(100000,999999);
        $user = auth()->user();
        dd($otp, $user);
        return 234;
    }


    public function sendEmail(){
        $this->generateOTP();
        $toEmail = "sohail8338@gmail.com";
        $messag = "Welcome to Agreeement Syatems . Please find the Opt and don't tell to any unknow person ";
        $subject = "Welcome to AMS";
        $result =  Mail::to($toEmail)->send(new optemail($messag,$subject));
        dd($result);
    }
}
