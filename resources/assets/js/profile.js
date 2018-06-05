
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

let friends = require('./components/friends.vue');

const app = new Vue({
    el: '#app',
    components: {friends},
    data:{
        msg: 'Kliknij użytkownika po lewej stronie',
        baseURL:'http://localhost/socialNetR/',
        content:'',
        privateMsgs:[],
        singleMsg:[],
        newMsg: '',
        conID: '',
        friend_id: '',
        seen: false,
        newMsgFrom: '',
        queryString: '',
        users: [],
        posts: [],
        isShow: false,
        commentData:{},
        id: '',
        isShow: {},
        panels: {"posts": true, "images": false, "friends": false, "info": false },
        friendsList: {},
        userInfo: {},
        image: '',
        background_pic: '',
        singlePost: {},
    },

    ready: function(){
        this.created();
    },

    created(){
        axios.get(this.baseURL+'getMessages')
                .then(response => {
                    console.log(response.data); //wiadomosc jak bedzie dzialac
                    app.privateMsgs = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });

        axios.get(this.baseURL+'posts')
                .then(response => {
                    // console.log(response); //wiadomosc jak bedzie dzialac
                    this.posts = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });     
                
        //dane do edycji profilu
        axios.get(this.baseURL+'getProfileData')
                .then(response => {
                    console.log(response.data); //
                    this.userInfo = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });

            //filtr czasu, momentumjs
            Vue.filter('myOwnTime', function(value){
                return moment(value).fromNow();
            });
    },

    methods:{

        messages: function(id){
            axios.get(this.baseURL+'getMessages/'+id)
                .then(response => {
                    console.log(response.data); //wiadomosc jak bedzie dzialac
                    app.singleMsg = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                    app.conID = response.data[0].conversation_id;
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },

        inputHandler(e){
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                this.sendMsg();

            }
        },

        sendMsg(){
            if (this.newMsg) {
                axios.post(this.baseURL+'sendMessage', {
                conID: this.conID,
                newMsg: this.newMsg
                })
                .then(function (response) {
                    console.log(response.data); //wiadomosc jak bedzie dzialac
                    app.singleMsg = response.data;
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });

                this.newMsg = null;
            }
        },

        friendID: function(id){
            app.friend_id = id;
            app.seen = true;
        },

        sendNewMsg(){
            
            axios.post(this.baseURL+'sendNewMessage', {
                friend_id: this.friend_id,
                newMsgFrom: this.newMsgFrom
                })
                .then(function (response) {
                    console.log(response.data); //wiadomosc jak bedzie dzialac
                    window.location.replace('http://localhost/socialNetR/messages');
                    app.msg = 'Wiadomość wyslana pomyślnie';
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },

        getSearch(){
            this.users = [];
            // this.queryString = app.queryString;
            axios.post(this.baseURL+'search', {
                queryString: this.queryString
            })
            .then(response => {
                console.log(response.data); //wiadomosc jak bedzie dzialac

                app.users = response.data;
            })
        },
        
        addPost(){

            console.log(this.content);

            axios.post(this.baseURL+'addPost', {
                content: this.content
                })
                .then(function (response) {
                    // console.log(response); //wiadomosc jak bedzie dzialac

                    app.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
            this.content = '';
        },

        showUpdatePost(id) {
            axios.get(this.baseURL+'singlePost/' + id)
                .then(response => {
                    // console.log(response); //wiadomosc jak bedzie dzialac
                    var singPostId = response.data.id;
                    var singleContent = response.data.content;
                    var singleUrl = response.data.url;
                    var mssg = '';

                    if (singleUrl == null) {
                        mssg = response.data.content;
                    }else{
                        mssg = response.data.content+ '\n' + '\n' + response.data.url;
                    }                 
                    this.singlePost = {
                        'id':singPostId,
                        'content':mssg
                    }; 
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },

        updatePost(id, content){
            // console.log(id);
            // console.log(content);
            
            axios.post(this.baseURL+'updatePost', {
                content: content,
                id: id
                })
                .then(function (response) {
                    // console.log(response); //wiadomosc jak bedzie dzialac

                    app.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },
        
        deletePost(id){
            axios.get(this.baseURL+'deletePost/' + id)
                .then(response => {
                    // console.log(response); //wiadomosc jak bedzie dzialac
                    this.posts = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },

        likePost(id){
            axios.get(this.baseURL+'likePost/' + id)
                .then(response => {
                    // console.log(response); //wiadomosc jak bedzie dzialac
                    this.posts = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },

        deleteLike(id){
            axios.get(this.baseURL+'deleteLike/' + id)
                .then(response => {
                    this.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
        },

        addComment(post,key){
            axios.post(this.baseURL+'addComment', {
                comment: this.commentData[key],
                id: post.id
                })
                .then(function (response) {
                    // console.log(response); //wiadomosc jak bedzie dzialac

                    app.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });

            this.commentData = '';
        },
        showComment(key){
            this.id = key;
            this.isShow[this.id] = !this.isShow[this.id];
            this.id = '';
            console.log(this.isShow[this.id]);
        },

        panelSwitch(key, id) {
            switch (key) {
                case 'images':
                        this.panels = {"posts": false, "images": true, "friends": false, "info": false };
                    break;
                case 'friends':
                        this.panels = {"posts": false, "images": false, "friends": true, "info": false };

                        axios.get(this.baseURL+'friendsList/' + id)
                            .then(response => {
                                // console.log(response); //wiadomosc jak bedzie dzialac
                                this.friendsList = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                            })
                            .catch(function (error) {
                                console.log(error); //wiadomosc jak blad
                            }); 
                    break;
                case 'info':
                        this.panels = {"posts": false, "images": false, "friends": false, "info": true };
                    break;
                default:
                    this.panels = {"posts": true, "images": false, "friends": false, "info": false };
                    console.log(this.panels);
                    break;
            }
        },

        unfriend(id) {

            if ( confirm('Na pewno usunąć znajomego?') ) {
                axios.get(this.baseURL+'unfriend/'+id)
                    .then(response => {
                        // console.log(response); //wiadomosc jak bedzie dzialac
                        this.friendsList = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                    })
                    .catch(function (error) {
                        console.log(error); //wiadomosc jak blad
                    });            
            }

        },

        updateProfile() {
                axios.post(this.baseURL+'updateProfile', {
                userInfo: this.userInfo,
                image: this.image,
                background_pic: this.background_pic
                })
                .then(function (response) {
                    console.log(response.data); //
                    console.log('updateProfile'); //
                    app.userInfo = response.data;
                })
                .catch(function (error) {
                    console.log(error); //
                });
        },

        /**
         * UPLOAD ZDJĘCIA PROFILOWEGO
         */
        
        onFileChange(e) {
            console.log( '1' );
            var files = e.target.files || e.dataTransfer.files;
            this.createImg(files[0]);
        },
        createImg(file) {
            //podgląd zdjęcia przed wysłaniem
            var image = new Image;
            var reader = new FileReader;

            reader.onload = (e) =>{
                this.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        uploadImg() {
            axios.post(this.baseURL+'addImg', {
                image: this.image,
                background_img: background_pic
                })
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
                this.image = '';
                this.background_pic = "";
        },
        removeImg(){
            this.$refs.refImg[0].value = '';
            this.$refs.refImg2[0].value = '';
            this.image = "";
            this.background_pic = "";
            // console.log( this.$refs.refImg[0].value);
        },

        /**
         * UPLOAD BACKGROUND PICK
         */
        backgroundPic(e) {
            console.log( '2' );
            var file = e.target.files;
            this.createBP(file[0]);
        },
        createBP(file) {
            var image = new Image;
            var reader = new FileReader;

            reader.onload = (e) =>{
                this.background_pic = e.target.result;
            };
            reader.readAsDataURL(file);
        }

    }
});
