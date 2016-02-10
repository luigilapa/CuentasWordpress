<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuentas por pagar & Cuentas por cobrar</title>
    {!! Html::style('assets/css/bootstrap.min.css') !!}
    @yield('style')
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
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@yield('nav');

<div class="container-fluid main-container">
    @yield('content')
</div>

{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/bootstrap.min.js') !!}
{!! Html::script('assets/js/noty/packaged/jquery.noty.packaged.min.js') !!}
@yield('script');
</body>
<footer class="footer">

    <hr class="divider"/>
    @yield('footer')
</footer>
</html>
