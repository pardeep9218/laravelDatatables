@extends('admin.main')


@section('styles')
<link href="{{ asset('css/cropie.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="pageheader">
    <h3><i class="fa fa-home"></i> About </h3>
    <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
            <li> <a href="#"> Home </a> </li>
            <li class="active"> About </li>
        </ol>
    </div>
</div>
@endsection
@section('content')
    <div id="page-content">

        <div class="row">
            <div class="col-md-12">   
                <form action="<?php if(empty($about)){ echo route('about.store');}else{ echo route('about.update',$about->id);}?>" method='post' enctype='multipart/form-data'>    <?php if(!empty($about)){ echo method_field('PUT'); } ?>
                    {{ csrf_field() }}        
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">About Us</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                @if($errors->any())
                                   {!! entryMessages($errors->all(),'danger') !!}
                                @endif
                                {!! displayMessage() !!}
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" placeholder="Enter title" name='title' id="title" value='<?php if(!empty($about->title)){ echo $about->title; }?>' class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea placeholder="Enter Description" rows='10' name='description' id="description" class="form-control"><?php if(!empty($about->description)){ echo $about->description; }?></textarea>
                                    </div>
                                </div>
                                <div class='col-sm-4 col-xs-12'>
			                        <div class="form-group">
			                            <label class="control-label"> Image</label>
			                        	<div id="upload-demo-i" class='open-cropie-modal'>
			                                <?php if(!empty($about->image)){ ?>
                                                <img src="{{ asset('/uploads/about/'.$about->image) }}" alt="featured_image">
                                            <?php } ?>
			                            </div>
			                            <input type="hidden" class="form-control" name="featured_image_old" id='featured_image_old' value='<?php if(!empty($about->image)){ echo $about->image;}?>'>
			                            <input type="hidden" class="form-control do-not-ignore" name="featured_image" id="userimage">
	                            		<input type="hidden" class="form-control" name="large_image" id="large-image">
			                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">Select Image</button>
			                        </div>
								</div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-info" name='submit' type="submit">Submit</button>
                        </div>
                    </div>
                </form>
           </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
           <!-- Modal content-->
           <div class="modal-content">
             <div class="modal-header">
               <h4 class="modal-title">Select and Crop Image
                  <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
               </h4>
             </div>
             <div class="modal-body">
                <div class="row">
                     <div class="col-md-7 text-center">
                       <div class="upload-demo-wrap">
                            <div id="upload-demo"></div>
						</div>
                     </div>
                     <div class="col-md-5">
                        <strong>Select Image:</strong>
                        <br/>
                        <input type="file" id="upload" onchange="enableCrop(id);">
                        <br/>
                        <button class="btn btn-success upload-result" title='Select image to crop' data-dismiss="modal">Done</button>
                     </div>
                  </div>
             </div>
           </div>
         </div>
    </div>	
<!-- /.box -->
@endsection

@section('scripts')
<script src="{{ asset('js/cropie.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/newinitializecropie.js') }}" type="text/javascript"></script>
<script>
	demoUpload();
</script>
@endsection

