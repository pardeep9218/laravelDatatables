<?php

namespace App\Http\Controllers;

use App\size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin.size.index');
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
            'title' => 'required|unique:sizes|max:255',
        ]);
        $size = new Size();
        $size->title=$request->title;
        $size->save();

        return redirect()->back()->with('message', 'Size Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::find($id);
        return View('admin.size.index',compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $size=Size::find($id);
        if ($size) {
            $validatedData = $request->validate([
                'title' => 'required|unique:sizes,title,'.$id.'|max:255',
            ]);
            $size->title=$request->title;
            $size->update();
            return redirect()->route('size.index')->with('message', 'size Saved');
        }
        return redirect()->back()->withErrors('message', 'Somthing went wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy($size)
    {
        $data = Size::find($size)->delete();
        return response()->json($data);
    }

    public function sizeDatatable(Request $request)
    {

        $columns = array('id','title');
        
        $sizes = Size::query()->select('id', 'title');

        if(isset($request->search['value']))
        {
            $sizes->where('title', 'like', '%'.$request->search['value'].'%');
        }

        if(isset($request->order))
        {
            $sizes->orderBy($columns[$request->order['0']['column']], $request->order['0']['dir']);
        }
        else
        {
            $sizes->orderBy('id', 'DESC');
        }

        if($request->length != -1)
        {
            $sizes->take($request->length)->skip($request->start);
        }

        //dd($categories->toSql());

        $sizesdata=$sizes->get();

        $data=array();
        foreach($sizesdata as $size){


            $data1=array();
            $data1[0]=$size->id;
            $data1[1]=$size->title;
            $data1[2]='<a title="Edit" class="btn btn-primary" href="'.route('size.edit', ['id' => $size->id]).'"><i class="fa fa-pencil"></i></a>
            <a title="Delete" data-method="delete" class="btn btn-danger jquery-postback" href="'.route('size.destroy', $size->id).'"><i class="fa fa-trash"></i></a>';

            array_push($data,$data1);
        }

        $output = array(
             "draw"    => intval($request->draw),
             "recordsTotal"  =>  Size::all()->count(),
             "recordsFiltered" => $sizes->count(),
             "data"    => $data
        );
        return response()->json($output);
    }

    public function getSize()
    {
        $sizes=Size::orderBy('title', 'ASC')->get();
        return response()->json($sizes);
    }
}
