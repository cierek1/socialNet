@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}">Home</a></li>
        <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profil</a></li>
        <li><a href="{{ url('editProfile') }}">Edytuj Profil</a></li>
    </ol>

    <div class="row">

         @include('profile.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->name}}</div>

                <div class="panel-body">
                        <div class="col-md-4">
                            <div class="thumbnail" align="center">
                                <h3>{{ucwords(Auth::user()->name)}}</h3>                            
                                <img src="{{url('')}}/public/img/{{(Auth::user()->pic)}}" alt="" width="120px" height="120px" />
                                <div class="caption">
                                    <p>{{$data->miasto}} - {{$data->kraj}}</p>
                                    <p><a href="{{url('/changePhoto')}}" class="btn btn-primary" role="button">Zmień zdjęcie</a></p>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-8">
                        <span class="label label-default">Zmień swoje dane profilowe</span>
                        <br>
                        <form action="{{url('/updateProfile')}}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="">
                                <span id="basic-addon1">Miasto</span>
                                <input type="text" name="miasto" class="form-control" placeholder="Miasto">
                            </div>

                            <div class="">
                                <span id="basic-addon1">Kraj</span>
                                <input type="text" name="kraj" class="form-control" placeholder="Kraj  ">
                            </div>
                            
                            
                            <div class="">
                                <span id="basic-addon1">O mnie</span>
                                <textarea type="text" name="omnie" class="form-control" rows="10"></textarea>
                            </div>
                                <br>
                            <input type="submit" class="btn btn-success pull-right">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
