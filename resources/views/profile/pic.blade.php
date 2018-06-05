@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}">Home</a></li>
        <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a></li>
        <li><a href="{{ url('editProfile') }}">Edytuj Profil</a></li>
        <li><a href="#">Edytuj Zdjęcie</a></li>
    </ol>

    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->name}}</div>

                <div class="panel-body">
                    Profil dziala!
                    <br>
                    <img src="{{url('')}}/public/img/{{(Auth::user()->pic)}}" alt="" width="100px" height="100px" />
                    <br>
                    <hr>    
                    <form action="{{url('/uploadPhoto')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="file" name="pic" class="form-control">
                        <input type="submit" name="btn" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
