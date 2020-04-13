<!DOCTYPE HTML>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="MarcoPolo Shop By Koorosh">

    <title>MarcoPolo</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">

    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <script src="{{asset('js/libs.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">

</head>
<body>
<header class="section-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img class="logo" src="{{asset('images/logos/logo-alibaba.png')}}" alt="alibaba style e-commerce html template file" title="alibaba e-commerce html css theme"></a>
            <button  class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTop">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="{{route('welcome')}}" class="nav-link">   Home </a></li>
                    <li class="nav-item"><a href="#" class="nav-link">   News </a></li>
                    <li class="nav-item"><a href="#" class="nav-link">   About </a></li>
                </ul>
                <!-- navbar-nav.// -->
            </div> <!-- collapse.// -->
        </div>
    </nav>

    <section class="header-main shadow-sm">
        <div class="container">
            <div class="row-sm align-items-center">
{{--                <div class="col-lg-4-24 col-sm-3">--}}
{{--                    <div class="category-wrap dropdown py-1">--}}
{{--                        <button type="button" class="btn btn-light  dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-bars"></i> Categories</button>--}}
{{--                        <div class="dropdown-menu">--}}
{{--                            @foreach($categories as $category)--}}
{{--                                <a onclick="PreRedirect(event , '{{$category->name}}');" class="dropdown-item" href="">{{$category->name}} </a>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-lg-11-24 col-sm-8">
                    <form action="#" class="py-1">
                        <div class="input-group w-100">
                            <!--                            <select class="custom-select"  name="category_name">-->
                            <!--                                <option value="">All type</option>-->
                            <!--                                <option value="">Special</option>-->
                            <!--                                <option value="">Only best</option>-->
                            <!--                                <option value="">Latest</option>-->
                            <!--                            </select>-->
                            <input id="searchQuery" type="text" class="form-control" style="width:50%;" placeholder="Search">
                            <div class="input-group-append">
                                <button onclick="SearchProduct()" class="btn btn-warning" type="button">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form> <!-- search-wrap .end// -->
                </div> <!-- col.// -->
                <div class="col-lg-9-24 col-sm-12">
                    <div class="widgets-wrap float-right row no-gutters py-1">
                        <div class="col-auto">
                            <div class="widget-header dropdown">
                                <a id="formdropdown" href="#" data-toggle="dropdown" data-offset="20,10">

                                    @if (!Auth::user())
                                        <div class="icontext">
                                            <div class="icon-wrap"><i class="text-warning icon-sm fa fa-user"></i></div>
                                            <div class="text-wrap text-dark">
                                                Sign in <br>
                                                My account <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="icontext">
                                            <div class="icon-wrap"><i class="text-warning icon-sm fa fa-user"></i></div>
                                            <div class="text-wrap text-dark">
                                                <p class="text-dark">Hi,{{Auth::user()->name}}</p>
                                                <a class="text-dark" href="{{ url('/clogout') }}">Logout</a>
                                            </div>
                                        </div>
                                    @endif

                                </a>
                                <div class="dropdown-menu">
{{--                                    <form class="px-4 py-3">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>Email address</label>--}}
{{--                                            <input type="email" class="form-control" placeholder="email@example.com" >--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>Password</label>--}}
{{--                                            <input type="password" class="form-control" placeholder="Password">--}}
{{--                                        </div>--}}
{{--                                        <button type="submit" class="btn btn-primary">Sign in</button>--}}
{{--                                    </form>--}}

                                    <div class="px-4 py-3">

                                        @if (session('error'))
                                            <div class="alert alert-warning alert-dismissible" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                            <p>
                                                <a href="{{ url('auth/google') }}" class="btn btn-block btn-twitter"> <i class="fab fa-google"></i> &nbsp; Login via Google</a>
                                                <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> &nbsp; Login via facebook</a>
                                            </p>
                                            <hr>

                                    {!! Form::open(['method' => 'POST' , 'action'=>'AuthController@login']) !!}
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email address')!!}
                                        {!! Form::text('email', null , ['class'=>'form-control'])!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('password', 'Password')!!}
                                        {!! Form::password('password' , ['class'=>'form-control'])!!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::submit('Sign in',['class'=>'btn btn-warning']) !!}
                                    </div>

                                    {!! Form::close() !!}
                                    </div>

                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" onclick="RegisterUser()">Have not register? Sign up</a>
                                    <a class="dropdown-item" href="{{ route('password.request') }}">Forgot password?</a>
                                </div> <!--  dropdown-menu .// -->
                            </div>  <!-- widget-header .// -->
                        </div> <!-- col.// -->
                        <div class="col-auto">
                            <a href="{{route('order')}}" class="widget-header">
                                <div class="icontext">
                                    <div class="icon-wrap"><i class="text-warning icon-sm  fa fa-shopping-cart"></i></div>
                                    <div class="text-wrap text-dark">
                                        <span id="basketCounter" class="small round badge badge-secondary">0</span>
                                        <div>Orders</div>
                                    </div>
                                </div>
                            </a>
                        </div> <!-- col.// -->
                    </div> <!-- widgets-wrap.// row.// -->
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- container.// -->
    </section> <!-- header-main .// -->
</header> <!-- section-header.// -->


<div id="app" class="bg">
    <div id="register-container" class="d-none">
        <register-component></register-component>
    </div>

{{--    <div id="router-view-container" class="d-none">--}}
{{--        <router-view></router-view>--}}
{{--    </div>--}}

{{--    <router-link to="/category">Go to category</router-link>--}}


    <div id="page-content-container">
        @yield('content')
    </div>
</div>

<!-- ========================= FOOTER ========================= -->
<footer class="section-footer bg-secondary">
    <div class="container">
        <section class="footer-top padding-top">
            <div class="row">
                <aside class="col-6 col-sm-6 col-md-3 white text-center">
                    <img height="96px" width="96px" class="border-bottom-white mb-3" src="{{asset('images/delivery.png')}}">
                    <h5 class="title">Express Delivery</h5>
                </aside>
                <aside class="col-6 col-sm-6 col-md-3 white text-center">
                    <img height="96px" width="96px" class="border-bottom-white mb-3" src="{{asset('images/guarantee.png')}}">
                    <h5 class="title">Guarantee</h5>
                </aside>
                <aside class="col-6 col-sm-6 col-md-3 white text-center">
                    <img height="96px" width="96px" class="border-bottom-white mb-3" src="{{asset('images/support.png')}}">
                    <h5 class="title">Support</h5>
                </aside>
                <aside class="col-6 col-sm-6 col-md-3 white text-center">
                    <img height="96px" width="96px" class="border-bottom-white mb-3" src="{{asset('images/payment.png')}}">
                    <h5 class="title">Online Payment</h5>
                </aside>
            </div> <!-- row.// -->
            <br>
        </section>
        <section class="footer-bottom row border-top-white">
            <div class="col-sm-6">
                <p class="text-white-50"> Designed by Koorosh</p>
            </div>
            <div class="col-sm-6">
                <p class="text-md-right text-white-50">
                    Copyright &copy  2019<br>
                </p>
            </div>
        </section> <!-- //footer-top -->
    </div><!-- //container -->
</footer>
<!-- ========================= FOOTER END // ========================= -->
<script src="/js/app.js" type="text/javascript"></script>
<script>
    function RegisterUser(){
        Fire.$emit('RegisterUserEvent');
        $('#register-container').removeClass('d-none');
        //$('#page-content-container').addClass('d-none');
        $('#formdropdown').dropdown("toggle");
    }

    function getQueryValue() {
        return $('#searchQuery').val();
    }

    function SearchProduct(){
        //TODO: check for empty intput
        let query = $('#searchQuery').val();

        if(query != '') {
            CategoryRedirect(query);
        }
        else{
            toast.fire({
                type: 'warning',
                title: 'Please fill the search box first'
            });
        }
    }

    function CategoryRedirect(query)
    {
        app.SearchProduct(query);
        window.location = '{{url("/category")}}';
    }

    function PreRedirect(e, query) {
        e.preventDefault();
        CategoryRedirect(query);
    }

    setInterval(function(){
        //console.log('in the interval...');
        $('#basketCounter').get(0).innerHTML = app.basketCount;
    }, 300);

    Fire.$on('BasketEvent',(ProductId,Quantity) => {

        let flag = false;
        let orders = app.GetOrders();
        orders.forEach(function (order) {
            if(ProductId === order.Id)
            {
                flag = true;
            }
        });

        if(!flag) {
            //$('#basketCounter').get(0).innerHTML = parseInt($('#basketCounter').get(0).innerHTML) + 1;
            app.SaveOrder(ProductId, Quantity);
        }
        else {
            toast.fire({
                type: 'warning',
                title: 'You have already added this product to your basket'
            });
        }
    });

</script>
@yield('scripts')
</body>
</html>