<?php
namespace App\Tool\SMS;

use App\Http\Models\Result;

class SendTemplateSMS
{
    //主帐号
    private $accountSid='8aaf070863f8fb04016406bd70550da6';
    //主帐号Token
    private $accountToken='3c57d2a2ac514433a12194fe84997ca4';
    //应用Id
    private $appId='8aaf070863f8fb04016406bd70b30dad';
    //请求地址，格式如下，不需要写https://
    private $serverIP='sandboxapp.cloopen.com';
    //请求端口
    private $serverPort='8883';
    //REST版本号
    private $softVersion='2013-12-26';

    /**
     * 发送模板短信
     * @param to 手机号码集合,用英文逗号分开
     * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
     * @param $tempId 模板Id
     */
    public function sendTemplateSMS($to,$datas,$tempId)
    {
        $m3_result = new Result;

        // 初始化REST SDK
        $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
        $rest->setAccount($this->accountSid,$this->accountToken);
        $rest->setAppId($this->appId);

        // 发送模板短信
        //  echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            $m3_result->status = 3;
            $m3_result->message = 'result error!';
        }
        if($result->statusCode != 0) {
            $m3_result->status = $result->statusCode;
            $m3_result->message = $result->statusMsg;
        }else{
            $m3_result->status = 0;
            $m3_result->message = '发送成功';
        }

        return $m3_result;
    }
}

//sendTemplateSMS("18576437523", array(1234, 5), 1);