<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocialApp') }}</title>

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">   

    {{-- momentum   --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>     

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/welcome') }}">
                    {{-- {{ config('app.name', 'SocialApp') }} --}}SocialApp
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(Auth::check())
                        {{--  <li><a href="{{url('/findFriends')}}">Znajdź znajomych</a></li>  --}}
                        <li><a href="{{url('/requests')}}">Requests( 
                            {{App\Friendship::where('status',0)->where('user_requested',Auth::user()->id)->count()}}
                         )</a></li>            
                         <li>
                            {{-- wyszukiwarka --}}
                            <input type="text" class="form-control sf" placeholder="szukaj znajomych" v-model="queryString" v-on:keyup="getSearch()">
                                {{--  <p>@{{queryString}}</p>  --}}
                            <div class="search_form" v-if="users.length">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="user in users">
                                    <a :href="'{{url('profile')}}/' +  user.slug" class="">
                                        <img :src="'{{url('')}}/public/storage/'+user.name+'/' + user.pic" alt="" style=" " class="img-rounded">                            
                                        @{{user.name}}
                                        <p>@{{user.profile.miasto}}</p>
                                    </a>
                                    </li>
                                </ul>
                            </div>
                         </li>                                   
                    @endif

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><a href="{{url('/messages')}}">Wiadomości</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="{{url('')}}/public/storage/{{Auth::user()->name}}/{{(Auth::user()->pic)}}" alt="" width="30px" height="30px" class="img-circle"/>
                                <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a>
                                    <a href="{{ url('editProfile') }}">Edytuj Profil </a>                                    
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Wyloguj
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                        <li><a href="{{url('/friendsList')}}"><i class="fa fa-users fa-2x"></i></a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-globe fa-2x"><span class="badge" style="background:red;position:relative;top:-15px;left:-10px;">
                                    {{App\Notifications::where('status',1)->where('user_hero',Auth::user()->id)->count()}}
                                </span></i>
                            </a>

                            <?php
                                $notka = DB::table('users')
                                    ->leftJoin('notifications', 'users.id', 'notifications.user_logged')
                                    ->where('user_hero', Auth::user()->id)
                                    //->where('status', 1) //wyświetlamy nieprzeczytane powiadomienie
                                    ->orderBy('notifications.id','desc')
                                    ->get();
                             ?>

                            <ul class="dropdown-menu drop-fix-width" role="menu">
                                @foreach($notka as $item)
                                @if( $item->status == 1)
                                    <li style="background:#e4e9f2; padding:10px;">
                                @else
                                   <li style="padding:5px;"> 
                                @endif
                                
                                    <img src="{{url('')}}/public/storage/{{$item->name}}/{{$item->pic}}" alt="" width="30px" height="30px" class="img-circle"/>
                                    <a href="{{url('/notifications')}}/{{$item->id}}" style="float:right;background:none;"><b style="color:green">{{ucwords($item->name)}}</b> - {{$item->note}}</a>
                                    </li>                                    
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('public/js/profile.js') }}"></script>
</body>
</html>
