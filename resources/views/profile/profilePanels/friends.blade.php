        <div class="row" style="margin-bottom:15px;">

            <div class="col-md-4" style="border:1px solid #ccc; background-color:white;" v-for="friends in friendsList">
                <div class="col-md-12 text-center" style="margin: 10px 0;">
                    <img :src="'{{url('')}}/public/storage/'+friends.name +'/'+friends.pic" alt="" width="120px" height="120px"/>                            
                    <p><a :href="baseURL +'profile/'+ friends.slug" style="font-size: 16px;font-weight: 600; text-transform: capitalize;">@{{friends.name}}</a></p>
                    @if( Auth::user()->id == $profileId )
                        <a @click="unfriend(friends.id)" class="btn btn-default btn-sm">Usuń znajomego</a>                        
                    @endif
                    <!-- <a :href="baseURL +'unfriend/'+ friends.id" click="unfriend(friends.id)" class="btn btn-default btn-sm">Usuń znajomego</a>                     -->
                </div>
            </div>
                        
        </div>