<?php
namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Tool\Validate\ValidateCode;
use App\Tool\SMS\sendTemplateSMS;
use App\Http\Models\Result;
use App\Http\Models\TempPhone;
use App\Http\Controllers\Controller;


class ValidateController extends Controller
{
    //验证码
    public function create($value='')
    {
        $validateCode = new ValidateCode();
        return $validateCode->doimg();
    }

    //验证手机
    public function sendSms(Request $request){
        $m3_result = new Result;
        //获取手机号
        $phone = $request->input('phone', '');
        //验证手机号不为空
        if($phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号不能为空';
            return $m3_result->toJson();
        }
        //手机号格式是否正确
        if(strlen($phone) != 11 || $phone[0] != '1') {
            $m3_result->status = 2;
            $m3_result->message = '手机格式不正确';
            return $m3_result->toJson();
        }
        //短信发送
        $sendTemplateSMS = new SendTemplateSMS;
        $code = '';
        $charset = '1234567890';
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $m3_result = $sendTemplateSMS->sendTemplateSMS($phone, array($code, 2), 1);
        //发送成功就入库
        if($m3_result->status == 0) {
            $tempPhone = TempPhone::where('phone', $phone)->first();
            if($tempPhone == null) {
                $tempPhone = new TempPhone;
            }
            $tempPhone->phone = $phone;
            $tempPhone->code = $code;
            $tempPhone->deadline = date('Y-m-d H-i-s', time() + 60*60);
            $tempPhone->save();
        }
        return $m3_result->toJson();
    }
}
