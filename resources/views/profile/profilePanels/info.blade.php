<div class="col-md-8" v-if="panels.info">
          
    {{-- Upload background-pic   --}}
    <div class="col-md-12 pick-background-min">
                {{-- zdjęcie tła   --}}
                @if($uData->picBackground)
                    <div v-if="!background_pic">
                        {{--  <img src="{{url('')}}/public/storage/{{$uData->name}}/{{($uData->picBackground)}}" alt="" class="img-responsive pick-background-img">  --}}
                        <img :src="'{{url('')}}/public/storage/{{$uData->name}}/'+userInfo[0].picBackground" alt="" class="img-responsive pick-background-img">
                    </div> 
                    <div v-else>
                        <img :src="background_pic" alt="" class="pick-background-img" />
                        <p class="closeImg" @click="removeImg()"><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></p>
                    </div>
                    <div class="pick-background-btn">
                        <input ref="refImg2" type="file" @change="backgroundPic" id="file2" class="inputfile">
                        <label for="file2" title="Dodaj zdjęcie" class="fileLabel"><span class="btn btn-warning">Zmień zdjęcie</span></label>
                    </div>                                   
                @else
                    <img src="{{url('')}}/public/img/default.jpg" alt="" class="img-responsive" style="height:180px;">                                
                @endif
                <hr>
            </div>
    
            <div class="panel panel-default">
    
                <div class="panel-body">
                        <div class="col-md-4">
                            <div class="thumbnail" align="center">
                                {{--  <h3>{{ucwords(Auth::user()->name)}}</h3>                              --}}
                                <div v-if="!image">
                                    <img :src="'{{url('')}}/public/storage/{{$uData->name}}/'+userInfo[0].pic" alt="" width="120px" height="120px" />
                                </div>
                                <div v-else>
                                    <img :src="image" alt="" width="120px" height="120px" />
                                    <p class="" @click="removeImg()" style="cursor:pointer;"><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></p>
                                </div>
                                <div class="caption">
                                    {{--  <p>{{$data->miasto}} - {{$data->kraj}}</p>  --}}
                                    {{--  <form action="{{url('/uploadPhoto')}}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="file" name="pic" class="form-control">
                                        <input type="submit" name="btn" class="btn btn-success">
                                    </form>  --}}
    
                                    {{-- Upload zdjęcia profilowego   --}}
                                    <div>
                                        <input ref="refImg" type="file" @change="onFileChange" id="file" class="inputfile">
                                        <label for="file" title="Dodaj zdjęcie" class="fileLabel"><span class="btn btn-default">Zmień zdjęcie</span></label>
                                    </div>
    
                                </div>
                            </div>
                        </div>
    
                    <div class="col-md-8">
    
                        <span class="label label-default">Zmień swoje dane profilowe</span>
                        <br>
                        <form action="{{url('/updateProfile')}}" method="post" v-on:submit.prevent = "updateProfile">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
    
                            <div class="">
                                <span id="basic-addon1">Miasto</span>
                                <input type="text" name="miasto" class="form-control" placeholder="Miasto" v-model="userInfo[0].miasto">
                            </div>
    
                            <div class="">
                                <span id="basic-addon1">Kraj</span>
                                <input type="text" name="kraj" class="form-control" placeholder="Kraj" v-model="userInfo[0].kraj">
                            </div>
    
                            <div class="">
                                <span id="basic-addon1">Strona WWW</span>
                                <input type="text" name="website" class="form-control" placeholder="Strona" v-model="userInfo[0].website">
                            </div>
                            
                            {{--  <div class="">
                                <span id="basic-addon1">Strona WWW</span>
                                <input type="text" name="www" class="form-control" placeholder="Strona WWW  ">
                            </div>  --}}
    
                            <div class="">
                                <span id="basic-addon1">O mnie</span>
                                <textarea type="text" name="omnie" class="form-control" rows="3" v-model="userInfo[0].omnie"></textarea>
                            </div>
                                <br>
                            <button type="submit" class="btn btn-success pull-right">Zapisz</button>
                        </form>
                    </div>
                </div>
            </div>


</div>