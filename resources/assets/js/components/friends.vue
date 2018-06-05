<template>
    <div >
        <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;">

            <div class="col-md-4" style="border:1px solid #ccc;" v-for="friends in friendsList">
                <div class="col-md-12 text-center" style="border: 1px solid #e9ebee;margin: 10px 0;">
                    <img :src="baseURL +'public/storage/'+friends.name +'/'+friends.pic" alt="" width="120px" height="120px"/>                            
                    <p><a :href="baseURL +'profile/'+ friends.slug">{{friends.name}}</a></p>
                    <a @click="unfriend(friends.id)" class="btn btn-default btn-sm">Usuń znajomego</a>
                    <!-- <a :href="baseURL +'unfriend/'+ friends.id" click="unfriend(friends.id)" class="btn btn-default btn-sm">Usuń znajomego</a>                     -->
                </div>
            </div>
                        
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
export default {
  data() {
      return {
        baseURL:'http://localhost/socialNetR/',
        title: 'Działa!',
        friendsList: [],
        img: 'http://localhost/socialNetR/profile/elojza-sqt'
      }
  },
  created() {
    axios.get(this.baseURL+'friendsList')
        .then(response => {
            // console.log(response); //wiadomosc jak bedzie dzialac
            this.friendsList = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
        })
        .catch(function (error) {
            console.log(error); //wiadomosc jak blad
        });
  },
  methods: {
      unfriend(id) {
        axios.get(this.baseURL+'unfriend/'+id)
            .then(response => {
                // console.log(response); //wiadomosc jak bedzie dzialac
                this.friendsList = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
            })
            .catch(function (error) {
                console.log(error); //wiadomosc jak blad
            });
      }
  }
}
</script>
