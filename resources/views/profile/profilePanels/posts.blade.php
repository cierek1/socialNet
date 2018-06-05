                <div class="col-sm-6" v-if="panels.posts">
                    {{-- sekcja dodawania postu   --}}
                    @if($uData->user_id == Auth::user()->id)
                        <div class="posts_div">
    
                                    <div class="head_har">
                                        Dodaj nowy post
                                    </div>
    
                                    <div style="background-color:#fff">
                                        <div class="row">
    
                                            <div class="col-md-1 pull-left">
                                                <img src="{{url('')}}/public/storage/{{Auth::user()->name}}/{{(Auth::user()->pic)}}" alt="" style="width:35px;height:35px;margin:10px;" class="img-circle">                                                                
                                            </div>
    
                                            <div class="col-md-11 pull-right">
                                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent = "addPost">
                                                    <textarea v-model="content" id="postText" class="form-control" placeholder="Wstaw nowy post"></textarea>
                                                    <button class="btn btn-info btn-sm pull-right" type="submit" id="postBtn" style="margin:10px;">Dodaj post</button>
                                                </form>
                                            </div>
    
                                        </div>
                                    </div>
    
                        </div>
                    @endif

                    {{-- sekcja wyświetlania postu   --}}
                    <div class="posts_div">
                        {{-- <div class="head_har">Posty</div> --}}
        
                        {{-- poczatek petli post   --}}
                            <div v-for="post,key in posts">
                                <div class="col-md-12 col-sm-12 col-xs-12 all_posts" v-if="post.user.slug == '{{$slug}}'">
                            
                                    <div class="col-md-2 pull-left">
                                        <img :src="'{{url('')}}/public/storage/'+post.user.name+'/' + post.user.pic" alt="" class="img-circle post_img">                            
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p><a :href="'{{url('profile')}}/' +  post.user.slug" class="post_user_name"> @{{post.user.name}}</a> <br>
                                                    <span style="color:#AAADB3">  @{{ post.created_at | myOwnTime}}
                                                    <i class="fa fa-globe"></i></span>
                                                </p>
                                            </div>
                                            <div class="col-md-1 pull-right">
                                                <a href="#" data-toggle="dropdown" aria-haspopup="true"><i class="fa fa-gears" aria-hidden="true"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li v-if="post.user_id == '{{Auth::user()->id}}'"><a href="#" data-toggle="modal" data-target="#myModal" @click="showUpdatePost(post.id)">Edytuj</a></li>
                                                    <li><a href="#">Another action</a></li>
                                                    <li><a href="#">Something else here</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li v-if="post.user_id == '{{Auth::user()->id}}'"><a @click="deletePost(post.id)"><i class="fa fa-trash-o" aria-hidden="true"> - Usuń</i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- wyświetlanie zawartości postu   --}}
                                    <p class="col-md-12" style="color:#000; margin-top:15px; font-family:inherit; margin-left:0px;" >
                                        @{{post.content}}
                                                    
                                        <div class="col-md-12" id="article">
                                            <a :href="post.url" target="_blank">
                                                <img :src="post.img" class="img-responsive" alt="" width="620px;">
                                                <p>@{{post.title}}</p>
                                            <span class="description">@{{post.description}}</span>
                                            <br><br>
                                            <span class="host">@{{post.host}}</span></a>
                                        </div>
                                    </p>
            
                                                
                                    {{-- sekcja lajków --}}
                                    <div class="col-md-12" style="padding: 10px;" >
                                        <hr>
                                        <div class="col-md-4">
                                            @if(Auth::check())
                
                                            {{--  <div v-for="like in likes">
                                                <div v-if="post.id == like.post_id && like.user_id == '{{Auth::user()->id}}'">
                                                    <p class="likeBtn" style="cursor:pointer;"  @click="likePost(post.id)">
                                                        <i class="fa fa-thumbs-up"> Lubie to</i>
                                                    </p>
                                                </div>
                                            </div>  --}}
                                            <p v-if="post.likes.length !=0" @click="deleteLike(post.id)" class="likeBtn">
                                                <i class="fa fa-thumbs-up" style="cursor:pointer;">@{{post.likes.length}}</i>
                                            </p>
                                            <p v-else @click="likePost(post.id)">
                                                <i class="fa fa-thumbs-up" style="cursor:pointer;"> Lubie to</i>
                                            </p>
                                            @endif
                                        </div>
            
                                        <div class="col-md-4">
                                            <input type="hidden" v-model="id">
                                            <p class="showComment" @click="showComment(key)">Komentarze</p>
                                        </div>
                                    </div>
            
                                </div>
            
                                <div class="commentBox" v-show="isShow[key]" lazy style="width:91%;margin:0 0 10px 0;">
            
                                    <div class="comment_form">
                                        <textarea class="form-control" v-model="commentData[key]"></textarea>
                                        <button class="btn btn-success" @click="addComment(post,key)">Wyślij</button>
                                    </div>
            
                                    <ul v-for="comment in post.comments">
                                        <li>@{{comment.comment}}</li>
                                    </ul>
                                </div>
            
                            </div>
                        {{-- koniec petli post   --}}
                    </div>
                </div> 

                {{-- Modal z edycją posta   --}}
                <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edytuj Post</h4>
                            </div>
                            <div class="modal-body" >
                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent = "">
                                     <textarea id="postText" class="form-control" placeholder="Wstaw nowy post" v-model="singlePost.content"></textarea> 
                                </form>                                        
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="updatePost(singlePost.id, singlePost.content)" data-dismiss="modal">Zapisz</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->