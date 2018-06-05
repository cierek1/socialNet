@extends('profile.master')

@section('content')

<div class="col-md-12">
        <div class="col-md-3 left-sidebar" style="margin-top:65px;">
            <h3 align="center">Użytkownicy <a href="{{url('/newMessages')}}" title="Wyślij nową wiadomość"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i></a ></h3>
            
            <hr>

            <ul v-for="privMsgs in privateMsgs">
                <li @click="messages(privMsgs.id)" class="row">

                    <div class="col-md-3 pull-left">
                        <img :src="'{{url('')}}/public/storage/'+privMsgs.name+'/' + privMsgs.pic" alt="" style="width:50px;" class="img-rounded">                                          
                    </div>  

                    <div class="col-md-9 pull-left" style="margin-top:5px;">
                        <b>@{{privMsgs.name}}</b><br>
                        <p><span>wiadomosc</span></p>
                    </div>
                             
                </li>
            </ul>

        </div>
    
        <div class="col-md-7 mes_center" style="margin-top:65px;">
            <h3 align="center">Wiadomość</h3>

            <div class="alert alert-success" role="alert" style="margin-top:45px;">Kliknij w ikonke użytkownika po lewej</div>
                
            <div v-for="singleMsgs in singleMsg">

                <div v-if="singleMsgs.user_from == <?php echo Auth::user()->id; ?>" class="entry-message">
                    <div class="col-md-12">
                        <img :src="'{{url('')}}/public/storage/'+singleMsgs.name+'/' + singleMsgs.pic" alt=""  class="pull-left">                                                                  
                        <div class="user-from">
                            @{{singleMsgs.msg}}
                        </div>
                    </div>
                </div>

                <div v-else class="entry-message">
                    <div class="col-md-12" >
                        <img :src="'{{url('')}}/public/storage/'+singleMsgs.name+'/' + singleMsgs.pic" alt=""  class="pull-right" >                                                                                                                                  
                        <div class="user-to">
                            @{{singleMsgs.msg}}
                        </div>
                    </div>
                </div>                
            </div>
            <hr>
            <input type="hidden" v-model="conID">
            <textarea name="" id="" placeholder="Wiadomość" class="form-control textMessage" v-model="newMsg" @keydown="inputHandler"></textarea>
        </div>
    
        <div class="col-md-2 right-sidebar" style="margin-top:65px;">
            <h3 align="center">Left Sidebar</h3>
            <hr>
        </div>
</div>

{{--  <div class="col-md-12">
    <input type="text" class="form-control" v-model="queryString" v-on:keyup="getSearch()">
    <p>@{{queryString}}</p>
    <div class="panel-footer" v-if="users.length">
        <ul class="list-group">
            <li class="list-group-item" v-for="user in users">
                <img :src="'{{url('')}}/public/img/' + user.pic" alt="" style="width:20px;margin:10px;" class="img-rounded">                            
                <a :href="'{{url('profile')}}/' +  user.slug" class="user_name"> @{{user.name}}</a>
            </li>
        </ul>
    </div>
</div>  --}}

@endsection