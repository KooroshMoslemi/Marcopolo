<?php

namespace App\Http\Controllers;

use App\Category;
use App\Media;
use App\Product;
use App\Tag;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check() && \Gate::allows('isAdminORDeveloperORSalesPerson')) {
            return self::getMarcopoloTable()->orderBy('ProductId', 'desc')->paginate(10);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'general_name' => 'required|string',
            'model_name' => 'required|string',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'description' => 'required|string',
            'overview' => 'required|string',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        if(Auth::check() && \Gate::allows('isAdminORDeveloperORSalesPerson')) {

            try {

            $product_id = DB::table('products')->insertGetId(['general_name'=>$request['general_name'],
                'model_name'=>$request['model_name'] , 'price'=>$request['price'] , 'description' => $request['description'],
                'overview'=>$request['overview'] , 'category_id'=>$request['category_id'] , 'brand_id'=>$request['brand_id']]);

            $selectedCoverImage = $request['selectedCoverImage'];
            $selectedGalleryImage = $request['selectedGalleryImage'];
            $selected_tags = $request['selected_tags'];



            foreach ( $selected_tags as $tag)
            {
                DB::table('product_tag')->insert(
                    ['product_id' => $product_id, 'tag_id' => $tag['id']]);
            }

            DB::table('media_product')->insert(
                ['product_id' => $product_id, 'media_id' => $selectedCoverImage['id']
                    ,'is_secondary'=>false]);

            foreach ($selectedGalleryImage as $image)
            {
                DB::table('media_product')->insert(
                    ['product_id' => $product_id, 'media_id' => $image['id']
                        ,'is_secondary'=>true]);
            }

            return 1;

            } catch (Exception $e) {
                return 0;
            }


        }
        else{
            return 0;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'general_name' => 'required|string',
            'model_name' => 'required|string',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'description' => 'required|string',
            'overview' => 'required|string',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        if(Auth::check() && \Gate::allows('isAdminORDeveloperORSalesPerson')) {

            try {
                $product_id = $id;
                Product::where('id', $product_id)
                    ->update(['general_name'=>$request['general_name'],
                    'model_name'=>$request['model_name'] , 'price'=>$request['price'] , 'description' => $request['description'],
                    'overview'=>$request['overview'] , 'category_id'=>$request['category_id'] , 'brand_id'=>$request['brand_id']]);

                $selectedCoverImage = $request['selectedCoverImage'];
                $selectedGalleryImage = $request['selectedGalleryImage'];
                $selected_tags = $request['selected_tags'];

                DB::table('product_tag')->where('product_id', '=', $product_id)->delete();
                DB::table('media_product')->where('product_id', '=', $product_id)->delete();


                foreach ( $selected_tags as $tag)
                {
                    DB::table('product_tag')->insert(
                        ['product_id' => $product_id, 'tag_id' => $tag['id']]);
                }

                DB::table('media_product')->insert(
                    ['product_id' => $product_id, 'media_id' => $selectedCoverImage['id']
                        ,'is_secondary'=>false]);

                foreach ($selectedGalleryImage as $image)
                {
                    DB::table('media_product')->insert(
                        ['product_id' => $product_id, 'media_id' => $image['id']
                            ,'is_secondary'=>true]);
                }

                return 1;

            } catch (Exception $e) {
                return 0;
            }


        }
        else{
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(Auth::check() && \Gate::allows('isAdminORDeveloperORSalesPerson')) {
            $product = Product::findOrFail($id);
            $product->update(['is_active' => '0']);
            return 1;
        }
    }

    public function welcome(){
        $categories = Category::all();
        return view('welcome',compact('categories'));
    }

    public function new(){
        $query = DB::table('media_product')
            ->join('media','media.id','=','media_product.media_id')
            ->join('products','products.id','=','media_product.product_id')
            ->select('products.id','general_name','file','is_secondary')->where('is_secondary','=',0)->where('is_active','=',1);;

        ////////////////
        $products = Product::whereHas('tags', function($q)
        {
            $q->whereName('New');
        })->where('is_active','=',1)->orderBy('id', 'desc')->take(8)->get();

        $Ids = array();
        foreach ($products as $product)
        {
            array_push($Ids,$product->id);
        }
        ///////////////
        $query->whereIn('products.id',$Ids);

        return $query->get();

    }

    public function off() {
        $query = DB::table('media_product')
            ->join('media','media.id','=','media_product.media_id')
            ->join('products','products.id','=','media_product.product_id')
            ->select('products.id','general_name','file','is_secondary')->where('is_secondary','=',0)->where('is_active','=',1);;

        ////////////////
        $products = Product::whereHas('tags', function($q)
        {
            $q->whereName('OFF');
        })->where('is_active','=',1)->orderBy('id', 'desc')->take(8)->get();

        $Ids = array();
        foreach ($products as $product)
        {
            array_push($Ids,$product->id);
        }
        ///////////////
        $query->whereIn('products.id',$Ids);

        return $query->get();

    }

    public function product_detail($id)
    {
        $query = DB::table('products')
            ->join('brands','brands.id','=','products.brand_id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.id','general_name as GeneralName','model_name as ModelName','price as Price','description as Description'
                ,'overview as Overview','categories.name as CategoryName','brands.name as BrandName')
            ->where('products.id','=',$id)->where('is_active','=',1);;

        return $query->get();
    }

    public function product_detail_media($id)
    {
        $query = DB::table('media_product')
            ->join('media','media.id','=','media_product.media_id')
            ->join('products','products.id','=','media_product.product_id')
            ->select('media.id','file','is_secondary')
            ->where('products.id','=',$id)
            ->orderBy('is_secondary','asc')->where('is_active','=',1);;
        return $query->get();
    }

    public function product_detail_with_main_photo($id)
    {
        $query = DB::table('media_product')
            ->join('media','media.id','=','media_product.media_id')
            ->join('products','products.id','=','media_product.product_id')
            ->join('brands','brands.id','=','products.brand_id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.id','general_name as GeneralName','model_name as ModelName','price as Price','description as Description'
                ,'overview as Overview','categories.name as CategoryName','brands.name as BrandName','file','is_secondary')
            ->where('products.id','=',$id)
            ->where('is_secondary','=',0)->where('is_active','=',1);;
        return $query->get();
    }

    public function showDetail($id){
        $categories = Category::all();
        return view('product_detail', compact('categories', 'id'));
    }

//    public function showDetail2(){
//
//        $id = \Request::get('pid');
//
//        $categories = Category::all();
//        return view('product_detail', compact('categories', 'id'));
//
//    }

    public function showOrders()
    {
        $categories = Category::all();
        return view('order',compact('categories'));
    }

    public function pay(Request $request)
    {
        if(Auth::check()) {
            $totalPrice = $request->totalPrice;
            $option = $request->option;
            $user_id = Auth::user()->id;

            $payment_id = DB::table('payments')->insertGetId(
                ['total_price' => $totalPrice, 'option' => $option , 'user_id' => $user_id]);

            $orders = $request->orders;
            foreach ($orders as $order)
            {
                $productId =  json_decode(json_encode($order))->Id;
                $quantity =  json_decode(json_encode($order))->Quantity;
                DB::table('payment_product')->insert(
                    ['payment_id' => $payment_id, 'product_id' => $productId ,
                        'quantity' => $quantity]);
            }
            return $payment_id;
        }
        return 'fail';
    }

    public function category_page_content_detail(Request $request)
    {
        $search = $request->get('q');
        $minPrice = $request->get('minP');
        $maxPrice = $request->get('maxP');
        $omitedBrands = $request->get('omit');
        $query = self::getMarcopoloTable();

        $query->where(function($q) use($search) {
            $q->where('general_name','like','%'.$search.'%')
                ->orWhere('categories.name','like','%'.$search.'%')
                ->orWhere('brands.name','like','%'.$search.'%')
                ->orWhere('model_name','like','%'.$search.'%');
        });

        if($minPrice != '' && $maxPrice != '')
        {
            $query->WhereBetween('price',[$minPrice,$maxPrice]);
        }

        if($omitedBrands != '')
        {
            $query->whereNotIn('brands.id',$omitedBrands);
        }


        return $query->paginate(8);
    }

    public function category(){
        $categories = Category::all();
        return view('category',compact('categories'));
    }

    public function category_page_search_sidebar_detail(Request $request)
    {
        $search = $request->get('q');
        $minPrice = $request->get('minP');
        $maxPrice = $request->get('maxP');
        $omitedBrands = $request->get('omit');

        //*******************************

        $sub = self::getMarcopoloTable();

        $sub->where(function($q) use($search) {
            $q->where('general_name','like','%'.$search.'%')
                ->orWhere('categories.name','like','%'.$search.'%')
                ->orWhere('brands.name','like','%'.$search.'%')
                ->orWhere('model_name','like','%'.$search.'%');
        });

        if($minPrice != '' && $maxPrice != '')
        {
            $sub->WhereBetween('price',[$minPrice,$maxPrice]);
        }

        if($omitedBrands != '')
        {
            $sub->whereNotIn('brands.id',$omitedBrands);
        }

        //*******************************

        $sub2 = self::getMarcopoloTable();

        $sub2->where(function($q) use($search) {
            $q->where('general_name','like','%'.$search.'%')
                ->orWhere('categories.name','like','%'.$search.'%')
                ->orWhere('brands.name','like','%'.$search.'%')
                ->orWhere('model_name','like','%'.$search.'%');
        });

        if($minPrice != '' && $maxPrice != '')
        {
            $sub2->WhereBetween('price',[$minPrice,$maxPrice]);
        }

//        if($omitedBrands != '')
//        {
//            $sub2->whereNotIn('brands.id',$omitedBrands);
//        }

        //*******************************

        $a = array();

        $d = $sub->select(DB::raw('max(Price)'))->get();
        $e = $sub->select(DB::raw('min(Price)'))->get();

        $b = json_decode($sub->select(DB::raw(' categories.id as CategoryId , categories.name as CategoryName , count(categories.Id) as countCategory'))
            ->groupBy('categories.id','categories.name')
            ->get());

        $c = json_decode($sub2->select(DB::raw('brands.id as BrandId , brands.name as BrandName , count(brands.Id) as countBrand'))
            ->groupBy('brands.id','brands.name')
            ->get());

        array_push($a,$b,$c,$d,$e);

        return $a;
    }

    public function randomProducts(Request $request){
        $limit = $request->get('lim');

        $table = self::getMarcopoloTable();

        $table->orderByRaw('RAND()')->take($limit);

        return $table->get();
    }

    public function popularProducts()
    {
        $sub =  DB::table('media_product')
            ->join('media','media.id','=','media_product.media_id')
            ->join('products','products.id','=','media_product.product_id')
            ->join('payment_product','payment_product.product_id','=','products.id')
            ->select('products.id as ProductId','general_name as GeneralName','quantity','file')->where('is_active','=',1);;

        $sub->select(DB::raw(' products.id as ProductId , general_name as GeneralName ,file , sum(quantity) as QuantitySum'))
            ->groupBy('products.id','general_name' , 'file')
            ->orderByDesc('QuantitySum')
            ->take(3);

        return $sub->get();

    }

    public function pre_product_edit_details($id){
        $a = array();
        $b = DB::table('products')
            ->join('brands','brands.id','=','products.brand_id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.id as ProductId','brands.id as BrandId','categories.id as CategoryId','general_name as GeneralName','model_name as ModelName','price as Price','description as Description'
                ,'overview as Overview','categories.name as CategoryName','brands.name as BrandName')
            ->where('products.id','=',$id)
            ->where('is_active','=',1)
            ->get();

        $c =  DB::table('media_product')
            ->select('media_id as id','is_secondary')
            ->where('product_id','=',$id)->get();

        $d =  DB::table('product_tag')
            ->join('tags','tags.id','=','product_tag.tag_id')
            ->select('tag_id as id' , 'tags.name as name')
            ->where('product_id','=',$id)->get();


        array_push($a,$b,$c,$d);
        return $a;
    }

    public function getMarcopoloTable(){
        return DB::table('media_product')
            ->join('media','media.id','=','media_product.media_id')
            ->join('products','products.id','=','media_product.product_id')
            ->join('brands','brands.id','=','products.brand_id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.id as ProductId','brands.id as BrandId','categories.id as CategoryId','general_name as GeneralName','model_name as ModelName','price as Price','description as Description'
                ,'overview as Overview','categories.name as CategoryName','brands.name as BrandName','file','is_secondary')
            ->where('is_secondary','=',0)
            ->where('is_active','=',1);
    }
}
