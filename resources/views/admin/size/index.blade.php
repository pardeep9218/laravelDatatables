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
                <form action="<?php if(empty($size)){ echo route('size.store');}else{ echo route('size.update',$size->id);}?>" method='post'>    
                	<?php if(!empty($size)){ echo method_field('PUT'); } ?>
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
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Size</label>
                                        <input type="text" placeholder="Enter Size" name='title' id="title" value='<?php if(!empty($size->title)){ echo $size->title; }?>' class="form-control">
                                    </div>
			                        <div class="form-group text-right">
			                            <button class="btn btn-info" name='submit' type="submit">Submit</button>
			                        </div>
                                </div>
                                <div class='col-sm-8 col-xs-12'>
			                        <table id="example" class="table responsive cell-border" width="100%" cellspacing="0">
					                    <thead>
					                        <tr>
					                            <th> ID </th>
		                                        <th> Size </th>
		                                        <th data-priority="2" width='100'> Action </th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
					                            <th>ID</th>
		                                        <th> Size </th>
		                                        <th data-priority="2" width='100'> Action </th>
					                        </tr>
					                    </tfoot>
					                </table>
								</div>
                            </div>
                        </div>
                    </div>
                </form>
           </div>
        </div>
    </div>
<!-- /.box -->
@endsection
@section('scripts')

<script>
    initializeDatatable('example','{{ route("size.datatable") }}','{{ csrf_token() }}','size');
</script>
@endsection

