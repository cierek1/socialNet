@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}">Home</a></li>
        <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a></li>
        <li><a href="">Requests</a></li>
    </ol>

    <div class="row">

         @include('profile.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->name}}</div>
                
                <div class="panel-body">

                @if(session()->has('msg'))
                    <p class="alert alert-success">{{session()->get('msg')}}</p>
                @endif

                @foreach($friendRequests as $uList)
                    <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;">

                        <div class="col-md-2 pull-left">
                            <img src="{{url('')}}/public/img/{{$uList->pic}}" alt="" width="80px" height="80px"/>                            
                        </div>

                        <div class="col-md-7 pull-left">

                            <h3 style="margin:0px;">{{$uList->name}}</h3>
                            <p>{{$uList->plec}}</p>
                            <p>{{$uList->email}}</p>
                            
                        </div>

                        <div class="col-md-3 pull-left">

                            <p><a href="{{url('/accept')}}/{{$uList->name}}/{{$uList->id}}" class="btn btn-info btn-sm">Potwierdź</a></p>                                                                             

                            <p><a href="{{url('/remove')}}/{{$uList->id}}" class="btn btn-default btn-sm">Odrzuć</a></p>                                                                             
                            
                        </div>
                        
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
