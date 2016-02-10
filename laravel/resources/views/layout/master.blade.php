<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuentas por pagar & Cuentas por cobrar</title>
    {!! Html::style('assets/css/bootstrap.min.css') !!}

    {!! Html::style('assets/css/layout.css') !!}
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">MENÚ</button>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Cuentas por pagar & Cuentas por cobrar</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!--                <form class="navbar-form navbar-left" method="GET" role="search">
                                <div class="form-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search">
                                </div>
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                            </form>-->
            <ul class="nav navbar-nav navbar-right">
                @if (!Auth::guest())
                    <li>
                        <a href="{{route('home')}}">{{ Auth::user()->name }} <small class="glyphicon glyphicon-user"></small> </a>
                    </li>
                @endif
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Cuenta
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-header">CONFIGURACIÓN</li>
                        <li class=""><a href="{!! route('user_reset') !!}"><small class="glyphicon glyphicon-wrench"></small> Cambiar Credenciales</a></li>
                        <li class="divider"></li>
                        <li><a href="{{route('logout')}}"><small class="glyphicon glyphicon-log-out"></small> Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid main-container">
    <div class="col-md-2 sidebar">
        <div class="row">
            <!-- uncomment code for absolute positioning tweek see top comment in css -->
            <div class="absolute-wrapper"> </div>
            <!-- Menu -->
            <div class="side-menu">
                <nav class="navbar navbar-default" role="navigation">
                    <!-- Main Menu -->
                    <div class="side-menu-container">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="{{route('home')}}"><span class="glyphicon glyphicon-home"></span>Inicio</a></li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-Clientes" class="bg-primary">
                                    <span class="glyphicon glyphicon-book"></span> Clientes <span class="caret"></span>
                                </a>

                                <!-- Usuarios-->
                                <div id="dropdown-Clientes" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav navbar-inverse">
                                            <li><a href="{{route('registrar_cliente')}}"><small class="glyphicon glyphicon-plus"></small>Registrar</a></li>
                                            <li><a href="{{route('lista_clientes')}}"><small class="glyphicon glyphicon-list"></small>Lista</a></li>
                                            <li><a href="{{route('anulados_clientes')}}"><small class="glyphicon glyphicon-trash"></small>Anulados</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-Proveedores" class="bg-primary">
                                    <span class="glyphicon glyphicon-book"></span> Proveedores <span class="caret"></span>
                                </a>

                                <!-- Usuarios-->
                                <div id="dropdown-Proveedores" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav navbar-inverse">
                                            <li><a href="{{route('registrar_proveedor')}}"><small class="glyphicon glyphicon-plus"></small>Registrar</a></li>
                                            <li><a href="{{route('lista_proveedores')}}"><small class="glyphicon glyphicon-list"></small>Lista</a></li>
                                            <li><a href="{{route('anulados_proveedores')}}"><small class="glyphicon glyphicon-trash"></small>Anulados</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-Lawyer" class="bg-primary">
                                    <span class="glyphicon glyphicon-hand-right"></span> Cuentas por cobrar <span class="caret"></span>
                                </a>

                                <!-- Usuarios-->
                                <div id="dropdown-Lawyer" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav navbar-inverse">
                                            <li><a href="{{route('registrar_ctaxcobrar')}}"><small class="glyphicon glyphicon-plus"></small>Registrar</a></li>
                                            <li><a href="{{route('consulta_ctaxcobrar')}}"><small class="glyphicon glyphicon-list"></small>Lista</a></li>
                                            <li><a href="{{route('abono_ctaxcobrar')}}"><small class="glyphicon glyphicon-usd"></small>Registrar Abono</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-Contributions" class="bg-primary">
                                    <span class="glyphicon glyphicon-hand-left"></span> Cuentas por pagar <span class="caret"></span>
                                </a>

                                <!-- Usuarios-->
                                <div id="dropdown-Contributions" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav navbar-inverse">
                                            <li><a href="{{route('registrar_ctaxpagar')}}"><small class="glyphicon glyphicon-plus"></small>Registrar</a></li>
                                            <li><a href="{{route('consulta_ctaxpagar')}}"><small class="glyphicon glyphicon-list"></small>Lista</a></li>
                                            <li><a href="{{route('abono_ctaxpagar')}}"><small class="glyphicon glyphicon-usd"></small>Registrar Abono</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-Resports" class="bg-primary">
                                    <span class="glyphicon glyphicon-file"></span> Reportes <span class="caret"></span>
                                </a>

                                <!-- Usuarios-->
                                <div id="dropdown-Resports" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav navbar-inverse">
                                            <li><a href="{{route("registro_cuenta")}}"><small class="glyphicon glyphicon-print"></small>Registros de Cuentas</a></li>
                                            <!--<li><a href="#"><small class="glyphicon glyphicon-print"></small>Reporte 2</a></li>-->
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-User" class="bg-primary">
                                    <span class="glyphicon glyphicon-user"></span> Usuarios <span class="caret"></span>
                                </a>

                                <!-- Usuarios-->
                                <div id="dropdown-User" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav navbar-inverse">
                                            @if(Auth::user()->type == 'administrador')
                                            <li><a href="{{route('user_register')}}"><small class="glyphicon glyphicon-plus"></small>Agregar</a></li>
                                            @endif
                                            <li><a href="{{route('user_list')}}"><small class="glyphicon glyphicon-list"></small>Lista</a></li>
                                            <li><a href="{{route('user_out')}}"><small class="glyphicon glyphicon-ban-circle"></small>Inactivos</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>

            </div>
        </div>
    </div>
    <div class="col-md-10 content">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">{{$title }}</h3>
                @yield('panel')
            </div>
            <div class="panel-body">
                <div style="max-height:550px; overflow-y: scroll; overflow-x:hidden;">
                    @yield('content')
                </div>
                <div>
                    @yield('content_extend')
                </div>
            </div>
        </div>
    </div>
</div>
{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/jquery-ui.js') !!}
{!! Html::style('assets/js/jquery-ui.css') !!}
{!! Html::script('assets/js/bootstrap.min.js') !!}
{!! Html::script('assets/js/layout.js') !!}
{!! Html::script('assets/js/noty/packaged/jquery.noty.packaged.min.js') !!}
@yield('script');
</body>
<footer class="pull-right footer">

    <p class="col-md-12">
    <hr class="divider"/>
    <!-- <a href="@"></a> -->
    </p>

</footer>
</html>
