<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SocialApp</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}

        <!-- Styles -->
        <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">        
 

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

         <style>
            html, body {
                background-color: #ddd;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                padding-top: 35px;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .head_har{
                background-color: #f6f7f9;
                border-bottom: 1xp solid #dddfe2;
                border-radius: 2px 2px 0 0;
                font-weight: bold;
                padding: 8px 6px; 
            }

            .left-sidebar, .right-sidebar{
                background-color: #fff;
                min-height:600px;
            }

            .posts_div{
                margin-bottom: 10px;
            }

            .post_div h3{
                margin-top:4px !important;
            }

            #postText{
                border: 1px solid #8eb4cb;
                height: 120px;
            }

            .dropdown-menu a{ cursor: pointer;}

            .post_user_name{
                font-size:18px;
                font-weight:bold;
                text-transform:capitalize; 
                margin:3px
                
            }
            .all_posts{
                background-color:#fff; padding:15px;
                margin-bottom:15px; border-radius:5px;
                -webkit-box-shadow: 0 8px 6px -6px #666;
  	            -moz-box-shadow: 0 8px 6px -6px #666;
  	             box-shadow: 0 8px 6px -6px #666;
            }

            #article{
                cursor: pointer;
            }

            #article a{
                text-decoration: none;
                color: black;
            }

            #article p {
                text-transform: capitalize;
                font-weight: 600;
                
                margin-bottom: 2px;
                margin-top: 5px;
            }

            #article .description{
                font-size: 11px;
                font-weight: 600;
            }

            #article .host{
                margin-top: -13px !important;
                position: absolute;
                text-transform: uppercase;
                color: gray;
            }

            .likeBtn{
                color: rgb(88, 144, 255);
                font-weight: 900;
            }

            .commentBox{
                background-color:#ddd; 
                padding:10px; 
                width:99%; margin:0 auto;
                background-color:#F6F7F9;  
                padding:10px;
                margin-bottom:10px;
                /*display: none;*/
            }
            .commentBox li { list-style:none; padding:10px; border-bottom:1px solid #ddd}
            .comment_form{ padding:10px; margin-bottom:10px}

            .showComment{
                cursor: pointer;
            }

        </style> 
    </head>
    <body>
    

        {{--  @include('profile.nav')  --}}

        <div id="wApp">
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
                                    {{App\Friendship::where('status',0)->where('user_requested',Auth::user()->id)->count()}})</a>
                                </li>   
                                <li>
                                    {{-- wyszukiwarka --}}
                                    <input type="text" class="form-control sf" placeholder="szukaj znajomych" v-model="queryString" v-on:keyup="getSearch()">
                                        {{--  <p>@{{queryString}}</p>  --}}
                                    <div class="search_form" v-if="users.length">      
                                            <ul class="list-group">
                                                <li class="list-group-item" v-for="user in users">
                                                <a :href="'{{url('profile')}}/' +  user.slug" class="user_name">
                                                    <img :src="'{{url('')}}/public/storage/'+user.name+'/' + user.pic" alt="" style="" class="img-rounded">                            
                                                     
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
                                    
                                    <ul class="dropdown-menu" role="menu" >
                                        <li>
                                            <a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a>
                                            <a href="{{ url('editProfile') }}">Edytuj Profil </a>                                    
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">
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
    
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" >
    
                        {{-- left sidebar   --}}
                        <div class="col-md-3 hidden-sm hidden-xs left-sidebar">
                            <h3 align="center">Left Sidebar</h3>
                            <hr>
                            {{-- modal z edycją posta   --}}
                            <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Edytuj Post</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <form method="post" enctype="multipart/form-data" v-on:submit.prevent = "">
                                                <textarea id="postText" class="form-control" placeholder="Wstaw nowy post" v-model="singlePost.content"></textarea>
                                            </form>                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="updatePost(singlePost.id, singlePost.content)" data-dismiss="modal">Zapisz</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                        </div>
    
                        {{-- post area   --}}
                        <div class="col-md-7 col-sm-12 col-xs-1 center-con">
    
                            {{-- sekcja dodawania postu   --}}
                            @if(Auth::check())
                                <div class="posts_div">
    
                                    <div class="head_har">
                                        @{{msg}}
                                    </div>
    
                                    <div style="background-color:#fff">
                                        <div class="row">
    
                                            <div class="col-md-1 pull-left">
                                                <img src="{{url('')}}/public/storage/{{Auth::user()->name}}/{{(Auth::user()->pic)}}" alt="" style="width:40px;height:40px;margin:10px;" class="img-circle">                                                                
                                            </div>
    
                                            <div class="col-md-11 pull-right">
                                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent = "addPost">
                                                    <textarea v-model="content" id="postText" class="form-control" placeholder="Wstaw nowy post"></textarea>
                                                    <div class="postImages" v-if="image">
                                                        <img :src="image" alt="" style="" />
                                                        <p class="closeImg" @click="removeImg()"><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></p>
                                                    </div>
                                                    <button class="btn btn-info btn-sm pull-right" type="submit" id="postBtn" style="margin:10px;">Dodaj post</button>
                                                </form>
                                                <br><br>
                                                {{-- Upload zdjęcia do postu   --}}
                                                <div >
                                                    <input ref="refImg" type="file" @change="onFileChange" id="file" class="inputfile">
                                                    <label for="file" title="Dodaj zdjęcie" class="fileLabel"><i class="fa fa-picture-o fa-2x" aria-hidden="true"></i></label>
                                                </div>
                                                
                                                {{--  <button @click="uploadImg()" class="btn btn-success">Upload</button>                                                 --}}
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            @endif
                            
                            {{-- sekcja wyświetlania postu   --}}
                            <div class="posts_div">
                                {{-- <div class="head_har">Posty</div> --}}
    
                                <div v-for="post,key in posts">
                                    <div class="col-md-12 col-sm-12 col-xs-12 all_posts" >
                    
                                        <div class="col-md-2 pull-left">
                                            <img :src="'{{url('')}}/public/storage/'+post.user.name+'/' + post.user.pic" alt=""  class="img-circle post_img">                            
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <p style="margin-left: -54px;"><a :href="'{{url('profile')}}/' +  post.user.slug" class="post_user_name"> @{{post.user.name}}</a> <br>
                                                        <span style="color:#AAADB3">  @{{ post.created_at | myOwnTime}}
                                                        <i class="fa fa-globe"></i></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-1 pull-right">
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true"><i class="fa fa-gears" aria-hidden="true"></i></a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                        <li v-if="post.user_id == '{{Auth::user()->id}}'"><a href="#" data-toggle="modal" data-target="#myModal" @click="showUpdatePost(post.id)">Edytuj</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                        <li role="separator" class="divider"></li>
                                                        <li v-if="post.user_id == '{{Auth::user()->id}}'"><a @click="deletePost(post.id)"><i class="fa fa-trash-o" aria-hidden="true"> - Usuń</i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- wyświetlanie zawartości postu   --}}
                                        <p class="col-md-12" style="color:#000; margin-top:15px; font-family:inherit" >
                                            @{{post.content}}
                                            
                                            <div class="col-md-12" id="article">
                                                <a :href="post.url" target="_blank">
                                                    <img :src="post.img" class="img-responsive" alt="" width="620px;">
                                                    <p>@{{post.title}}</p>
                                                <span class="description">@{{post.description}}</span>
                                                <br><br>
                                                <span class="host">@{{post.host}}</span></a>
                                            </div>
                                        </p>
    
                                        
                                        {{-- sekcja lajków --}}
                                        <div class="col-md-12" style="padding: 10px;" >
                                            <hr>
                                           <div class="col-md-4">
                                                @if(Auth::check())
        
                                                {{--  <div v-for="like in likes">
                                                    <div v-if="post.id == like.post_id && like.user_id == '{{Auth::user()->id}}'">
                                                        <p class="likeBtn" style="cursor:pointer;"  @click="likePost(post.id)">
                                                            <i class="fa fa-thumbs-up"> Lubie to</i>
                                                        </p>
                                                    </div>
                                                </div>  --}}
                                                
                                                <p v-if="post.likes.length == 0" @click="likePost(post.id)">
                                                   <i class="fa fa-thumbs-up" style="cursor:pointer;"> Lubie to</i>                                                    
                                                </p>
       
                                                <p v-else class="likeBtn">
                                                    <p v-for="like in post.likes" class="likeBtn">
                                                        <span v-if="like.user_id == '{{Auth::user()->id}}'" @click="deleteLike(post.id)">
                                                            <i class="fa fa-thumbs-up" style="cursor:pointer;">@{{post.likes.length}}</i>
                                                        </span>
                                                        <span v-else @click="likePost(post.id)">
                                                            <i class="fa fa-thumbs-up" style="cursor:pointer;">@{{post.likes.length}}</i>
                                                        </span>
                                                    </p>                                                
                                                </p> 

                                                @endif
                                           </div>
    
                                            <div class="col-md-4">
                                                <input type="hidden" v-model="id">
                                                <p class="showComment" @click="showComment(key)">Komentarze</p>
                                            </div>
                                        </div>
    
                                    </div>
    
                                    <div class="commentBox" v-if="isShow[key]">
    
                                        <div class="comment_form">
                                            <textarea class="form-control" v-model="commentData[key]"></textarea>
                                            <button class="btn btn-success" @click="addComment(post,key)">Wyślij</button>
                                        </div>
    
                                        <ul v-for="comment in post.comments">
                                            <li>@{{comment.comment}}</li>
                                        </ul>
                                    </div>
    
                                </div>
    
                            </div>
    
                        </div>
    
                        {{-- right sidebar   --}}
                        <div class="col-md-2 hidden-sm hidden-xs right-sidebar">
                            <h3 align="center">Right Sidebar</h3>
                            <hr>
                            
                            @if (Auth::check())
                                @foreach (App\user::all() as $user)

                                    @foreach ($user->rFrends(Auth::user()->id) as $friends)

                                        @if ($user->name == $friends->name)
                                            @if ($user->isOnline())
                                                {{$user->name}}
                                            @endif
                                        @endif
                                        
                                    @endforeach

                                @endforeach
                            @endif

                        </div>
    
                    </div>
                </div>
            </div>
    
            {{-- <div class="flex-center position-ref full-height">
                {{-- @if (Route::has('login'))
                    <div class="top-right links">
                        @if (Auth::check())
                            <a href="{{ url('/home') }}">Dashboard</a>
                            <a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a>
    
                        @else
                            <a href="{{ url('/login') }}">Login</a>
                            <a href="{{ url('/register') }}">Register</a>
                        @endif
                    </div>
                @endif --}}
            </div> --}}
        </div>

        <script src='public/js/app.js'></script>
        
        
        <script>
            $(document).ready(function(){
                 /*$('#showComment').on('click', function(){
                    $('.head_har').hide();         
                    /*$('#sendPost').animate({ 'zoom': currentZoom += 5 }, 'slow');           
                }); */

            });
        </script>

    </body>
</html>
