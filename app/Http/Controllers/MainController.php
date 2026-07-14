<?php

namespace App\Http\Controllers;

use App\Model\HomeOfferSlider;
use App\Model\MapColorSize;
use App\Model\MstColor;
use App\Model\MstSize;
use App\Model\ProductFaq;
use App\Model\Shop;
use App\Model\Slider;
use App\Model\Subscriber;
use App\Model\TxnCategory;
use App\Model\TxnCondition;
use App\Model\TxnImage;
use App\Model\TxnProduct;
use App\Model\TxnReview;
use App\Model\TxnUser;
use App\Services\LogisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MainController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', true)->orderBy('sort_index')->get();
        $reviews = TxnReview::where('status', true)->with('product')->inRandomOrder()->take(10)->get();
        $homeOfferSliders = HomeOfferSlider::where('status', true)->orderBy('sort_index')->get();
        $categories = TxnCategory::select('name', 'slug_url', 'image_url')->where('status', true)->withCount('products')->orderBy('parent_id')->inRandomOrder()->get();
        // dd($categories);

        $products = DB::table('txn_products as p')
            ->selectRaw("
        p.id,
        MAX(p.title) as title,
        MAX(p.slug_url) as slug_url,
        MAX(map.stock) as stock,
        MAX(p.image_url) as image_url,
        MAX(w.user_id) as w_u_id,
        MAX(w.id) as w_id,
        MAX(w.product_id) as w_product_id,
        MAX(p.image_url1) as image_url1,
        MAX(p.review_status) as review_status,
        MAX(map.color_id) as c_id,
        MAX(map.size_id) as s_id,
        MAX(map.mrp) as mrp,
        MAX(map.starting_price) as starting_price,

        GROUP_CONCAT(DISTINCT c.color_code) as color_codes,
        FLOOR(AVG(txn_reviews.rating)) as rating,
        COUNT(txn_reviews.id) as total_rating
    ")
            ->leftJoin("txn_reviews", function ($join) {
                $join->on("txn_reviews.product_id", "=", "p.id")
                    ->where("txn_reviews.status", "=", true);
            })
            ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
            ->leftJoin("mst_colors as c", "c.id", "map.color_id")
            ->leftJoin("wishlists as w", "w.product_id", "p.id")
            ->where('p.status', true)
            ->groupBy('p.id')
            ->get();

        // $products = DB::table('txn_products as p')
        //     ->selectRaw("p.id,p.title,p.slug_url,map.stock, p.image_url,w.user_id as w_u_id, w.id as w_id, w.product_id as
        //     w_product_id, p.image_url1,
        //     p.review_status,map.color_id as c_id, map.size_id as s_id, map.mrp, map.starting_price,
        //     GROUP_CONCAT(DISTINCT(c.color_code)) as color_codes,
        //     FLOOR(AVG(txn_reviews.rating)) as
        //     rating , COUNT(txn_reviews.id) as total_rating")
        //     ->leftJoin("txn_reviews", "txn_reviews.product_id", "p.id")
        //     ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
        //     ->leftJoin("mst_colors as c", "c.id", "map.color_id")
        //     ->leftJoin("wishlists as w", "w.product_id", "p.id")
        //     ->where('p.status', true)
        //     ->groupBy('p.id')
        //     ->get();




        // Add Shop By Budget
        $shopByBudgets = \App\Model\ShopByBudget::where('is_active', true)->orderBy('sort_index', 'asc')->get();
        $shopByBudgetProducts = [];
        foreach($shopByBudgets as $budget) {
            $productIds = \App\Model\MapShopByBudgetProduct::where('shop_by_budget_id', $budget->id)->orderBy('sort_index')->pluck('product_id')->toArray();
            if(!empty($productIds)) {
                $budgetProds = collect($productIds)->map(function($pid) use ($products) {
                    return $products->firstWhere('id', $pid);
                })->filter()->all();
                
                if(!empty($budgetProds)) {
                    $shopByBudgetProducts[$budget->name] = [
                        'description' => $budget->description,
                        'products' => $budgetProds
                    ];
                }
            }
        }

        return view('frontend.newproduct.index', compact('sliders', 'reviews', 'homeOfferSliders', 'categories', 'shopByBudgetProducts'));
    }

    /* public function subscribers(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'EMAIL' => 'required|email|unique:subscribers,email',
            ],
            [
                'EMAIL.required' => 'Please Enter Email ID',
                'EMAIL.email' => 'Please Enter Proper Email',
                'EMAIL.unique' => 'You have Already been Subscribed with us !',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Error', $validator->errors()->first());
            return back()->withInput();
        }

        Subscriber::create([
            'email' => $request->EMAIL,
            'status' => true,
        ]);

        connectify('success', 'Subscribed', 'Thank you for Subscribing with us !');

        return back();
    } */

    public function getProduct($slug)
    {

        try {

            $product = TxnProduct::where('status', true)->where('slug_url', $slug)->with(['images', 'condition', 'sizes', 'unit', 'dim_unit', 'colors', 'colors.images', 'wishlist', 'category', 'warranty', 'reviews', 'brand', 'material', 'custom_fields'])->firstOrFail();
            // dd($product);

            $related_products = DB::table('txn_products as p')
                ->selectRaw("p.id as product_id , p.title,w.id as w_id, w.user_id as w_u_id, w.product_id as w_product_id,map.color_id as c_id, map.size_id as s_id,  c.id as cate_id , p.slug_url, p.image_url,map.mrp, map.stock, map.starting_price,GROUP_CONCAT(DISTINCT(co.color_code)) as color_codes, p.image_url1, p.status, p.review_status , FLOOR(AVG(r.rating)) as rating , COUNT(Distinct(r.comment)) as total_comment, c.name as category_name, c.slug_url as category_url")
                ->leftJoin("txn_reviews as r", function ($join) {
                    $join->on("r.product_id", "=", "p.id")
                        ->where("r.status", "=", true);
                })
                ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
                ->leftJoin("mst_colors as co", "co.id", "map.color_id")
                ->leftJoin("txn_categories as c", "c.id", "p.category_id")
                ->leftJoin("wishlists as w", "p.id", "w.product_id")
                ->where('p.status', true)
                ->where('p.id', '<>', $product->id)
                ->Where('c.id', $product->category_id)
                ->orderBy('p.id', 'DESC')
                ->groupBy("p.id")
                ->get();


            return view('frontend.newproduct.show', compact('product', 'related_products'));
        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Product Not Found !');

                return redirect('/');
            }

            return $ex->getMessage();

            connectify('error', 'Error', 'Whoops, Something Went Wrong from our End !');

            return redirect('/');
        }
    }

    public function getSizes(Request $request)
    {
        $resolved_color_id = $request->color_id;
        $resolved_size_id = $request->size_id;

        $results = MapColorSize::select('mrp', 'starting_price', 'color_id', 'size_id', 'stock')->where('product_id', $request->product_id);

        if ($request->source == 'size') {
            $results = $results->where('size_id', $request->size_id);
        }

        if ($request->source == 'color') {
            $results = $results->where('color_id', $request->color_id)->where('size_id', $request->size_id);
        }

        $results = $results->where('status', true)->orderBy('sort_index', 'asc')->get();

        if ($request->source == 'size') {
            $matchingResult = $results->firstWhere('color_id', $request->color_id);
            if ($matchingResult) {
                $resolved_color_id = $matchingResult->color_id;
                // Put the matching result at the beginning of the collection so JS picks it up as result.success[0]
                $results = $results->reject(function ($item) use ($resolved_color_id) {
                    return $item->color_id == $resolved_color_id;
                })->prepend($matchingResult);
            } else if ($results->isNotEmpty()) {
                $resolved_color_id = $results->first()->color_id;
            }
        }
        
        if ($request->source == 'color' && $results->isEmpty()) {
            $fallback = MapColorSize::select('mrp', 'starting_price', 'color_id', 'size_id', 'stock')->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('status', true)->orderBy('sort_index', 'asc')->first();
            if ($fallback) {
                $resolved_size_id = $fallback->size_id;
                $results = collect([$fallback]);
            }
        }

        $imageQuery = TxnImage::select('id', 'image_url')->where('product_id', $request->product_id)->where('color_id', $resolved_color_id);
        if ($resolved_size_id) {
            $imageQuery->where('size_id', $resolved_size_id);
        }
        $images = $imageQuery->orderBy('id', 'DESC')->get();
        
        if ($images->isEmpty()) {
            $images = TxnImage::select('id', 'image_url')->where('product_id', $request->product_id)->where('color_id', $resolved_color_id)->orderBy('id', 'DESC')->get();
        }

        $available_sizes = MapColorSize::select('size_id', 'product_id')->where('product_id', $request->product_id)->where('color_id', $resolved_color_id)->where('status', true)->with('size')->get();

        $available_colors = MapColorSize::select('color_id', 'product_id')->where('product_id', $request->product_id)->where('size_id', $resolved_size_id)->where('status', true)->with('color')->get();

        if ($results->isNotEmpty()) {
            return response()->json(['success' => $results, 'images' => $images, 'available_sizes' => $available_sizes, 'available_colors' => $available_colors, 'source' => $request->source]);
        }
        return response()->json(['error' => []]);
    }

    public function verifyPincode(Request $request, LogisticService $logistic)
    {
        // $res = $logistic->verify($request->pincode);
        // $res1 = json_decode($res, true);
        // if (isset($res1['status']) && $res1['status'] == 200) {
            session(['pincode' => $request->pincode]);
            return response()->json(['success' => 'Delivery Available at ' . $request->pincode, 'estimated_date' => '3-4 days']);
        // }
        // return response()->json(['error' => 'Delivery Not Available at ' . $request->pincode]);
    }

    public function search(Request $request)
    {
        $colors = MstColor::where('status', true)->get();
        $sizes = MstSize::where('status', true)->get();

        if ($request->filled('q')) {

            $products = DB::table('txn_products as p')
                ->selectRaw("p.id , p.title , p.slug_url,w.user_id as w_u_id, w.id as w_id, w.product_id as w_product_id,map.color_id as c_id, map.size_id as s_id , p.image_url, p.image_url1,p.review_status, FLOOR(AVG(r.rating)) as rating , map.mrp, map.starting_price, map.stock,
                GROUP_CONCAT(DISTINCT(c.color_code)) as color_codes, COUNT(Distinct(r.comment)) as total_comment, p.category_id")
                ->leftJoin("txn_reviews as r", function ($join) {
                    $join->on("r.product_id", "=", "p.id")
                        ->where("r.status", "=", true);
                })
                ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
                ->leftJoin("mst_colors as c", "c.id", "map.color_id")
                ->leftJoin("txn_keywords as k", "k.product_id", "p.id")
                ->leftJoin("wishlists as w", "p.id", "w.product_id")
                ->where('p.status', '=', true)
                ->where('k.keyword', 'like', '%' . $request->q . '%');
        } else {

            $products = DB::table('txn_products as p')
                ->selectRaw("p.id , p.title , p.slug_url,w.user_id as w_u_id,w.id as w_id, w.product_id as w_product_id,map.color_id as c_id, map.size_id as s_id , p.image_url,p.review_status, p.image_url1, FLOOR(AVG(r.rating)) as rating , map.mrp, map.starting_price, map.stock,
                GROUP_CONCAT(DISTINCT(c.color_code)) as color_codes, COUNT(Distinct(r.comment)) as total_comment, p.category_id")
                ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
                ->leftJoin("mst_colors as c", "c.id", "map.color_id")
                ->leftJoin("txn_reviews as r", function ($join) {
                    $join->on("r.product_id", "=", "p.id")
                        ->where("r.status", "=", true);
                })
                ->leftJoin("txn_keywords as k", "k.product_id", "p.id")
                ->leftJoin("wishlists as w", "p.id", "w.product_id")
                ->where('p.status', '=', true);
        }

        if ($request->filled('category') && gettype($request->category) == 'array') {
            $products = $products->whereIn('p.category_id', $request->category);
        }

        if ($request->filled('colors') && gettype($request->colors) == 'array') {
            $products = $products->whereIn('map.color_id', $request->colors);
        }

        if ($request->filled('sizes') && gettype($request->sizes) == 'array') {
            $products = $products->whereIn('map.size_id', $request->sizes);
        }

        if ($request->filled('amount')) {
            $replaced_amt = str_replace('₹', '', $request->amount);
            $explode_amt = explode('-', $replaced_amt);
            if (count($explode_amt) == 2) {
                $products = $products->whereBetween('map.mrp', [trim($explode_amt[0]), trim($explode_amt[1])]);
            } elseif (count($explode_amt) == 1) {
                $products = $products->where('map.mrp', '<=', trim($explode_amt[0]));
            }
        }

        if ($request->filled('brands') && gettype($request->brands) == 'array') {
            $products = $products->whereIn('p.brand_id', $request->brands);
        }

        if ($request->filled('conditions') && gettype($request->conditions) == 'array') {
            $products = $products->whereIn('p.condition_id', $request->conditions);
        }

        $products = $products->orderByRaw('CASE WHEN p.sort_index IS NULL THEN 1 ELSE 0 END')
            ->orderBy('p.sort_index', 'desc')
            ->orderBy('p.id', 'desc')
            ->groupBy("p.id")->paginate(50);

        $categories = TxnCategory::selectRaw("DISTINCT(name) as category_name, id")->where('status', true)->get();

        $prodLists = [];
        foreach ($products as $prod) {
            array_push($prodLists, $prod->id);
        }

        $brandIds = DB::table('txn_products')
            ->whereIn('id', $prodLists)
            ->where('status', true)
            ->whereNotNull('brand_id')
            ->pluck('brand_id')
            ->unique();
        $brands = \App\Model\TxnBrand::whereIn('id', $brandIds)->where('status', true)->get();

        $conditions = \App\Model\TxnCondition::where('status', true)->get();

        $max_price = DB::table('map_color_sizes as map')
            ->join('txn_products as p', 'p.id', '=', 'map.product_id')
            ->whereIn('p.id', $prodLists)
            ->where('p.status', true)
            ->max('map.mrp') ?? 50000;

        return view('frontend.product.cate-products', compact('products', 'categories', 'colors', 'sizes', 'brands', 'conditions', 'max_price'))->with('input', $request);
    }

    public function filter(Request $request)
    {
        $products = DB::table('txn_products as p')
            ->selectRaw("p.id , p.title , p.slug_url,w.user_id as w_u_id,w.id as w_id, w.product_id as w_product_id,map.color_id as c_id, map.size_id as s_id, p.image_url, p.image_url1,p.review_status, map.mrp, map.starting_price, map.stock,
                GROUP_CONCAT(DISTINCT(co.color_code)) as color_codes, p.category_id ,c.parent_id, FLOOR(AVG(r.rating)) as rating , COUNT(Distinct(r.comment)) as total_comment")
            ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
            ->leftJoin("mst_colors as co", "co.id", "map.color_id")
            ->leftJoin("txn_reviews as r", function ($join) {
                $join->on("r.product_id", "=", "p.id")
                    ->where("r.status", "=", true);
            })
            ->leftJoin("txn_categories as c", "p.category_id", "c.id")
            ->leftJoin("wishlists as w", "p.id", "w.product_id")
            ->leftJoin("txn_keywords as k", "k.product_id", "p.id")
            ->where('p.status', '=', true);

        if ($request->filled('q')) {
            $products = $products->where('k.keyword', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('brands') && gettype($request->brands) == 'array') {
            $products = $products->whereIn('p.brand_id', $request->brands);
        }

        if ($request->filled('conditions') && gettype($request->conditions) == 'array') {
            $products = $products->whereIn('p.condition_id', $request->conditions);
        }

        if ($request->filled('colors') && gettype($request->colors) == 'array') {
            $products = $products->whereIn('map.color_id', $request->colors);
        }

        if ($request->filled('sizes') && gettype($request->sizes) == 'array') {
            $products = $products->whereIn('map.size_id', $request->sizes);
        }

        if ($request->filled('amount')) {
            // Strip out any non-digits from the string to safely extract the min and max price
            preg_match_all('/\d+/', $request->amount, $matches);
            if (!empty($matches[0]) && count($matches[0]) >= 2) {
                $products = $products->whereBetween('map.mrp', [$matches[0][0], $matches[0][1]]);
            } elseif (!empty($matches[0]) && count($matches[0]) == 1) {
                $products = $products->where('map.mrp', '<=', $matches[0][0]);
            }
        }

        $products = $products->orderByRaw('CASE WHEN p.sort_index IS NULL THEN 1 ELSE 0 END')
            ->orderBy('p.sort_index', 'desc')
            ->orderBy('p.id', 'desc')
            ->groupBy("p.id")->paginate(20);

        $prodLists = [];

        foreach ($products as $prod) {
            array_push($prodLists, $prod->id);
        }

        $brandIds = DB::table('txn_products')
            ->whereIn('id', $prodLists)
            ->where('status', true)
            ->whereNotNull('brand_id')
            ->pluck('brand_id')
            ->unique();
        $brands = \App\Model\TxnBrand::whereIn('id', $brandIds)->where('status', true)->get();

        $conditions = \App\Model\TxnCondition::where('status', true)->get();

        $categories = \App\Model\TxnCategory::selectRaw("DISTINCT(name) as category_name, id")->where('status', true)->get();
        $colors = \App\Model\MstColor::where('status', true)->get();
        $sizes = \App\Model\MstSize::where('status', true)->get();

        $max_price = DB::table('map_color_sizes as map')
            ->join('txn_products as p', 'p.id', '=', 'map.product_id')
            ->whereIn('p.id', $prodLists)
            ->where('p.status', true)
            ->max('map.mrp') ?? 50000;

        return view('frontend.product.cate-products', compact('products', 'categories', 'colors', 'sizes', 'brands', 'conditions', 'max_price'))->with('input', $request);

        // return response()->json(['products' => $products], 200);
    }

    public function cateFilter(Request $request)
    {

        $category = TxnCategory::where('id', $request->category_id)->where('status', true)->firstOrFail();

        $categories = DB::select("select  id
            from    (select * from txn_categories
                     order by parent_id, id) txn_categories,
                    (select @pv := $category->id) initialisation
            where   find_in_set(parent_id, @pv) > 0
            and     @pv := concat(@pv, ',', id)");

        $cateLists = [];
        $cateLists[0] = $category->id;

        foreach ($categories as $cate) {
            array_push($cateLists, $cate->id);
        }

        $products = DB::table('txn_products as p')
            ->selectRaw("p.id , p.title , p.slug_url,w.user_id as w_u_id,w.id as w_id, w.product_id as w_product_id,map.color_id as c_id, map.size_id as s_id, p.image_url, p.image_url1,p.review_status, map.mrp, map.starting_price, map.stock,
                GROUP_CONCAT(DISTINCT(co.color_code)) as color_codes, p.category_id ,c.parent_id, FLOOR(AVG(r.rating)) as rating , COUNT(Distinct(r.comment)) as total_comment")
            ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
            ->leftJoin("mst_colors as co", "co.id", "map.color_id")
            ->leftJoin("txn_reviews as r", function ($join) {
                $join->on("r.product_id", "=", "p.id")
                    ->where("r.status", "=", true);
            })
            ->leftJoin("txn_categories as c", "p.category_id", "c.id")
            ->leftJoin("wishlists as w", "p.id", "w.product_id")
            ->leftJoin("txn_keywords as k", "k.product_id", "p.id")
            ->where('p.status', '=', true)
            ->whereIN('p.category_id', $cateLists);

        $brandIds = DB::table('txn_products')
            ->whereIn('category_id', $cateLists)
            ->where('status', true)
            ->whereNotNull('brand_id')
            ->pluck('brand_id')
            ->unique();
        $brands = \App\Model\TxnBrand::whereIn('id', $brandIds)->where('status', true)->get();

        $conditions = TxnCondition::where('status', true)->get();
        
        $colors = MstColor::where('status', true)->get();
        
        $sizes = MstSize::where('status', true)->get();

        if ($request->filled('brands') && gettype($request->brands) == 'array') {
            $products = $products->whereIn('p.brand_id', $request->brands);
        }

        if ($request->filled('conditions') && gettype($request->conditions) == 'array') {
            $products = $products->whereIn('p.condition_id', $request->conditions);
        }

        if ($request->filled('colors') && gettype($request->colors) == 'array') {
            $products = $products->whereIn('map.color_id', $request->colors);
        }

        if ($request->filled('sizes') && gettype($request->sizes) == 'array') {
            $products = $products->whereIn('map.size_id', $request->sizes);
        }

        if ($request->filled('amount')) {
            // Strip out any non-digits from the string to safely extract the min and max price
            preg_match_all('/\d+/', $request->amount, $matches);
            if (!empty($matches[0]) && count($matches[0]) >= 2) {
                $products = $products->whereBetween('map.mrp', [$matches[0][0], $matches[0][1]]);
            } elseif (!empty($matches[0]) && count($matches[0]) == 1) {
                $products = $products->where('map.mrp', '<=', $matches[0][0]);
            }
        }

        $max_price = DB::table('map_color_sizes as map')
            ->join('txn_products as p', 'p.id', '=', 'map.product_id')
            ->whereIn('p.category_id', $cateLists)
            ->where('p.status', true)
            ->max('map.mrp') ?? 50000;

        $products = $products->orderByRaw('CASE WHEN p.sort_index IS NULL THEN 1 ELSE 0 END')
            ->orderBy('p.sort_index', 'desc')
            ->orderBy('p.id', 'desc')
            ->groupBy("p.id")->paginate(20);

        return view('frontend.product.cate-products', compact('products', 'category', 'colors', 'sizes', 'brands', 'conditions', 'max_price'))->with('input', $request);

        // return response()->json(['products' => $products], 200);
    }

    public function getCategoryProducts(Request $request, $slug)
    {
        try {

            $colors = MstColor::where('status', true)->get();
            $sizes = MstSize::where('status', true)->get();
            $category = TxnCategory::where('slug_url', $slug)->where('status', true)->firstOrFail();

            $categories = DB::select("select DISTINCT(name) as category_name, id
            from    (select * from txn_categories
                     order by parent_id, id) txn_categories,
                    (select @pv := $category->id) initialisation
            where   find_in_set(parent_id, @pv) > 0
            and     @pv := concat(@pv, ',', id)");

            $cateLists = [];
            $cateLists[0] = $category->id;

            foreach ($categories as $cate) {
                array_push($cateLists, $cate->id);
            }
            // dd($categories);

            $products = DB::table('txn_products as p')
                ->selectRaw("p.id , p.title , p.slug_url,w.user_id as w_u_id,w.id as w_id, w.product_id as w_product_id,map.color_id as c_id, map.size_id as s_id, p.image_url, p.image_url1,p.review_status, map.mrp, map.starting_price, map.stock,
                GROUP_CONCAT(DISTINCT(co.color_code)) as color_codes, p.category_id ,c.parent_id, FLOOR(AVG(r.rating)) as rating , COUNT(Distinct(r.comment)) as total_comment")
                ->leftJoin("map_color_sizes as map", "map.product_id", "p.id")
                ->leftJoin("mst_colors as co", "co.id", "map.color_id")
                ->leftJoin("txn_reviews as r", function ($join) {
                    $join->on("r.product_id", "=", "p.id")
                        ->where("r.status", "=", true);
                })
                ->leftJoin("txn_categories as c", "p.category_id", "c.id")
                ->leftJoin("wishlists as w", "p.id", "w.product_id")
                ->where('p.status', true)
                ->whereIN('p.category_id', $cateLists);

            if ($request->filled('category') && gettype($request->category) == 'array') {
                $products = $products->whereIn('p.category_id', $request->category);
            }

            if ($request->filled('colors') && gettype($request->colors) == 'array') {
                $products = $products->whereIn('map.color_id', $request->colors);
            }

            if ($request->filled('sizes') && gettype($request->sizes) == 'array') {
                $products = $products->whereIn('map.size_id', $request->sizes);
            }

            if ($request->filled('amount')) {
                $replaced_amt = str_replace('₹', '', $request->amount);
                $explode_amt = explode('-', $replaced_amt);

                if (count($explode_amt) == 2) {
                    $products = $products->whereBetween('map.mrp', [trim($explode_amt[0]), trim($explode_amt[1])]);
                } elseif (count($explode_amt) == 1) {
                    $products = $products->where('map.mrp', '<=', trim($explode_amt[0]));
                }
            }

            $max_price = DB::table('map_color_sizes as map')
                ->join('txn_products as p', 'p.id', '=', 'map.product_id')
                ->whereIn('p.category_id', $cateLists)
                ->where('p.status', true)
                ->max('map.mrp') ?? 5000;

            $brandIds = DB::table('txn_products')
                ->whereIn('category_id', $cateLists)
                ->where('status', true)
                ->whereNotNull('brand_id')
                ->pluck('brand_id')
                ->unique();
            $brands = \App\Model\TxnBrand::whereIn('id', $brandIds)->where('status', true)->get();

            $conditions = \App\Model\TxnCondition::where('status', true)->get();

            $products = $products->orderByRaw('CASE WHEN p.sort_index IS NULL THEN 1 ELSE 0 END')
                ->orderBy('p.sort_index', 'desc')
                ->orderBy('p.id', 'desc')
                ->groupBy("p.id")->paginate(50);
            return view('frontend.product.cate-products', compact('products', 'category', 'categories', 'colors', 'sizes', 'max_price', 'brands', 'conditions'))->with('input', $request);
        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Category Not Found !');

                return redirect('/');
            }

            connectify('error', 'Error', 'Whoops, Something Went Wrong from our End  !');

            return redirect('/');
        }
    }

    public function askQuestion(Request $request, $id)
    {
        $request->validate(
            [
                'question' => 'required|string',
            ],
            [
                'question.required' => 'Please Enter your question',
            ]
        );

        try {
            $product = TxnProduct::where('id', $id)->firstOrFail();

            $qna = ProductFaq::create([
                'question' => $request->question,
                'product_id' => $product->id,
                'status' => false,
            ]);

            Mail::send(['html' => 'backend.mails.question'], ['qna' => $qna, 'product' => $product], function ($message) {
                $message->from('info@ranayas.com', 'Ranayas');
                $message->to('info@ranayas.com', 'Ranayas');
                $message->subject('Ranayas - Someone ask question');
            });

            return redirect(route('product', $product->slug_url))->with('messageSuccess1', 'Your question has been submitted successfully ! we\'ll answer your question soon !');
        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Category Not Found !');

                return back();
            }

            connectify('error', 'Error', 'Whoops, Something Went Wrong from our End !');

            return back();
        }
    }

    public function removePromocode(Request $request)
    {
        $request->session()->forget('promocode_new');
        $request->session()->forget('promocode');
        $cartTotal = \Cart::getTotal();
        $newTotal = $cartTotal;
        // if ($cartTotal < 1000) {
        //     $newTotal += 60; // adding shipping charge
        // }
        return response()->json(['success' => 'Coupon Removed !', 'status' => 200, 'new_total' => $newTotal], 200);
    }

    public function verifyPromocode(Request $request)
    {
        $promo = [];
        $coupon = null;
        $cartTotal = \Cart::getTotal();
        $discountAmount = 0;

        $inputCode = $request->filled('promocode') ? $request->promocode : ($request->filled('discountcode') ? $request->discountcode : null);

        if ($inputCode) {
            // First check the new Coupon table
            $coupon = \App\Model\Coupon::where('code', $inputCode)->where('status', true)->first();

            if ($coupon) {
                if ($coupon->min_amount > 0 && $cartTotal < $coupon->min_amount) {
                    return response()->json(['error' => 'Minimum order amount for this coupon is ₹' . $coupon->min_amount, 'status' => 200], 200);
                }
                session(['promocode_new' => $coupon]);

                if ($coupon->type == 'percentage') {
                    $discountAmount = round($cartTotal * ($coupon->value / 100), 2);
                } else {
                    $discountAmount = $coupon->value;
                }

                $newTotal = $cartTotal - $discountAmount;
                // if ($cartTotal < 1000) {
                //     $newTotal += 60; // adding shipping charge
                // }

                return response()->json(['success' => 'Coupon Applied Successfully !', 'status' => 200, 'discount_amount' => $discountAmount, 'new_total' => $newTotal], 200);
            }

            // Fallback to old elite users and shops logic
            if ($request->filled('promocode')) {
                $promo = TxnUser::select('promocode')->where('elite', true)->where('promocode', $request->promocode)->first();
            } elseif ($request->filled('discountcode')) {
                $promo = Shop::select('shop_code')->where('shop_code', strtolower($request->discountcode))->first();
            }
        }

        if (!empty($promo)) {
            session(['promocode' => $promo]);
            $discountAmount = round($cartTotal * 0.10, 2);
            $newTotal = $cartTotal - $discountAmount;
            // if ($cartTotal < 1000) {
            //     $newTotal += 60; // adding shipping charge
            // }
            return response()->json(['success' => 'Coupon Applied Successfully !', 'status' => 200, 'discount_amount' => $discountAmount, 'new_total' => $newTotal], 200);
        }

        return response()->json(['error' => 'Please Enter Valid Coupon', 'status' => 200], 200);
    }

    public function getSizePrice(Request $request)
    {
        try {

            $result = MapColorSize::select('mrp', 'starting_price')->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->where('status', true)->firstOrFail();

            return response()->json(['success' => $result]);
        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                return response()->json(['error' => 'Whoops something went wrong !']);
            }
            return response()->json(['error' => 'Whoops something went wrong from our end, try again later !']);
        }
    }

    public function testIndex()
    {
        return view('frontend.hearingtest.index');
    }
    public function testStart()
    {
        return view('frontend.hearingtest.start');
    }

    public function sendMail(Request $request)
    {
        $validated = $request->validate([
            'form_name' => 'required|string|max:50',
            'form_email' => 'required|email|max:100',
            'form_phone' => 'nullable|max:20',
            'form_subject' => 'nullable|string|max:100',
            'form_message' => 'required|max:1000',
            'website' => 'nullable',
        ]);

        if (!empty($request->website)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bot detected',
            ], 422);
        }



        $name = $request->form_name ?? '-';
        $email = $request->form_email ?? '-';
        $phone = $request->form_phone ?? '-';
        $subject = $request->form_subject ?? 'Ranayas Enquiry';
        $message = $request->form_message ?? '-';

        $html = view('frontend.email', compact(
            'name',
            'email',
            'phone',
            'subject',
            'message'
        ))->render();

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->Port = env('MAIL_PORT');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAutoTLS = true;
            $mail->SMTPDebug = 0;
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            // $mail->addAddress('info@mokshtubes.com');
            $mail->addAddress('siddiquimahfooz327@gmail.com');
            $mail->addBCC('supritdagade77@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = "You Received {$subject}";
            $mail->Body = $html;
            $mail->AltBody = strip_tags($html);
            $mail->send();

            return redirect()->route('index')
                ->with('status', 'success')
                ->with('msg', 'Your message has been sent successfully!');

        } catch (\Exception $e) {
            return redirect()->route('index')
                ->with('status', 'error')
                ->with('msg', 'Email sending failed.');
        }
    }

    public function showPolicy(Request $request)
    {
        $slug = $request->segment(1);
        $policy = \App\Model\Policy::where('slug', $slug)->firstOrFail();
        return view('frontend.policy.show', compact('policy'));
    }
}
