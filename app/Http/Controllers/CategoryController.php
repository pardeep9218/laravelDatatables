<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        /*$categories=Category::withTrashed()->get();

        foreach($categories as $cat){
            $cat->deleted_at = null;
            $cat->save();
        }*/

        /*$categories=Category::find(1);
        $categories->delete();*/


       /* $categories=Category::all();


        foreach($categories as $cat){
            $cat->delete();
        }*/
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('admin.category.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);


        if(empty($request->parent)){
            $request->parent=0;
        }
        
        $slug=$this->createSlug($request->name, 0);

        $category = new Category();
        $category->name=$request->name;
        $category->parent=$request->parent;
        $category->slug=$slug;
        $category->save();

        return redirect()->back()->with('message', 'Category Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {   $categories=Category::all();
        $category = Category::find($category);
        return view('admin.category.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category=Category::find($id);
        if ($category) {
            $validatedData = $request->validate([
                'name' => 'required|unique:categories,name,'.$id.'|max:255',
            ]);


            if(empty($request->parent)){
                $request->parent=0;
            }
            
            $slug=$this->createSlug($request->name, $category->id);

            $category->name=$request->name;
            $category->parent=$request->parent;
            $category->slug=$slug;
            $category->update();
            return redirect()->back()->with('message', 'Category Updated');
        }

        return redirect()->back()->withErrors('message', 'Somthing Went wrong');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {   
        $data = Category::find($category)->delete();
        /*if(!is_Null($data)){
            $childrens=$data->children()->get();
            $childrens->delete();
        }*/
        return response()->json($data);
    }

    public function categories()
    {
        //to get parent to child level heirarchy
           /* $categories=Category::where('parent',0)->with('grandchildren')->get()
            ->toArray();*/

        //to get parent to child level heirarchy
            /*$categories=Category::with('grandchildren')->get()
            ->toArray();*/

        //to get children of specific category
            /*foreach($categories as $category){
                $parent=$category->children()->get();

                if(!is_null($parent)){
                    print_r($parent);
                    
                }
            }*/

        /*$categories=Category::orderBy('name', 'asc')
        ->orderBy('parent', 'asc')->get();*/

        $categories=Category::where('parent',0)->with('children','children.grandchildren')->orderBy('name', 'asc')->get()
            ->toArray();
        return response()->json(['categories'=>$categories]);
    }

    public function categoriesDatatable(Request $request)
    {

        $columns = array('id','name', 'parent');
        
        $categories = Category::query()->select('id', 'name', 'parent');

        if(isset($request->search['value']))
        {
            $categories->where('name', 'like', '%'.$request->search['value'].'%');

            $parentCats=Category::query()->select('id')->where('name','like', '%'.$request->search['value'].'%')->get()->toArray();
            $findIn=array();
            foreach($parentCats as $parent){
                $findIn[]=$parent['id'];
            }

            if(!empty($findIn)){
                $categories->orWhereIn('parent',$findIn)->get();
            }
        }

        if(isset($request->order))
        {
            $categories->orderBy($columns[$request->order['0']['column']], $request->order['0']['dir']);
        }
        else
        {
            $categories->orderBy('id', 'DESC');
        }

        if($request->length != -1)
        {
            $categories->take($request->length)->skip($request->start);
        }

        //dd($categories->toSql());

        $catsdata=$categories->get();

        $data=array();
        foreach($catsdata as $cat){


            $data1=array();
            $data1[0]=$cat->id;
            $data1[1]=$cat->name;
                $data1[2]='';
            $parent=$cat->parent()->first();;

            if(!is_null($parent)){
                $data1[2]=$parent->name;
            }else{
                $data1[2]='';
            }
            $data1[3]='<a title="Edit" class="btn btn-primary" href="'.route('category.edit', ['id' => $cat->id]).'"><i class="fa fa-pencil"></i></a>
            <a title="Delete" data-method="delete" class="btn btn-danger jquery-postback" href="'.route('category.destroy', $cat->id).'"><i class="fa fa-trash"></i></a>';

            array_push($data,$data1);
        }

        $output = array(
             "draw"    => intval($request->draw),
             "recordsTotal"  =>  Category::all()->count(),
             "recordsFiltered" => $categories->count(),
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
        return Category::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
