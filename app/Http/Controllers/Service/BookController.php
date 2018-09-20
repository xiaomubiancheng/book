<?php
namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Result;

class BookController extends Controller
{
    public function getCategoryByParentId($parent_id)
    {
        $categorys = Category::where('parent_id', $parent_id)->get();

        $m3_result = new Result;
        $m3_result->status = 0;
        $m3_result->message = '返回成功';
        $m3_result->categorys = $categorys;

        return $m3_result->toJson();
    }
}
