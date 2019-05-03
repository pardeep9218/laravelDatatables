<!DOCTYPE html>
<html lang="en">
    <head>
        <!--STYLESHEET-->
        <!--=================================================-->
        
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">

	    <title>{{ config('app.name', 'Product Cart') }}</title>

		<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
		<!--Roboto Slab Font [ OPTIONAL ] -->
		<link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Roboto:500,400italic,100,700italic,300,700,500italic,400" rel="stylesheet">
		<!--Bootstrap Stylesheet [ REQUIRED ]-->
		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
		<!-- Default theme -->
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.min.css"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<!--Jasmine Stylesheet [ REQUIRED ]-->
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<!--Font Awesome [ OPTIONAL ]-->
		<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
		<link href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="//cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
		@yield('styles')
		<!--SCRIPT-->
		<!--=================================================-->
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="{{ asset('plugins/pace/pace.min.css') }}" rel="stylesheet">
		<script src="{{ asset('plugins/pace/pace.min.js') }}"></script>
    </head>
    <!--TIPS-->
    <body>
        <div id="container" class="effect mainnav-lg navbar-fixed mainnav-fixed">
            <!--NAVBAR-->
            <!--===================================================-->
            <header id="navbar">
			    <div id="navbar-container" class="boxed">
			        <!--Brand logo & name-->
			        <!--================================-->
			        <div class="navbar-header">
			            <a href="index.html" class="navbar-brand">
			                <i class="fa fa-cube brand-icon"></i>
			                <div class="brand-title">
			                    <span class="brand-text">Product Cart</span>
			                </div>
			            </a>
			        </div>
			        <!--================================-->
			        <!--End brand logo & name-->
			        <!--Navbar Dropdown-->
			        <!--================================-->
			        <div class="navbar-content clearfix">
			            <ul class="nav navbar-top-links pull-left">
			                <!--Navigation toogle button-->
			                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			                <li class="tgl-menu-btn">
			                    <a class="mainnav-toggle" href="#"> <i class="fa fa-navicon fa-lg"></i> </a>
			                </li>
			                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			                <!--End Navigation toogle button-->
			            </ul>
			            <ul class="nav navbar-top-links pull-right">
			                <!--Navigation toogle button-->
			                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			                <li class="hidden-xs">
			                	<a href="{{ route('adminlogout') }}"> <i class="fa fa-sign-out fa-fw"></i> Logout </a>
			                </li>
			                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			                <!--End Navigation toogle button-->
			            </ul>
			        </div>
			        <!--================================-->
			        <!--End Navbar Dropdown-->
			    </div>
			</header>
            <!--===================================================-->
            <!--END NAVBAR-->
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    @yield('breadcrumb')
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                    	@yield('content')
                    </div>
                    <!--===================================================-->
                    <!--End page content-->
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->
                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <nav id="mainnav-container">
					<div id="mainnav">
					    <!--Menu-->
					    <!--================================-->
					    <div id="mainnav-menu-wrap">
					        <div class="nano">
					            <div class="nano-content">
					                <ul id="mainnav-menu" class="list-group">
					                    <!--Category name-->
					                    <li class="list-header">Navigation</li>
					                    <!--Menu list item-->
					                    <li>
					                        <a href="index.php">
						                        <i class="fa fa-home"></i>
						                        <span class="menu-title">Dashboard</span>
						                    </a>
					                    </li>
					                    <!--Menu list item-->
				                        <li>
				                            <a href="#">
					                            <i class="fa fa-user"></i>
					                            <span class="menu-title">
						                            Categories<!-- 
						                            <span class="label label-mint pull-right">New</span> -->
					                            </span>
				                            </a>
				                            <!--Submenu-->
				                            <ul class="collapse">
				                                <li><a href="{{ route('category.create') }}">Add New</a></li>
				                                <li><a href="{{ route('category.index') }}">All Categories</a></li>
				                            </ul>
				                        </li>
					                    <li>
				                            <a href="{{ route('size.index') }}">
						                        <i class="fa fa-tasks"></i>
						                        <span class="menu-title">Size</span>
						                    </a>
				                        </li>
				                        <li>
				                            <a href="#">
					                            <i class="fa fa-user"></i>
					                            <span class="menu-title">
						                            Contact<!-- 
						                            <span class="label label-mint pull-right">New</span> -->
					                            </span>
				                            </a>
				                            <!--Submenu-->
				                            <ul class="collapse">
				                                <li><a href="{{ route('contact.create') }}">Add New</a></li>
				                                <li><a href="{{ route('contact.index') }}">All Contacts</a></li>
				                            </ul>
				                        </li>
					                    <li>
				                            <a href="{{ route('about.index') }}">
						                        <i class="fa fa-tasks"></i>
						                        <span class="menu-title">About</span>
						                    </a>
				                        </li>
					                </ul>
					            </div>
					        </div>
					    </div>
					    <!--================================-->
					    <!--End menu-->
					</div>
				</nav>
                <!--===================================================-->
                <!--END MAIN NAVIGATION-->

            </div>
            <!-- FOOTER -->
            <!--===================================================-->
    		<footer id="footer">
			    <!-- Visible when footer positions are static -->
			    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			    <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
			    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			    <p class="pad-lft">&#0169; {{ date('Y') }} Product Cart</p>
			</footer>
            <!--===================================================-->
            <!-- END FOOTER -->
            <!-- SCROLL TOP BUTTON -->
            <!--===================================================-->
            <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
            <!--===================================================-->
        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->
        <!--JAVASCRIPT-->
        <!--=================================================-->
        <!--jQuery [ REQUIRED ]-->
		<script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
		<!--BootstrapJS [ RECOMMENDED ]-->
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
		<!--Fast Click [ OPTIONAL ]-->
		<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>
		<script src="{{ asset('plugins/fast-click/fastclick.min.js') }}"></script>
		<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
		<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js" type="text/javascript"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
		<script src="{{ asset('js/ajaxdatatables.js') }}"></script>
		<!--Jasmine Admin [ RECOMMENDED ]-->
		@yield('scripts')
		<script>
			$.ajaxSetup({
			        headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
			});
			$(document).on('click', 'a.jquery-postback', function(e) {
			    e.preventDefault(); // does not go through with the link.

			    var $this = $(this);
			    $.ajax({
			        type: $this.data('method'),
			        url: $this.attr('href')
			    }).done(function (data) {
			        if(data==true){
			            location.reload();
			        }
			    });
			});
			var SITE_PATH='{{ URL::to('/') }}';
			var ADMIN_PATH='{{ URL::to('/admin') }}';
		</script>
		<script src="{{ asset('js/commonscripts.js') }}"></script>
		<script src="{{ asset('js/scripts.js') }}"></script>
		


    </body>
</html>
