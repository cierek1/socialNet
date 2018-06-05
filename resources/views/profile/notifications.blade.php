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

                @foreach($notka as $note)
                    <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;">

                        <ul>
                            <li>
                                <p><a href="{{url('/profile')}}/{{$note->slug}}" style="font-weight:bold; color:green;">{{ucwords($note->name)}}</a> -{{$note->note}}</p>
                            </li>
                        </ul>
                        
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
