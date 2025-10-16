<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatGPTService;
use App\Models\Product;

class ChatAIController extends Controller
{
    protected $chatGPT;

    public function __construct(ChatGPTService $chatGPT)
    {
        $this->chatGPT = $chatGPT;
    }

    public function handle(Request $request)
    {
        $message = trim($request->input('message'));
        if (!$message) {
            return response()->json(['reply' => '📝 Vui lòng nhập nội dung trước khi gửi nha!']);
        }

        // 🔍 Nếu người dùng hỏi tìm sản phẩm
        if (preg_match('/(tìm|mua|xem|hiển thị|sản phẩm|iphone|macbook|airpod)/i', $message)) {
            $keywords = preg_replace('/(tìm|mua|xem|hiển thị|sản phẩm)/i', '', $message);
            $products = Product::where('name', 'like', "%$keywords%")
                ->orWhere('slug', 'like', "%$keywords%")
                ->take(6)
                ->get();

            if ($products->isEmpty()) {
                $aiReply = $this->chatGPT->ask($message);
                return response()->json(['reply' => $aiReply]);
            }

            // 🛒 Trả kết quả HTML
            $html = "<div class='grid grid-cols-1 sm:grid-cols-2 gap-3'>";
            foreach ($products as $p) {
                $price = number_format($p->price_sale ?: $p->price_root, 0, ',', '.');
                $image = asset('assets/images/product/' . $p->thumbnail);
                $url = route('site.product_detail', ['slug' => $p->slug]);

                $html .= "
                <div class='flex items-center bg-yellow-50 rounded-xl shadow-md p-3 hover:bg-yellow-100 transition'>
                    <img src='{$image}' class='w-20 h-20 rounded-lg object-cover'>
                    <div class='ml-3'>
                        <div class='font-semibold text-yellow-800'>{$p->name}</div>
                        <div class='text-orange-600 font-bold'>{$price}đ</div>
                        <a href='{$url}' class='text-sm text-blue-600 hover:underline'>Xem chi tiết</a>
                    </div>
                </div>";
            }
            $html .= "</div>";

            return response()->json(['reply' => $html]);
        }

        // 💬 Gọi ChatGPT khi không phải tìm sản phẩm
        $aiReply = $this->chatGPT->ask($message);
        return response()->json(['reply' => $aiReply]);
    }
}
