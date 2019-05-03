@extends('admin.main')

@section('breadcrumb')
<div class="pageheader">
    <h3><i class="fa fa-home"></i> Category </h3>
    <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
            <li> <a href="#"> Home </a> </li>
            <li class="active"> Categories </li>
        </ol>
    </div>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">   
        	<form action="{{ route('category.store') }}" method='post'>         
        	{{ csrf_field() }}        
	            <div class="panel">
		            <div class="panel-heading">
		                <h3 class="panel-title">Add New Category</h3>
		            </div>
		            <div class="panel-body">
		                <div class="row">
				        	@if($errors->any())
							   {!! entryMessages($errors->all(),'danger') !!}
							@endif
							{!! displayMessage() !!}
		                    <div class="col-sm-3 col-xs-6">
		                        <div class="form-group">
		                            <label>Name</label>
		                            <input type="text" placeholder="Enter category name" name='name' id="name" class="form-control">
		                        </div>
		                    </div>

		                    <div class="col-sm-3 col-xs-6">
		                        <div class="form-group">
			                        <label class="control-label">Parent Category</label>
			                        <select class="form-control selectpicker" name='parent'>
			                        	<option value=''></option>
			                            <?php 
			                            foreach($categories as $cat){ ?>
			                                <option value='<?php echo $cat['id'];?>'><?php echo $cat['name'];?></option>
			                            <?php } ?>
			                        </select>
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
@endsection


