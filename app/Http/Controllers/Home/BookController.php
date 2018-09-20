<?php
namespace App\Http\Controllers\Home;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Product;
use App\Http\Models\PdtContent;
use App\Http\Models\PdtImages;
use App\Http\Models\CartItem;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    //书籍类别
    public function toCategory($value='')
    {
        $categorys = Category::whereNull('parent_id')->get();
        Log::info('进入书籍类别');
        return view('home.category')->with('categorys', $categorys);
    }

    //商品列表
    public function toProduct($category_id)
    {
        $products = Product::where('category_id',$category_id)->get();
        return view('home.product')->with('products',$products);
    }

    //商品详情
    public function toPdtContent(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        $pdt_content = PdtContent::where('product_id', $product_id)->first();
        $pdt_images = PdtImages::where('product_id', $product_id)->get();

        $count = 0;

        $member = $request->session()->get('member', '');
        if($member != '') {
            $cart_items = CartItem::where('member_id', $member->id)->get();

            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                    $count = $cart_item->count;
                    break;
                }
            }
        } else {
            $bk_cart = $request->cookie('bk_cart');
            $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());

            foreach ($bk_cart_arr as $value) {   // 一定要传引用
                $index = strpos($value, ':');
                if(substr($value, 0, $index) == $product_id) {
                    $count = (int) substr($value, $index+1);
                    break;
                }
            }
        }

        return view('home.pdt_content')->with('product', $product)
            ->with('pdt_content', $pdt_content)
            ->with('pdt_images', $pdt_images)
            ->with('count', $count);
    }

}
