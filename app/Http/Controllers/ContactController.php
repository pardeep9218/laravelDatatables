<?php

namespace App\Http\Controllers;

use App\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return View('admin.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return View('admin.contact.index');
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
            'title' => 'required|max:255',
            'email' => 'required|max:255|email',
            'contact' => 'required|numeric',
            'address' => 'required',
            'location' => 'required',
            "timings"    => "required|array",
            "timings.*"  => "required",
        ]);

        $contact = new Contact();
        $contact->title=$request->title;
        $contact->email=$request->email;
        $contact->contact=$request->contact;
        $contact->address=$request->address;
        $contact->location=$request->location;
        $contact->timings=serialize($request->timings);
        $contact->save();
        return redirect()->back()->with('message', 'Contact Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        $contact->timings=unserialize($contact->timings);
        return view('admin.contact.index',compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact=Contact::find($id);
        if ($contact) {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'email' => 'required|max:255|email',
                'contact' => 'required|numeric',
                'address' => 'required',
                'location' => 'required',
                "timings"    => "required|array",
                "timings.*"  => "required",
            ]);

            $contact->title=$request->title;
            $contact->email=$request->email;
            $contact->contact=$request->contact;
            $contact->address=$request->address;
            $contact->location=$request->location;
            $contact->timings=serialize($request->timings);
            $contact->update();
            return redirect()->back()->with('message', 'Contact Updated');
        }
        return redirect()->back()->withErrors('message', 'Somthing Went wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact)
    {
        $data = Contact::find($contact)->delete();
        return response()->json($data);
    }

    public function ContactDatatable(Request $request)
    {

        $columns = array('id','title', 'address', 'location', 'email');
        
        $contacts = Contact::query()->select('id', 'title', 'address','location','email');

        if(isset($request->search['value']))
        {
            $contacts->where('id', 'like', '%'.$request->search['value'].'%');
            $contacts->orWhere('title', 'like', '%'.$request->search['value'].'%');
            $contacts->orWhere('address', 'like', '%'.$request->search['value'].'%');
            $contacts->orWhere('location', 'like', '%'.$request->search['value'].'%');
            $contacts->orWhere('email', 'like', '%'.$request->search['value'].'%');

        }

        if(isset($request->order))
        {
            $contacts->orderBy($columns[$request->order['0']['column']], $request->order['0']['dir']);
        }
        else
        {
            $contacts->orderBy('id', 'DESC');
        }

        if($request->length != -1)
        {
            $contacts->take($request->length)->skip($request->start);
        }

        //dd($contacts->toSql());

        $contactDetails=$contacts->get();

        $data=array();
        foreach($contactDetails as $cont){
            $data1=array();
            $data1[0]=$cont->id;
            $data1[1]=$cont->title;
            $data1[2]=$cont->address;
            $data1[3]=$cont->location;
            $data1[4]=$cont->email;
            $data1[5]='<a title="Edit" class="btn btn-primary" href="'.route('contact.edit', ['id' => $cont->id]).'"><i class="fa fa-pencil"></i></a>
            <a title="Delete" data-method="delete" class="btn btn-danger jquery-postback" href="'.route('contact.destroy', $cont->id).'"><i class="fa fa-trash"></i></a>';

            array_push($data,$data1);
        }

        $output = array(
             "draw"    => intval($request->draw),
             "recordsTotal"  =>  Contact::all()->count(),
             "recordsFiltered" => $contacts->count(),
             "data"    => $data
        );
        return response()->json($output);
    }
}
