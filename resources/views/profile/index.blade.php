@extends('profile.master')

@section('content')
<div class="container">

    @foreach($userData as $uData)

        {{-- sekcja zdjęcia tał i profilówki   --}}
        <div class="col-md-12 profile-top-section">

                {{-- zdjęcie tła   --}}
                @if($uData->picBackground)
                    {{--  <img src="{{url('')}}/public/storage/{{$uData->name}}/{{($uData->picBackground)}}" alt="" class="img-responsive">                  --}}
                    <div v-for="profilePic in userInfo"><img :src="'{{url('')}}/public/storage/{{$uData->name}}/'+profilePic.picBackground" alt="" class="img-responsive"></div>                
                @else
                    <img src="{{url('')}}/public/img/default.jpg" alt="" class="img-responsive">                                
                @endif

                <nav class="navbar navbar-default" style="box-shadow: 0 8px 6px -6px #666;">
                    <div class="container-fluid">
                        <div class="center-navbar">
                            <ul class="nav navbar-nav">
                                <li><a href="" onclick="event.preventDefault();" @click="panelSwitch('posts')">Posty</a></li>
                                <li><a href="" onclick="event.preventDefault();" @click="panelSwitch('images')">Zdjęcia</a></li>
                                <li><a href="" onclick="event.preventDefault();" @click="panelSwitch('friends', {{$profileId}})">Znajomi</a></li>
                                @if( $uData->slug == Auth::user()->slug )<li><a href="" onclick="event.preventDefault();" @click="panelSwitch('info')">Informacje</a></li> @endif
                            </ul>
                        </div>
                        {{-- przycisk edycji   --}}
                        @if($uData->user_id == Auth::user()->id)
                            <a href="{{ url('editProfile') }}" class="btn btn-primary button-right" role="button" style="">Edytuj Profil</a>                                      
                        @endif

                        {{-- przyciski obserwuj usuń   --}}
                        @foreach($allUsers as $uList)
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

                                @if($uData->user_id == $uList->id)
                                    @if($check == '' && $check2 == '')
                                        <p class="pull-right"><a href="{{url('/addFriend')}}/{{$uList->id}}" class="btn btn-info button-right" >Dodaj do znajomych</a></p>                                             
                                    @else
                                        <p class="pull-right"><a href="{{url('/unfriend')}}/{{$uList->id}}" class="btn btn-warning button-right" >Usuń znajomego</a></p>
                                    @endif
                                @endif
                                    
                        @endforeach
                    </div>
                </nav>
                {{-- zdjęcie profilowe   --}}
                @if ($uData->user_id == Auth::user()->id)
                    <div class="profile-pic" v-for="profilePic in userInfo">
                        <img :src="'{{url('')}}/public/storage/{{$uData->name}}/'+profilePic.pic" alt="" class="img-rounded"/>                                                                
                    </div>
                @else
                    <div class="profile-pic" v-for="profilePic in userInfo">
                        <img src="{{url('')}}/public/storage/{{$uData->name}}/{{$uData->pic}}" alt="" class="img-rounded"/>                                                                
                    </div>                
                @endif

        </div>

        {{-- wyświetlanie zawartości   --}}

        <div class="row" id="profile-content">
            <div class="col-md-12" v-for="profileInfo in userInfo">
                {{-- lewy sidebar   --}}
            @if ($uData->user_id == Auth::user()->id)    
                <div class="col-md-3 col-md-offset-1">
                    <div class="profile-info">
                        <h1>
                        {{--  {{ucwords($uData->name)}}<br>  --}}
                        @{{profileInfo.name}}
                        <span>@{{profileInfo.plec}}</span>
                        </h1>
                        
                        <p style="color: black;">@{{profileInfo.omnie}}</p>
                        <p><span class="fa fa-map-marker"></span> @{{profileInfo.miasto}}, @{{profileInfo.kraj}}</p>
                        <p><span class="fa fa-external-link"></span> <a :href="'http://'+profileInfo.website" target="_blank"> @{{profileInfo.website}}</a></p>
                    </div>
                    {{--  <span>@ <a href="{{url('/profile')}}/{{$uList->slug}}">{{$uList->slug}}</a></span>  --}}
                </div>
            @else  
                <div class="col-md-3 col-md-offset-1">
                    <div class="profile-info">
                        <h1>
                        {{ucwords($uData->name)}}<br> 
                        <span>{{$uData->plec}}</span>
                        </h1>
                        
                        <p style="color: black;">{{$uData->omnie}}</p>
                        <p><span class="fa fa-map-marker"></span> {{$uData->miasto}}, {{$uData->kraj}}</p>
                        <p><span class="fa fa-external-link"></span> <a href="http://{{$uData->website}}" target="_blank"> {{$uData->website}}</a></p>
                    </div>
                    {{--  <span>@ <a href="{{url('/profile')}}/{{$uList->slug}}">{{$uList->slug}}</a></span>  --}}
                </div> 
            @endif         

                {{-- posty   --}}
                    @include('profile.profilePanels.posts')
                {{-- koniec posty   --}}
                

                {{-- zdjęica   --}}
                    @include('profile.profilePanels.images')
                {{-- koniec zdjęcia   --}}

                {{-- znajomi   --}}
                    {{--  @include('profile.profilePanels.friends')  --}}
                    <div class="col-md-8" style="padding: 0 30px;" v-if="panels.friends">
                        @include('profile.profilePanels.friends')
                    </div>
                {{-- koniec znajomi   --}}

                {{-- edycja informacji   --}}
                    @include('profile.profilePanels.info')
                {{-- koniec informacji   --}}

                {{-- prawy sidebar   --}}
                <div class="col-md-2" v-if="!panels.friends || !panels.info">zxc</div>
            </div>
        </div>
    @endforeach
</div>
@endsection
