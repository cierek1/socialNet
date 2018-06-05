@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}">Home</a></li>
        <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a></li>
        <li><a href="">Znajdź znajomych</a></li>
    </ol>

    <div class="row">

         @include('profile.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->name}}</div>

                <div class="panel-body">
                        <div class="col-md-4" align="center">
                            @foreach($allUsers as $uList)
                                <div class="thumbnail">
                                    <h3><a href="{{url('/profile')}}/{{$uList->slug}}">{{$uList->name}}</a></h3>
                                    <a href="#">
                                        <img src="{{url('')}}/public/img/{{$uList->pic}}" alt="" width="30px" height="30px" class="img-circle"/>
                                    </a>
                                    <div class="caption">
                                        <p>{{$uList->miasto}} - {{$uList->kraj}}</p>
                                        <?php
                                         $check = DB::table('friendships')
                                                ->where('user_requested', '=', $uList->id )
                                                ->where('requester', '=', Auth::user()->id )
                                                ->first();

                                        $check2 = DB::table('friendships')
                                            ->where('user_requested', '=', Auth::user()->id)
                                            ->where('requester', '=', $uList->id)
                                            ->first();
                                         
                                         ?>
                                         @if($check == ''&& $check2 == '')
                                            <p><a href="{{url('/addFriend')}}/{{$uList->id}}" class="btn btn-info">Dodaj do znajomych</a></p>                                             
                                         @else
                                             <p>Zapytanie zostalo wyslane</p>
                                         @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    <div class="col-md-8">
                        Lista znjomych
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
