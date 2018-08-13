<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

	<meta content="text/html" charset="utf-8" http-equiv="Content-Type"/>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8"/>
	<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
	<title>
		Nivelación - @yield('title')
	</title>
	<!-- Styles -->
	<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet"/>

                        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
                            <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
                                <!-- Bootstrap -->
                                <link href="{{ URL::asset('/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
                                    <!-- Font Awesome -->
                                    <link href="{{ URL::asset('/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
                                        <!-- NProgress -->
                                        <link href="{{ URL::asset('/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
                                            <!-- iCheck -->
                                            <link href="{{ URL::asset('/vendors/iCheck/skins/flat/red.css') }}" rel="stylesheet">
                                                <!-- switch -->
                                                <link href="{{ URL::asset('/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
                                                    <!-- bootstrap-progressbar -->
                                                    <link href="{{ URL::asset('/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
                                                        <!-- JQVMap -->
                                                        <link href="{{ URL::asset('/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
                                                        <!-- bootstrap-daterangepicker -->
                                                        <link href="{{ URL::asset('/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
                                                            <!-- Custom Theme Style -->
                                                            <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
                                                            </link>
                                                            <link href="{{ URL::asset('js/datatable/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
                                                            </link>
                                                            <link href="{{ URL::asset('js/datatable/extensions/Buttons/css/buttons.dataTables.min.css') }}" rel="stylesheet">
                                                            </link>
                                                            <link href="{{ URL::asset('css/jquery.timepicker.min.css') }}" rel="stylesheet">
                                                            </link>
                                                            <link href="{{ URL::asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
                                                            </link>
                                                        </link>
                                                    </link>
                                                </link>
                                            </link>
                                        </link>
                                    </link>
                                </link>
                            </link>
                        </link>
                    </meta>
                </meta>
            </meta>
        </meta>

 <link href="{{URL::asset('/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ URL::asset('/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-duallistbox.min.css') }}">
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0">
                            <a class="site_title" href="/home">
                                <img alt="" src="{{ URL::asset('img/itsc_logo.png')}}" width="51px">
                                    <span>
                                        Nivelación ITSC
                                    </span>
                                </img>
                            </a>
                        </div>
                        <div class="clearfix">
                        </div>

<?php
//obtener los caracteres que estan antes del @ y poner la primera letra en mayuscula
$email = Auth::user()->email;
$user = Auth::user()->id;
$name = ucfirst(strtok($email, '@'));

?>

						<!-- menu profile quick info -->
						<div class="profile clearfix">
							<div class="profile_info">
								<span>Bienvenido</span>
								<h2>{{ $name }}</h2>
							</div>
						</div>
						<!-- /menu profile quick info -->

						<br />



            <?php           
            $roll = Auth::user()->rolls_id;
            ?>
            @if($roll == 1)
            
    <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                 <ul class="nav side-menu">
   <li>
   <a href="/home"><i class="fa fa-home"></i> Home</a>
   </li>
   <li>
   <a href="#"><i class="fa fa-bar-chart-o"></i> Estudiantes<span class="glyphicon glyphicon-menu-down"></span></a>
   <ul class="nav child_menu">
    <li><a href="/students"><i class="fa fa-edit"></i> Estudiantes</a></li>
    <li><a href="/listaEstudiantes"><i class="fa fa-table"></i>Subir lista de estudiantes</a></li>
   </ul>
   
   </li>
   <li>
   <a href="/teachers"><i class="fa fa-graduation-cap"></i> Docentes</a>
   </li>
   <li>
   <a href="#"><i class="fa fa-bar-chart-o"></i> Secciones <span class="glyphicon glyphicon-menu-down"></span></a>
   <ul class="nav child_menu">
    <li> <a href="/sections"><i class="fa fa-table"></i> Secciones</a></li>
    <li><a href="dates/create"><i class="fa fa-table"></i>Fecha de Calificaciones</a></li>
   </ul>
   </li>
   <li>
    <a href="/employees"><i class="fa fa-group"></i> Empleados</a>
   </li>
   <li>
   <a href="/classrooms"><i class="fa fa-building-o""></i> Aulas</a>
   </li>
   <li>
   <a href="/academic_periods"><i class="fa fa-table"></i> Periodos Academicos</a>
   </li>
   <li>
   <a href="/log"><i class="fa fa-list-alt"></i> Auditoria</a>
   </li>
   <li>
   <a href="#"><i class="fa fa-bar-chart-o"></i> Citas de idiomas</a>
   <ul class="nav child_menu">

    <li><a href="\ingles">Ingles</a></li>
    <li><a href="\frances">Frances</a></li>

   </ul>
   </li>
   <li>
   <a href="/subjects"><i class="fa fa-book"></i> Materias</a>
   </li>

 </ul>

              </div>
            </div>
            <!-- /sidebar menu -->


            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Editar cuenta">
              <span class="glyphicon glyphicon-cog" aria-hidden="true" href="#"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>
            @elseif($roll == 2)
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                 <ul class="nav side-menu">
   <li>
   <a href="/home"><i class="fa fa-home"></i> Home</a>
   </li>
   <li>
   <a href="/qualifications"><i class="fa fa-edit"></i> Calificaciones</a>
   </li>
   <li>
   <a href="/horarioProfesor"><i class="fa fa-desktop"></i> Secciones</a>
   </li>
 </ul>
              </div>
            </div>



            
            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Editar cuenta">
              <span class="glyphicon glyphicon-cog" aria-hidden="true" href="#"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>
            @endif

            <!-- /sidebar menu -->


			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>

						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									{{ $name }}
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">



								<li><a href="{{ route('users.edit',Auth::user()->id) }}">Editar cuenta</a></li>


									<li>
										<a href="{{ route('logout') }}"
										onclick="event.preventDefault();

										document.getElementById('logout-form').submit();">
										Cerrar sesión
										<i class="fa fa-sign-out pull-right">
										</i>
									</a>
									<form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>

		</div>
		<!-- /top navigation -->


		<!-- /page content -->

