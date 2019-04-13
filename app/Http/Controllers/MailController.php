<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
//    public function mail(){
//
//        Mail::raw('这里填写邮件的内容',function ($message){
//            // 发件人（你自己的邮箱和名称）
//            $message->from('datsec@datsec.cn', '232323');
//            // 收件人的邮箱地址
//            $message->to('1224374496@qq.com');
//            // 邮件主题
//            $message->subject('测试');
//        });
//        dd(Mail::failures());
//
//
//    }
    public function mail()
    {
        //如果这里有多个账号
        //Mail::to(['45678@qq.com','123456@qq.com'...])->send(new SendMail());
        //可以添加抄送cc, 隐藏抄送bcc(也可以同时抄送，密送给多个邮箱，格式同to里面地址)
        //Mail::to(['address' => '789@qq.com'])->cc(['address' => '456@qq.com'])->bcc(['address' => '124@qq.com'])->send(new SendMail());
        //即使发送
//        Mail::to(['address' => 'xxxxx@qq.com'])->send(new SendMail());

        Mail::to(['address' => '1224374496@qq.com'])->send(new SendMail());
        var_dump(Mail::failures());
        return response()->json(['message' => 'success']);
    }

}
