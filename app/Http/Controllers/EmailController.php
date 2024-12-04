<?php

namespace App\Http\Controllers;

use App\Mail\optemail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function generateOTP() : int {

        $otp = rand(100000,999999);
        $user = auth()->user();
        return $otp;
    }


    public function sendEmail(){
       $otp =  $this->generateOTP();
        $toEmail = "sohail8338@gmail.com";
        $messag = "Welcome to Agreeement Syatems . Please find the Opt and don't tell to any unknow person 
                    Your One Time Password is : " . $otp;
        $subject = "Welcome to AMS";
        $result =  Mail::to($toEmail)->send(new optemail($messag,$subject));
        dd($result);
    }
}