<div class="right_col" role="main">
<div class="">
<div class="clearfix">
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>
@yield('title-content')
</h2>
<div class="clearfix">
</div>
</div>
<div class="x_content">
<div class="container">
@yield('content')

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /page content -->

<!-- footer content -->
<footer>
<div class="pull-right">
ITSC - 2017
</div>
<div class="clearfix">
</div>
</footer>
<!-- /footer content -->
</div>
</div>


</div>


<!-- jQuery -->
<script src="{{ URL::asset('/vendors/jquery/dist/jquery.min.js') }}">
</script>
<!-- Bootstrap -->
<script src="{{ URL::asset('/vendors/bootstrap/dist/js/bootstrap.min.js') }}">
</script>
{{-- input mask --}}
<script src="{{ URL::asset('js/jquery.inputmask.bundle.min.js') }}">
</script>
<!-- FastClick -->
<script src="{{ URL::asset('/vendors/fastclick/lib/fastclick.js') }}">
</script>
<!-- switch -->
<link href="{{ URL::asset('/vendors/switchery/dist/switchery.min.js') }}" rel="stylesheet">
<!-- NProgress -->
<script src="{{ URL::asset('/vendors/nprogress/nprogress.js') }}">
</script>
<!-- Chart.js -->
<script src="{{ URL::asset('/vendors/Chart.js/dist/Chart.min.js') }}">
</script>
<!-- gauge.js -->
<script src="{{ URL::asset('/vendors/gauge.js/dist/gauge.min.js') }}">
</script>
<!-- bootstrap-progressbar -->
<script src="{{ URL::asset('/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
</script>
<!-- iCheck -->
<script src="{{ URL::asset('/vendors/iCheck/icheck.min.js') }}">
</script>
<!-- Skycons -->
<script src="{{ URL::asset('/vendors/skycons/skycons.js') }}">
</script>
<!-- Flot -->
<script src="{{ URL::asset('/vendors/Flot/jquery.flot.js') }}">
</script>
<script src="{{ URL::asset('/vendors/Flot/jquery.flot.pie.js') }}">
</script>
<script src="{{ URL::asset('/vendors/Flot/jquery.flot.time.js') }}">
</script>
<script src="{{ URL::asset('/vendors/Flot/jquery.flot.stack.js') }}">
</script>
<script src="{{ URL::asset('/vendors/Flot/jquery.flot.resize.js') }}">
</script>
<!-- Flot plugins -->
<script src="{{ URL::asset('/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}">
</script>
<script src="{{ URL::asset('/vendors/flot-spline/js/jquery.flot.spline.min.js') }}">
</script>
<script src="{{ URL::asset('/vendors/flot.curvedlines/curvedLines.js') }}">
</script>
<!-- DateJS -->
<script src="{{ URL::asset('/vendors/DateJS/build/date.js') }}">
</script>
<!-- JQVMap -->
<script src="{{ URL::asset('/vendors/jqvmap/dist/jquery.vmap.js') }}">
</script>
<script src="{{ URL::asset('/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}">
</script>
<script src="{{ URL::asset('/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}">
</script>
<!-- bootstrap-daterangepicker -->
<script src="{{ URL::asset('/vendors/moment/min/moment.min.js') }}">
</script>
<script src="{{ URL::asset('/vendors/bootstrap-daterangepicker/daterangepicker.js') }}">
</script>
<script src="{{ URL::asset('js/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ URL::asset('js/custom.js') }}">
</script>
<!-- <script src="{{ URL::asset('js/app.js') }}">-->
</script>
<script src="{{ URL::asset('js/datatable/media/js/jquery.dataTables.js') }}">
</script>
<script src="{{ URL::asset('js/datatable/media/js/dataTables.bootstrap.min.js') }}">
</script>
<script src="{{ URL::asset('js/datatable/extensions/Buttons/js/dataTables.buttons.min.js') }}">
</script>
<script src="{{ URL::asset('js/pdfmake.min.js') }}">
</script>
<script src="{{ URL::asset('js/vfs_fonts.js') }}">
</script>
<script src="{{ URL::asset('js/datatable/extensions/Buttons/js/buttons.html5.min.js') }}">
</script>
<script src="{{ URL::asset('/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>
@yield('script')

            <script>

            </script>

        </link>
    </body>

</html>