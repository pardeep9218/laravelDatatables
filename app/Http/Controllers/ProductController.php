<?php

namespace App\Http\Controllers;

use App\product;
use App\category;
use App\color;
use App\size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::where('parent',0)->get();
        return View('admin.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*DB::enableQueryLog();*/

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'price' => 'required',
            'data' => 'required|array|min:1',
            'data.*' => 'required',
            'description' => 'required',
            'availability' => 'required',
            'featured_image' => 'required',
        ]);

        $base64_str = substr($request->featured_image, strpos($request->featured_image, ",")+1);

        $file = base64_decode($base64_str);
        $safeName = uniqid(rand()).'.'.'png';
        file_put_contents(public_path('uploads/products/').$safeName, $file);

        $base64_str = substr($request->large_image, strpos($request->large_image, ",")+1);

        $file = base64_decode($base64_str);
        file_put_contents(public_path('uploads/products/original/').$safeName, $file);

        $slug=$this->createSlug($request->title, 0);
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->strike_price = $request->strike_price;
        $product->snapdeal = $request->snapdeal;
        $product->flipkart = $request->flipkart;
        $product->amazon = $request->amazon;
        $product->description = $request->description;
        $product->availability = $request->availability;
        $product->featured_image = $safeName;
        $product->slug = $slug;

        $product->save();
        $product->categories()->sync($request->category);
        $colors=array();
        foreach($request->data as $key => $data){
            $color = new Color();
            $color->color=$data['color'];
            $imagesnew=array();
            $files = $request->file('data');

            foreach($files[$key] as $images){
                foreach($images as $image){
                    $imagename = time().uniqid(rand()).'.png';
                    Image::make($image)->resize(300, 300)->save(public_path('uploads/products/').$imagename);
                    Image::make($image)->save(public_path('uploads/products/original/').$imagename);
                    array_push($imagesnew,$imagename);
                }
            }
            $color->images=serialize($imagesnew);
            $sizes=implode(',',$data['size']);
            $color->sizes=$sizes;
            array_push($colors,$color);
        }

        $product->colors()->saveMany($colors);

