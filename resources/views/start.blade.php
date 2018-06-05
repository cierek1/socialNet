<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SocialApp</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}

        <!-- Styles -->
        <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/style.css') }}" rel="stylesheet"> 

        <style>

            body{
                background-image: url(./public/img/start.jpg);
                background-size: cover;                
            }

            {{-- css do menu --}}
            .contain{ margin: 25px auto; position: relative; width: 900px; }

            h1{ font-size:28px;}
            h1{ color:#563D64;}

            form:after {
                content: ".";
                display: block;
                height: 0;
                clear: both;
                visibility: hidden;
            }

            #content {
                background: #f9f9f9;
                background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
                background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
                -webkit-box-shadow: 0 1px 0 #fff inset;
                -moz-box-shadow: 0 1px 0 #fff inset;
                -ms-box-shadow: 0 1px 0 #fff inset;
                -o-box-shadow: 0 1px 0 #fff inset;
                box-shadow: 0 1px 0 #fff inset;
                border: 1px solid #c4c6ca;
                margin: 0 auto;
                padding: 25px 0 0;
                position: relative;
                text-align: center;
                text-shadow: 0 1px 0 #fff;
                width: 400px;
            }
            #content h1 {
                color: #7E7E7E;
                font: bold 25px Helvetica, Arial, sans-serif;
                letter-spacing: -0.05em;
                line-height: 20px;
                margin: 10px 0 30px;
            }
            #content h1:before,
            #content h1:after {
                content: "";
                height: 1px;
                position: absolute;
                top: 10px;
                width: 27%;
            }
            #content h1:after {
                background: rgb(126,126,126);
                background: -moz-linear-gradient(left,  rgba(126,126,126,1) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -o-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -ms-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                right: 0;
            }
            #content h1:before {
                background: rgb(126,126,126);
                background: -moz-linear-gradient(right,  rgba(126,126,126,1) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -o-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -ms-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                left: 0;
            }
            #content:after,
            #content:before {
                background: #f9f9f9;
                background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
                background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
                border: 1px solid #c4c6ca;
                content: "";
                display: block;
                height: 100%;
                left: -1px;
                position: absolute;
                width: 100%;
            }
            #content:after {
                -webkit-transform: rotate(2deg);
                -moz-transform: rotate(2deg);
                -ms-transform: rotate(2deg);
                -o-transform: rotate(2deg);
                transform: rotate(2deg);
                top: 0;
                z-index: -1;
            }
            #content:before {
                -webkit-transform: rotate(-3deg);
                -moz-transform: rotate(-3deg);
                -ms-transform: rotate(-3deg);
                -o-transform: rotate(-3deg);
                transform: rotate(-3deg);
                top: 0;
                z-index: -2;
            }
            #content form { margin: 0 20px; position: relative }
            #content form input[type="email"],
            #content form input[type="text"],
            #content form input[type="password"] {
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                -ms-border-radius: 3px;
                -o-border-radius: 3px;
                border-radius: 3px;
                -webkit-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -moz-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -ms-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -o-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -webkit-transition: all 0.5s ease;
                -moz-transition: all 0.5s ease;
                -ms-transition: all 0.5s ease;
                -o-transition: all 0.5s ease;
                transition: all 0.5s ease;
                background: #eae7e7 url(https://cssdeck.com/uploads/media/items/8/8bcLQqF.png) no-repeat;
                border: 1px solid #c8c8c8;
                color: #777;
                font: 13px Helvetica, Arial, sans-serif;
                margin: 0 0 10px;
                padding: 15px 10px 15px 40px;
                width: 80%;
            }
            #content form input[type="email"]:focus,
            #content form input[type="text"]:focus,
            #content form input[type="password"]:focus {
                -webkit-box-shadow: 0 0 2px #ed1c24 inset;
                -moz-box-shadow: 0 0 2px #ed1c24 inset;
                -ms-box-shadow: 0 0 2px #ed1c24 inset;
                -o-box-shadow: 0 0 2px #ed1c24 inset;
                box-shadow: 0 0 2px #ed1c24 inset;
                background-color: #fff;
                border: 1px solid #ed1c24;
                outline: none;
            }
            #username { background-position: 10px 10px !important }
            #password { background-position: 10px -53px !important }
            #content form input[type="submit"] {
                background: rgb(254,231,154);
                background: -moz-linear-gradient(top,  rgba(254,231,154,1) 0%, rgba(254,193,81,1) 100%);
                background: -webkit-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
                background: -o-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
                background: -ms-linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
                background: linear-gradient(top,  rgba(254,231,154,1) 0%,rgba(254,193,81,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fee79a', endColorstr='#fec151',GradientType=0 );
                -webkit-border-radius: 30px;
                -moz-border-radius: 30px;
                -ms-border-radius: 30px;
                -o-border-radius: 30px;
                border-radius: 30px;
                -webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                -moz-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                -ms-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                -o-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                border: 1px solid #D69E31;
                color: #85592e;
                cursor: pointer;
                float: left;
                font: bold 15px Helvetica, Arial, sans-serif;
                height: 35px;
                /*margin: 20px 0 35px 15px;*/
                position: relative;
                text-shadow: 0 1px 0 rgba(255,255,255,0.5);
                width: 100px;
                margin-left: 45px;
                margin-top: -15px;
            }
            #content form input[type="submit"]:hover {
                background: rgb(254,193,81);
                background: -moz-linear-gradient(top,  rgba(254,193,81,1) 0%, rgba(254,231,154,1) 100%);
                background: -webkit-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
                background: -o-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
                background: -ms-linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
                background: linear-gradient(top,  rgba(254,193,81,1) 0%,rgba(254,231,154,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fec151', endColorstr='#fee79a',GradientType=0 );
            }
            #content form div a {
                color: #004a80;
                float: right;
                font-size: 12px;
                /*margin: 30px 15px 0 0;*/
                margin: 15px 0px 0 45px;
                text-decoration: underline;
                float: left;
            }

            .remember{
                float: right;
                margin-top: 30px;
                margin-right: 60px;
            }

        </style>

    </head>
    <body>

    	<div class="contain">
    	    <section id="content">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <h1>Zaloguj się</h1>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">E-mail</label>
                        {{-- <input type="text" placeholder="Username" required="" id="username" /> --}}
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>                        
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Haslo</label>
                        {{-- <input type="password" placeholder="Password" required="" id="password" /> --}}
                        <input id="password" type="password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>
                    
                    <div>
                        <input type="submit" value="Loguj" />
                            <label class="remember">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="font-size:12px;"> Zapamiętaj
                            </label>
                        <a href="{{ route('password.request') }}">Zapomnialeś hasla?</a>
                    </div>
                </form><!-- form -->
    	    </section><!-- content -->
    	</div>

        <div class="contain">
    	        <section id="content">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <h1>Rejestracja</h1>
                    <div class="form-group{{ $errors->has('plec') ? ' has-error' : '' }}">
                        <label for="plec" style="float: left;margin-left: 18px;">Plec</label>
                        <select name="plec" id="" class="col-md-4" style="margin-left: 15px">
                            <option value="mężczyzna">Mężczyzna</option>
                            <option value="kobieta">Kobieta</option>
                        </select>

                        <div class="col-md-6">
                            @if ($errors->has('plec'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('plec') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Imie</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        {{-- <input type="password" placeholder="Password" required="" id="password" /> --}}
                        <input id="email" type="email" name="email" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Haslo</label>
                        {{-- <input type="password" placeholder="Password" required="" id="password" /> --}}
                        <input id="password" type="password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" style="margin-left: -9px;">Potwierdź haslo</label>
                        <input id="password-confirm" type="password" name="password_confirmation" style="width: 247px;" required>
                    </div>
                    
                    <div>
                        <input type="submit" value="Rejestruj" />
                    </div>
                </form><!-- form -->
    	    </section><!-- content -->
    	</div>

    </body>
</html>
