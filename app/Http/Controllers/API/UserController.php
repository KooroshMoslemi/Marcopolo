<?php

namespace App\Http\Controllers\API;

use App\Brand;
use App\Category;
use App\Product;
use App\Role;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //echo auth('api')->user();
        if(\Gate::allows('isAdmin') || \Gate::allows('isDeveloper')) {
            //return User::latest()->paginate(5);
            return DB::table('users')
                ->join('roles','roles.id','=','users.role_id')
                ->select('users.id' , 'roles.name as type' , 'users.name' , 'users.email' , 'users.created_at')
                ->where('is_active','=',1)
                ->latest('users.created_at')->paginate(5);
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
        //
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8'
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'role_id' => $request['type'],
            'password' => Hash::make($request['password'])
        ]);
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
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:8'
        ]);

        $request['role_id']= $request['type'];

        $user->update($request->all());
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
    }

    public function get_roles(){
        return Role::all();
    }

    public function deactivate($id){
        $this->authorize('isAdminORDeveloper');
        $user = User::findOrFail($id);
        $user->update(['is_active'=>'0']);
    }


    public function control_detail(){
    $res = array();

    $a = Tag::all();

    $b = Brand::all();

    $c = Category::all();

    array_push($res,$a , $b , $c);

    return $res;

    }

    public function add_tag(Request $request)
    {
        $tag = new Tag;

        $tag->name = $request->name;

        $tag->save();
    }

    public function add_brand(Request $request)
    {
        $brand = new Brand;

        $brand->name = $request->name;

        $brand->save();
    }

    public function add_category(Request $request)
    {
        $category = new Category;

        $category->name = $request->name;

        $category->save();
    }

    public function is_used(Request $request)
    {
        $mode = $request->get('mode');
        $id = $request->get('id');
        $product = null;
        if($mode == 'tag')
        {
            $product = DB::table('product_tag')->where('tag_id','=' , $id)->first();
        }
        elseif ($mode == 'brand')
        {
            $product = Product::where('brand_id', $id)->first();
        }
        elseif ($mode == 'category')
        {
            $product = Product::where('category_id', $id)->first();
        }

        if($product){return 1;}
        return 0;
    }

    public function del(Request $request){
        $id = $request->id;
        $mode = $request->mode;

        if($mode == 'tag')
        {
            Tag::destroy($id);
        }
        elseif ($mode == 'brand')
        {
            Brand::destroy($id);
        }
        elseif ($mode == 'category')
        {
            Category::destroy($id);
        }

    }


    public function edit_with_mode(Request $request){
        $id = $request->id;
        $name = $request->name;
        $mode = $request->mode;

        if($mode == 'tag')
        {
            $tag = Tag::find($id);

            $tag->name = $name;

            $tag->save();
        }
        elseif ($mode == 'brand')
        {
            $brand = Brand::find($id);

            $brand->name = $name;

            $brand->save();
        }
        elseif ($mode == 'category')
        {
            $category = Category::find($id);

            $category->name = $name;

            $category->save();
        }

    }



}
