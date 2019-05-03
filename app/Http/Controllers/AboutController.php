<?php

namespace App\Http\Controllers;

use App\about;
use Illuminate\Http\Request;
use Image;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $about = About::latest()->first();
        return view('admin.about.index',compact('about'));
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
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
        ]);
        $base64_str = substr($request->featured_image, strpos($request->featured_image, ",")+1);

        $file = base64_decode($base64_str);
        $folderName = '/uploads/about/';
        $safeName = uniqid(rand()).'.'.'png';
        $destinationPath = public_path() . $folderName;
        file_put_contents(public_path().$folderName.$safeName, $file);

        $slug=$this->createSlug($request->title, 0);
        $about = new About();
        $about->title=$request->title;
        $about->description=$request->description;
        $about->image=$safeName;
        $about->slug=$slug;
        $about->save();

        return redirect()->back()->with('message', 'About page Saved');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\about  $about
     * @return \Illuminate\Http\Response
     */
    public function show(about $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\about  $about
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = About::find($id);
        return view('admin.about.index',compact('about'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\about  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $about=About::find($id);
        if ($about) {
            $rules=[
                'title' => 'required',
                'description' => 'required',
            ];
            if(empty($request->featured_image_old)){

                $rules['featured_image'] = 'required';
            }
            $validatedData = $request->validate($rules);

            if(empty($request->featured_image)){
                $safeName=$request->featured_image_old;
            }else{
                $base64_str = substr($request->featured_image, strpos($request->featured_image, ",")+1);
                $file = base64_decode($base64_str);
                $folderName = '/uploads/about/';
                $safeName = uniqid(rand()).'.'.'png';
                $destinationPath = public_path() . $folderName;
                file_put_contents(public_path().$folderName.$safeName, $file);
            }

            /*$img = Image::make(public_path('uploads/about/'.$safeName));
            // now you are able to resize the instance
            $img->resize(320, 240);
            // finally we save the image as a new file
            $img->save(public_path($safeName));*/
            /*$image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $directory = public_path('/image/user/');
            $imageUrl = $directory.$fileName;
            Image::make($image)->resize(200, 200)->save($imageUrl);*/

            $slug=$this->createSlug($request->title, $about->id);

            $about->title=$request->title;
            $about->description=$request->description;
            $about->image=$safeName;
            $about->slug=$slug;
            $about->update();

            return redirect()->back()->with('message', 'About page Saved');
        }
        return redirect()->back()->withErrors('message', 'Somthing went wrong');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\about  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(about $about)
    {
        //
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
        return About::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
