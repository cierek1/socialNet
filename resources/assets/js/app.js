
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

Vue.filter('snippet', function(value){
    return value.slice(0,70) + '...';
});

const app = new Vue({
    el: '#wApp',
    data:{
        msg: 'Dodaj nowy post',
        baseURL:'http://localhost/socialNetR/',
        content:'',
        posts:[],
        singlePost:{}, 
        posiId: '',
        likes: '',
        commentData:{},
        queryString: '',
        users: [],
        id: '',
        isShow: {},
        image: '',
        close:false
    },

    ready: function(){
        this.created();
    },

    created(){
        axios.get(this.baseURL+'posts')
                .then(response => {
                    // console.log(response); //wiadomosc jak bedzie dzialac
                    this.posts = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });

            //filtr czasu, momentumjs
            Vue.filter('myOwnTime', function(value){
                return moment(value).fromNow();
            });

        //pobieramy lajki
        axios.get(this.baseURL+'likes')
                .then(response => {
                    // console.log(response); //wiadomosc jak bedzie dzialac
                    this.likes = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });

        // console.log(this.isShow[this.id]);
        console.log(this.baseURL+'try');
    },

    methods:{
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
                        mssg = response.data.content+ '' + response.data.url;
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

        closeModal() {
            if (confirm('Czy na pewno zamknąć?') ) {
                this.close = !this.close;
            }
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
                    this.posts = response.data; //przekazujemy dane z bazy do zmiennej lokalnej
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

        getSearch(){
            this.users = [];
            // this.queryString = app.queryString;
            axios.post(this.baseURL+'search', {
                queryString: this.queryString
            })
                .then(response => {
                    // console.log(response.data); //wiadomosc jak bedzie dzialac

                    app.users = response.data;
                })
        },
        showComment(key) {
            this.id = key;
            this.isShow[this.id] = !this.isShow[this.id];
            this.id = '';
            console.log(this.isShow[this.id]);
        },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            this.createImg(files[0]);
            // console.log( this.$refs );
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
                image: this.image
                })
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error); //wiadomosc jak blad
                });
                this.image = '';
        },
        removeImg(){
            this.$refs.refImg.value = '';
            this.image = ""
            // console.log( this.$refs );
        }
    }
});
