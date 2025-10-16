<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderDetail;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (có tìm kiếm, lọc, wishlist, sắp xếp)
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('status', 1)
            ->with(['category', 'brand']);

        /**
         * 🔍 1. Tìm kiếm theo tên, slug, mô tả
         */
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('slug', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('detail', 'like', "%{$keyword}%");
            });
        }

        /**
         * 🏷️ 2. Lọc theo danh mục
         */
        if ($request->filled('category_slug')) {
            $category = Category::where('slug', $request->category_slug)
                ->where('status', 1)
                ->first();

            if ($category) {
                $relatedIds = $this->getListCategory($category->id);
                $query->whereIn('category_id', $relatedIds);
            }
        }

        /**
         * 🏢 3. Lọc theo thương hiệu
         */
        if ($request->filled('brand_slug')) {
            $brand = Brand::where('slug', $request->brand_slug)
                ->where('status', 1)
                ->first();

            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        /**
         * 💰 4. Lọc theo giá (tối đa & tối thiểu)
         */
        if ($request->filled('min_price') && is_numeric($request->min_price)) {
            $min = (int)$request->min_price;
            $query->where(function ($q) use ($min) {
                $q->where('price_sale', '>=', $min)
                  ->orWhere('price_root', '>=', $min);
            });
        }

        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $max = (int)$request->max_price;
            $query->where(function ($q) use ($max) {
                $q->where('price_sale', '<=', $max)
                  ->orWhere('price_root', '<=', $max);
            });
        }

        /**
         * ⚙️ 5. Sắp xếp sản phẩm
         */
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'bestseller':
                    $query->orderByDesc('sold');
                    break;

                case 'discount':
                    $query->whereNotNull('price_sale')
                          ->orderByDesc('price_root')
                          ->orderBy('price_sale');
                    break;

                case 'newest':
                    $query->orderByDesc('created_at');
                    break;

                case 'price_asc':
                    $query->orderByRaw('COALESCE(price_sale, price_root) ASC');
                    break;

                case 'price_desc':
                    $query->orderByRaw('COALESCE(price_sale, price_root) DESC');
                    break;

                case 'featured':
                default:
                    $query->orderByDesc('id');
                    break;
            }
        } else {
            // Mặc định: nổi bật (sản phẩm mới nhất)
            $query->orderByDesc('id');
        }

        /**
         * 🧾 6. Lấy danh sách sản phẩm
         */
        $product_list = $query->paginate(8)->appends($request->query());

        /**
         * ❤️ 7. Kiểm tra sản phẩm yêu thích
         */
        if (Auth::check()) {
            $likedProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
            $product_list->each(fn($p) => $p->is_liked = in_array($p->id, $likedProductIds));
        } else {
            $product_list->each(fn($p) => $p->is_liked = false);
        }

        /**
         * 🗂️ 8. Lấy danh mục & thương hiệu để hiển thị filter
         */
        $category_list = Category::where('status', 1)->orderBy('sort_order')->get();
        $brand_list = Brand::where('status', 1)->orderBy('sort_order')->get();

        return view('frontend.product', compact('product_list', 'category_list', 'brand_list'));
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function detail($slug)
    {
        $product_item = Product::with(['brand', 'category'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $product_item->is_liked = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->where('product_id', $product_item->id)->exists()
            : false;

        $relatedIds = $this->getListCategory($product_item->category_id);

        $product_list = Product::where('status', 1)
            ->where('id', '!=', $product_item->id)
            ->whereIn('category_id', $relatedIds)
            ->latest()
            ->limit(4)
            ->get();

        if (Auth::check()) {
            $likedIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
            $product_list->each(fn($p) => $p->is_liked = in_array($p->id, $likedIds));
        }

        return view('frontend.product-detail', compact('product_item', 'product_list'));
    }

    /**
     * Đệ quy danh mục con
     */
    private function getListCategory($category_id)
    {
        $ids = [$category_id];
        $children = Category::where('parent_id', $category_id)
            ->where('status', 1)
            ->pluck('id');

        foreach ($children as $childId) {
            $ids = array_merge($ids, $this->getListCategory($childId));
        }

        return $ids;
    }

    /**
     * Xử lý tìm kiếm (route /tim-kiem)
     */
    public function search(Request $request)
    {
        if (!$request->filled('q')) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm!');
        }
        return $this->index($request);
    }

    /**
     * 📝 Thêm đánh giá sản phẩm
     */
    public function addReview(Request $request, $productId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá sản phẩm!');
        }

        // ✅ Chỉ cho phép đánh giá khi đơn hàng đã giao (status = 3)
        $hasPurchased = OrderDetail::where('product_id', $productId)
            ->whereHas('order', fn($q) => $q->where('user_id', $user->id)->where('status', 3))
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', '❌ Bạn chỉ có thể đánh giá sản phẩm sau khi đã nhận hàng.');
        }

        // ⚠️ Kiểm tra đã đánh giá chưa
        $alreadyReviewed = ProductReview::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', '⚠️ Bạn đã đánh giá sản phẩm này rồi.');
        }

        // ✅ Validate
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // 📸 Lưu tối đa 3 ảnh
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach (array_slice($request->file('images'), 0, 3) as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/reviews'), $filename);
                $imageNames[] = $filename;
            }
        }

        // 💾 Tạo đánh giá
        ProductReview::create([
            'product_id' => $productId,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => json_encode($imageNames),
        ]);

        return back()->with('success', '🌟 Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
