@extends('admin.main')
@section('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css" />
@endsection
@section('breadcrumb')
<div class="pageheader">
    <h3><i class="fa fa-home"></i> Contact </h3>
    <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
            <li> <a href="#"> Home </a> </li>
            <li class="active"> Contact </li>
        </ol>
    </div>
</div>
@endsection
@section('content')
    <div id="page-content">

        <div class="row">
            <div class="col-md-12">   
                <form action="<?php if(empty($contact)){ echo route('contact.store');}else{ echo route('contact.update',$contact->id);}?>" method='post'>    <?php if(!empty($contact)){ echo method_field('PUT'); } ?>
                    {{ csrf_field() }}        
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add New Contact</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                @if($errors->any())
                                   {!! entryMessages($errors->all(),'danger') !!}
                                @endif
                                {!! displayMessage() !!}
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" placeholder="Enter title" name='title' id="title" value='<?php if(!empty($contact->title)){ echo $contact->title; }?>' class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" placeholder="Enter email" name='email' value='<?php if(!empty($contact->email)){ echo $contact->email; }?>' id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input type="text" placeholder="Enter contact" value='<?php if(!empty($contact->contact)){ echo $contact->contact; }?>' name='contact' id="contact" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea placeholder="Enter address" name='address' id="address" class="form-control"><?php if(!empty($contact->address)){ echo $contact->address; }?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <textarea placeholder="Enter location" name='location' id="location" class="form-control"><?php if(!empty($contact->location)){ echo $contact->location; }?></textarea>
                                    </div>
                                </div>
                                <div class='col-xs-12 col-sm-8'>
                                    <div class="form-group">
                                        <label class="control-label"> <b>Timings</b></label>
                                        <div class='row'>
                                            <div class='col-xs-6 col-sm-3'>
                                                <label class="control-label"> From Day</label>
                                                <select class='form-control' name='timings[startday]'>
                                                <?php $day_start = date( "d", strtotime( "next Sunday" ) ); // get next Sunday
                                                for ( $x = 0; $x < 7; $x++ ){
                                                    $dayname=date( "l", mktime( 0, 0, 0, date( "m" ), $day_start + $x, date( "y" ) ) ); 
                                                ?>
                                                    <option value='<?php echo $dayname;?>'<?php if(!empty($contact->timings['startday']) && $dayname==$contact->timings['startday']){echo ' selected';}?>><?php echo $dayname;?></option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                            <div class='col-xs-6 col-sm-3'>
                                                <label class="control-label"> To Day</label>
                                                <select class='form-control' name='timings[endday]'>
                                                <?php $day_start = date( "d", strtotime( "next Sunday" ) ); // get next Sunday
                                                for ( $x = 0; $x < 7; $x++ ){
                                                    $dayname=date( "l", mktime( 0, 0, 0, date( "m" ), $day_start + $x, date( "y" ) ) );
                                                ?>
                                                    <option value='<?php echo $dayname;?>'<?php if(!empty($contact->timings['endday']) && $dayname==$contact->timings['endday']){echo ' selected';}?>><?php echo $dayname;?></option>
                                                <?php } ?>
                                                </select>
                                            </div>

                                            <div class='col-xs-6 col-sm-3'>
                                                <label class="control-label"> Open Time</label>
                                                <div class="control-group">
                                                  <div class="controls">
                                                   <div class="input-append input-group form_time">
                                                     <input type="text" class="form-control" name='timings[opentime]' value='<?php if(!empty($contact->timings['opentime'])){ echo $contact->timings['opentime']; }?>'> 
                                                     <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                                   </div>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class='col-xs-6 col-sm-3'>
                                                <label class="control-label"> Close Time</label>
                                                <div class="control-group">
                                                  <div class="controls">
                                                   <div class="input-append input-group form_time">
                                                     <input type="text" class="form-control" name='timings[closetime]' value='<?php if(!empty($contact->timings['closetime'])){ echo $contact->timings['closetime']; }?>'> 
                                                     <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                                   </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
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
        <div class="panel">
            <div class="panel-body">
                <table id="example" class="table responsive cell-border" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- All Categories End-->
        </div>
        <!-- /.box-body -->
    </div>
<!-- /.box -->
@endsection

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    initializeDatatable('example','{{ route("contact.datatable") }}','{{ csrf_token() }}','contact');
</script>
@endsection