/*
        $query = DB::getQueryLog();

        $query = end($query);

        dd($query);*/

        return redirect()->back()->with('message', 'Product Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories=Category::where('parent',0)->get();
        $sizes=Size::all();
        return view('admin.product.create',compact('product','categories','sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {/*DB::enableQueryLog();*/
        $product = Product::find($id);

        if($product){
            $rules=[
                'title' => 'required|max:255',
                'category' => 'required',
                'price' => 'required',
                'data' => 'required|array|min:1',
                'data.*' => 'required',
                'description' => 'required',
                'availability' => 'required',
            ];
            if(empty($request->featured_image_old)){
                $rules['featured_image']='required';
            }
            $validatedData = $request->validate($rules);

            if(empty($request->featured_image)){
                $safeName=$request->featured_image_old;
            }else{
                $base64_str = substr($request->featured_image, strpos($request->featured_image, ",")+1);
                $file = base64_decode($base64_str);
                $safeName = uniqid(rand()).'.'.'png';
                file_put_contents(public_path('uploads/products/').$safeName, $file);
                
                $base64_str = substr($request->large_image, strpos($request->large_image, ",")+1);
                $file = base64_decode($base64_str);
                file_put_contents(public_path('uploads/products/original/').$safeName, $file);
                if(!empty($request->featured_image_old)){
                    if(file_exists(public_path('uploads/products/').$request->featured_image_old)){
                        unlink(public_path('uploads/products/').$request->featured_image_old);
                    }
                    if(file_exists(public_path('uploads/products/original/').$request->featured_image_old)){
                        unlink(public_path('uploads/products/original/').$request->featured_image_old);
                    }
                }
            }


            $slug=$this->createSlug($request->title, $request->id);
            $product->title = $request->title;
            $product->price = $request->price;
            $product->strike_price = $request->strike_price;
            $product->snapdeal = $request->snapdeal;
            $product->flipkart = $request->flipkart;
            $product->amazon = $request->amazon;
            $product->description = $request->description;
            $product->availability = $request->availability;
            $product->featured_image = $safeName;
            $product->slug = $slug;
            $product->update();
            $product->categories()->sync($request->category);

            $colors=array();
            foreach($request->data as $key => $data){
                if(isset($data['oldid'])){
                    $color = Color::find($data['oldid']);
                    if($color){
                        $color->color=$data['color'];
                        $imagesnew=array();
                        $files = $request->file('data');
                        if(!empty($files)){
                            if(!empty($files[$key])){
                                foreach($files[$key] as $images){
                                    foreach($images as $image){
                                        $imagename = time().uniqid(rand()).'.png';
                                        Image::make($image)->resize(300, 300)->save(public_path('uploads/products/').$imagename);
                                        Image::make($image)->save(public_path('uploads/products/original/').$imagename);
                                        array_push($imagesnew,$imagename);
                                    }
                                }
                            }
                            
                        }
                        if(!empty($data['oldimages'])){
                            foreach($data['oldimages'] as $image){
                                array_push($imagesnew,$image);
                            }
                        }
                        $color->images=serialize($imagesnew);
                        $sizes=implode(',',$data['size']);
                        $color->sizes=$sizes;
                        $color->update();
                    }
                }else{
                    $color = new Color();
                    $color->color=$data['color'];
                    $imagesnew=array();
                    $files = $request->file('data');
                    if(!empty($files)){
                        if(!empty($files[$key])){
                            foreach($files[$key] as $images){
                                foreach($images as $image){
                                    $imagename = time().uniqid(rand()).'.png';
                                    Image::make($image)->resize(300, 300)->save(public_path('uploads/products/').$imagename);
                                    Image::make($image)->save(public_path('uploads/products/original/').$imagename);
                                    array_push($imagesnew,$imagename);
                                }
                            }
                        }
                    }
                    $color->images=serialize($imagesnew);
                    $sizes=implode(',',$data['size']);
                    $color->sizes=$sizes;
                    array_push($colors,$color);
                }

                
            }

            $product->colors()->saveMany($colors);/*
            $query = DB::getQueryLog();

        $query = end($query);

        dd($query);*/
            return redirect()->back()->with('message', 'Product Updated');
        }else{
            return redirect()->back()->withErrors('message', 'Somthing Went wrong');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }

     public function productsDatatable(Request $request)
    {

        $columns = array('id','title','title','title','title');
        
        $products = Product::query()->select('*');

        if(isset($request->search['value']))
        {
            $products->where('title', 'like', '%'.$request->search['value'].'%');
        }

        if(isset($request->order))
        {
            $products->orderBy($columns[$request->order['0']['column']], $request->order['0']['dir']);
        }
        else
        {
            $products->orderBy('id', 'DESC');
        }

        if($request->length != -1)
        {
            $products->take($request->length)->skip($request->start);
        }

        //dd($categories->toSql());

        $productsdata=$products->get();

        $data=array();
        foreach($productsdata as $product){
            $data1=array();
            $data1[0]=$product->id;
            $data1[1]="<img src='".asset('/uploads/products/'.$product->featured_image)."' width='100'>";
            $data1[2]=$product->title;
            $data1[3]=$product->price;
            $data1[4]='';
            foreach($product->colors as $color){
                $sizes=explode(',',$color['sizes']);
                $data1[4].="<div class='clearfix'>
                                <div class='small-color-box' style='background:".$color['color']."'></div>
                                ";
                                foreach($sizes as $size){

                                    $data1[4].="<div class='small-size-box'><span>".$size."</span></div>";
                                }
                $data1[4].="</div>";
            }
            $data1[5]='<a title="Edit" class="btn btn-primary" href="'.route('product.edit', ['id' => $product->id]).'"><i class="fa fa-pencil"></i></a>
            <a title="Delete" data-method="delete" class="btn btn-danger jquery-postback" href="'.route('product.destroy', $product->id).'"><i class="fa fa-trash"></i></a>';

            array_push($data,$data1);
        }

        $output = array(
             "draw"    => intval($request->draw),
             "recordsTotal"  =>  Product::all()->count(),
             "recordsFiltered" => $products->count(),
             "data"    => $data
        );
        return response()->json($output);
    }


    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Product::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
