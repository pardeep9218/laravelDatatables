<?php

namespace App\Http\Controllers;
use App\color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    public function deleteColor(Request $request){
    	DB::enableQueryLog();
        $data=array(
            'status'=>'error',
            'msg'=>'Error occured'
        );

    	if($request->type=='color'){
    		$color=Color::find($request->id);
		    if($color){
		        $images=unserialize($color->images);
		        foreach($images as $image){
		            if(!empty($image) && file_exists(public_path('uploads/products/').$image)){
		                unlink(public_path('uploads/products/').$image);
		            }
		            if(!empty($image) && file_exists(public_path('uploads/products/original/').$image)){
		                unlink(public_path('uploads/products/original/').$image);
		            }
		        }
		        $deleted=$color->delete();
		        if($deleted){
		            $data=array(
		                'status'=>'success',
		                'msg'=>'Color Deleted'
		            );
		        }else{
		            $data=array(
		                'status'=>'error',
		                'msg'=>'Error occured'
		            );
		        }
		        
		    }else{
		        $data=array(
		            'status'=>'error',
		            'msg'=>'Error occured'
		        );
		    } 
		}

		if($request->type=='img'){
		   
		    if(!empty($request->img) && file_exists(public_path().'/uploads/products/'.$request->img)){
		        unlink(public_path().'/uploads/products/'.$request->img);
		        $data=array(
		            'status'=>'success',
		            'msg'=>'Image Deleted'
		        );
		    }else{
		        $data=array(
		            'status'=>'error',
		            'msg'=>'Error occured'
		        );
		    } 
		}
		return response()->json($data);
	}
}
