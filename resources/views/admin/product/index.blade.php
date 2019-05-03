@extends('admin.main')

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
<div id="page-content">
    <div class="panel">
        <div class="panel-body">
            <table id="example" class="table responsive cell-border" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th> Id </th>
                        <th> Pic </th>
                        <th> Title </th>
                        <th> Price </th>
                        <th> Color and Size </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th> Id </th>
                        <th> Pic </th>
                        <th> Title </th>
                        <th> Price </th>
                        <th> Color and Size </th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- All Categories End-->
    </div>
    <!-- /.box-body -->
</div>
@endsection


@section('scripts')
<script>
    initializeDatatable('example','{{ route("productsDatatable") }}','{{ csrf_token() }}','products');
</script>
@endsection


