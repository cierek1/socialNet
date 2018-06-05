@extends('profile.master')

@section('content')

<div class="col-md-12">
        <div class="col-md-3 left-sidebar">
            <h3 align="center">Użytkownicy <a href="{{ URL::previous() }}"><i class="fa fa-step-backward" aria-hidden="true"></i></a ></h3>
            
            <hr>

            @foreach($friends as $friend)
        
                <li @click="friendID({{$friend->id}})" class="row">

                    <div class="col-md-3 pull-left">
                        <img src="{{url('')}}/public/img/{{$friend->pic}}" alt="" style="width:50px; border-radius:100%;">                                          
                    </div>  

                    <div class="col-md-9 pull-left" style="margin-top:5px;">
                        <b>{{$friend->name}}</b><br>
                        <p><span>{{$friend->plec}}</span></p>
                    </div>
                             
                </li>
            @endforeach
        </div>
    
        <div class="col-md-7 mes_center">
            <h3 align="center">Wiadomość</h3>

            <div class="alert alert-success" role="alert" style="margin-top:45px;">@{{msg}}</div>
                
            <div  v-if="seen">
                <input type="text" v-model="friend_id">
                <textarea class="col-md-12 form-control" v-model="newMsgFrom"></textarea><br>
                <input type="button" value="Wyślij wiadomosc" @click="sendNewMsg()">
            </div>
            <hr>
        </div>
    
        <div class="col-md-2 right-sidebar">
            <h3 align="center">Left Sidebar</h3>
            <hr>
        </div>
</div>

@endsection