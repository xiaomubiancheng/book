<?php
namespace  App\Http\Models;

class Result{
    public $status;
    public $message;

    public function toJson(){
        return json_encode($this,JSON_UNESCAPED_UNICODE);   //对象转换成json字符串
    }
}