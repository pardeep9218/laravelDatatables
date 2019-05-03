@extends('admin.main')

@section('styles')
<link href="{{ asset('css/cropie.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" />
@endsection
@section('breadcrumb')
<div class="pageheader">
    <h3><i class="fa fa-home"></i> Product </h3>
    <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
            <li> <a href="#"> Home </a> </li>
            <li class="active"> Product </li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<script> var count=0;</script>
    <div class="row">
        <div class="col-md-12">   
            <form action="<?php if(empty($product)){ echo route('product.store');}else{ echo route('product.update',$product->id);}?>" method='post' enctype='multipart/form-data'>     <?php if(!empty($product)){ echo method_field('PUT'); } ?>    
            {{ csrf_field() }}        
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add New Product</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @if($errors->any())
                               {!! entryMessages($errors->all(),'danger') !!}
                            @endif
                            {!! displayMessage() !!}
                            <div class='col-xs-12 col-sm-8'>
                                <div class='row'>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" placeholder="Enter Title" name='title' value='<?php if(!empty($product->title)){ echo $product->title; }?>' id="title" class="form-control">
                                        </div>
                                    </div>
            
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label">Category</label>
                                            <select class="form-control selectpicker" name='category'>
                                                <option value=''></option>
                                                @if(!empty($categories))
                                                     @foreach($categories as $cat)
                                                    <option value='<?php echo $cat['id'];?>' <?php if(!empty($product) && !empty($product->categories->first()) && $product->categories->first()->id==$cat['id']){ echo 'selected';}?>> <?php echo $cat['name'];?></option>
                                                        @if(count($cat->children) && !empty($product))
                                                            @include('admin.category.manageChildCategory',['children' => $cat->children,'dashes'=>'','selectedcat'=>$product->categories->first()->id])
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <label class="control-label"> Selling Price</label>
                                        <input type="text" class="form-control" placeholder="Price" value='<?php if(!empty($product->price)){ echo $product->price; }?>' name="price">
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <label class="control-label">MRP</label>
                                        <input type="text" class="form-control" placeholder="Striked Price" value='<?php if(!empty($product->strike_price)){ echo $product->strike_price; }?>' name="strike_price">
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <label class="control-label">Snapdeal Url</label>
                                        <input type="text" class="form-control" placeholder="Snapdeal Url" value='<?php if(!empty($product->snapdeal)){ echo $product->snapdeal; }?>' name="snapdeal">
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <label class="control-label">Flipkart Url</label>
                                        <input type="text" class="form-control" placeholder="Flipkart Url" value='<?php if(!empty($product->flipkart)){ echo $product->flipkart; }?>' name="flipkart">
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <label class="control-label">Amazon Url</label>
                                        <input type="text" class="form-control" placeholder="Amazon Url" value='<?php if(!empty($product->amazon)){ echo $product->amazon; }?>' name="amazon">
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <label class="control-label">Color</label>
                                        <div id="cp2" class="input-group colorpicker-component color-picker"> 
                                            <input type="text" value="#000000" name='colors' class="form-control color-value" readonly /> 
                                            <span class="input-group-addon"><i></i></span> 
                                            <div class="input-group-btn">
                                                <button type='button' class='btn add-color btn-primary'>Add Color <i class='fa fa-plus'></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 colors-div">
                                        <?php 
                                        if(!empty($product->colors)){
                                            foreach($product->colors as $key => $color){
                                            ?>
                                            <div class='row color-row'>
                                                <div class='col-sm-2'>
                                                    <label>Color</label>
                                                    <div class='small-color-box' style='background:<?php echo $color['color'];?>'></div>
                                                    <input type='hidden' class='form-control' name='data[<?php echo $key;?>][color]' value='<?php echo $color['color'];?>' readonly>
                                                    <input type='hidden' class='form-control' name='data[<?php echo $key;?>][oldid]' value='<?php echo $color['id'];?>' readonly>
                                                
                                                </div>
                                                <div class='col-sm-4'>
                                                    <label>Images</label>
                                                    <input type='file' name='data[<?php echo $key;?>][images][]' class='js-input-img' id='imginput<?php echo $key;?>' multiple>
                                                    <?php foreach(unserialize($color['images']) as $imagevalue){ ?>
                                                    <div class='old-img'>
                                                        <img src='{{ asset('uploads/products/'.$imagevalue) }}' width='50px' height='50px'>
                                                        <input type='hidden' name='data[<?php echo $key;?>][oldimages][]' value='<?php echo $imagevalue;?>'>
                                                        <button type='button' class='btn btn-danger del-old-img' img='<?php echo $imagevalue;?>'><i class='fa fa-minus'></i></button>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class='col-sm-4'>
                                                    <label>Size</label>
                                                    <select class="form-control selectpicker js-input" multiple name='data[<?php echo $key;?>][size][]' data-placeholder="select size" id='select<?php echo $key;?>'>
                                                        <option value=''>Select size</option>
                                                        <?php
                                                        if(!empty($sizes)){
                                                            foreach($sizes as $size){
                                                            ?>
                                                            <option value="<?php echo $size['title'];?>"<?php if(in_array($size['title'],explode(',',$color->sizes))){echo ' selected';}?>><?php echo $size['title'];?></option>';
                                                        <?php }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <div class='col-sm-2'>
                                                    <label class='col-xs-12'>&nbsp;</label>
                                                    <button type='button' class='btn btn-danger del-uploaded-color' id='<?php echo $color['id'];?>'><i class='fa fa-minus'></i></button>
                                                </div>
                                            </div>
                                            <?php
                                            }  
                                        }
                                        if(!empty($product->colors) && count($product->colors)>0){
                                            ?>
                                            <script>
                                                count='<?php echo $key+1;?>';
                                            </script>
                                        <?php }
                                        ?>
                                    </div>
                                    <div class='col-sm-12 col-xs-12'>
                                        <div class="form-group">
                                            <label class="control-label"> Description</label>
                                            <textarea type="text" class="form-control textarea" placeholder="Description" name="description"><?php if(!empty($product->description)){ echo $product->description;}?></textarea>
                                        </div>
                                    </div>
                                    <div class='col-sm-6 col-xs-12'>
                                        <div class="form-group">
                                            <label class="control-label"> Availability</label>
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-radio">
                                                    <input id="availabilitycheck1" <?php if(!empty($product->availability) && $product->availability==1){echo 'checked';}?> name='availability' value="1" type="radio">Available
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    <input id="availabilitycheck2" <?php if(empty($product->availability) || $product->availability==0){echo 'checked';}?> name='availability' value="0" type="radio">Not Available
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-4 col-xs-12'>
                                <div class="form-group">
                                    <label class="control-label"> Image</label>
                                    <div id="upload-demo-i" class='open-cropie-modal'>
                                        <?php if(!empty($product->featured_image)){ ?>
                                            <img src="{{ asset('uploads/products/'.$product->featured_image) }}" alt="featured_image">
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" class="form-control" name="featured_image_old" value='<?php if(!empty($product->featured_image)){ echo $product->featured_image;}?>' id='featured_image_old'>
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
@endsection
@section('scripts')
<script src="{{ asset('js/cropie.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/newinitializecropie.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
<script>
    demoUpload();
</script>
@endsection

