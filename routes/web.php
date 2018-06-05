<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/try', function () {
    // return App\Post::with('user', 'likes', 'comments', 'postsLinks')->get();
    // return App\Post::with('postsLinks')->get();

    // $Post = App\Post::where('user_id', Auth::user()->id)->get();
    // return $Post;

    $userData = DB::table('users')
        ->leftJoin('profiles', 'profiles.user_id', 'users.id')
        ->where('slug', Auth::user()->slug)
        ->select('name','kraj','miasto','website', 'omnie', 'pic')
        ->get();
    return $userData;

});

Route::get('/', function () {
    // $posty = DB::table('posts')
    // ->leftJoin('users','users.id','posts.user_id')
    // ->get();
    // return view('welcome', compact('posty'));

    if (Auth::check()) {
        return redirect('welcome');
    }else{
        return view('start');
    }

    
})->name('main');

//posty
Route::get('/posts',function(){

    // $posts_json = DB::table('users')
    //     ->rightJoin('profiles', 'profiles.user_id','users.id')
    //     ->rightJoin('posts',  'posts.user_id' , 'users.id')
    //     ->orderBy('posts.created_at', 'desc')
    //     ->get();
    //   return $posts_json;

    $posty = App\Post::with('User', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
    return $posty;
});

Route::get('/postProfile', 'PostsController@postProfile');

Route::post('/addPost', 'PostsController@addPost');

Route::post('/updatePost', 'PostsController@updatePost');

Route::get('singlePost/{id}', 'PostsController@singlePost');

Route::get('deletePost/{id}', 'PostsController@deletePost');

//koniec posty

//wiadomosci
Route::get('/messages', function () {
    return view('messages');
});

Route::get('/newMessages', 'ProfileController@newMessages');

Route::get('getMessages', function () {
    $allUsers = DB::table('users')
        ->Join('conversation', 'users.id','conversation.user_one')
        ->where('conversation.user_two', Auth::user()->id)->get();

    $allUsers1 = DB::table('users')
        ->Join('conversation', 'users.id','conversation.user_two')
        ->where('conversation.user_one', Auth::user()->id)->get();

    $allUsers2 = DB::table('users')->where('id', '!=', Auth::user()->id)->get();

    return array_merge($allUsers->toArray(), $allUsers1->toArray());
    // return $allUsers2;
});

Route::get('getMessages/{id}', function ($id) {
    // // sprawdzamy tabele conversation

    // $checkCon = DB::table('conversation')->where('user_one', Auth::user()->id)->where('user_two', $id)->get();
        
    // if (count($checkCon) != 0) {
    //     // lapiemy wiadomosci
    //     $userMsg = DB::table('messages')->where('messages.conversation_id', $checkCon[0]->id)->get();
    //     return $userMsg;
    // } else {
    //     echo 'brak';
    // }

    $userMsg = DB::table('messages')
        ->leftjoin('users','users.id', 'messages.user_from')
        ->where('messages.conversation_id', $id)->get();
    return $userMsg;
    
});

Route::post('/sendMessage', 'ProfileController@sendMessage');

Route::post('/sendNewMessage', 'ProfileController@sendNewMessage');

//koniec wiadomosci

//zaczynamy wyszukiwarke

Route::post('/search', 'ProfileController@search');

//konczymy wyszukiwarke

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/welcome', function () {
        // $posty = DB::table('posts')
        //     ->Join('users','users.id','posts.user_id')
        //     ->get();

        // $likes =  App\likePost::all();

        $posty = App\Post::with('user','likes', 'comments')->get();

        return view('welcome', compact('posty'));
        // return $posty;
        // return view('start');
    });

    //lajki
    Route::get('likePost/{id}', 'PostsController@likePost');
    //usuwamy lajka
    Route::get('deleteLike/{id}', 'PostsController@deleteLike');

    Route::get('/likes', function () {
        return App\likePost::all();
    });
    // koniec lajki

    //dodawanie zdjęcia w pośice
        Route::post('/addImg', 'PostsController@addImg');
    //koniec dodawanie zdjęcia w poście

    //dodawanie komentarzy
    Route::post('/addComment', 'PostsController@addComment');
    // koniec komentarzy
    
    Route::get('/home', 'HomeController@index')->name('home');


    //SEKCJS ZMIANY DANYCH PROFILU
    Route::get('profile/{slug}', 'ProfileController@index');

    Route::get('/getProfileData', function () {
        $userData = DB::table('users')
            ->leftJoin('profiles', 'profiles.user_id', 'users.id')
            ->where('slug', Auth::user()->slug)
            ->select('name', 'kraj', 'miasto', 'website', 'omnie', 'pic','picBackground')
            ->get();
        return $userData;
    });

    Route::get('/changePhoto', function () {
        return view('profile.pic');
    });

    Route::post('/uploadPhoto', 'ProfileController@uploadPhoto');

    Route::get('/editProfile', 'ProfileController@editProfileForm');

    Route::post('/updateProfile', 'ProfileController@updateProfile');



    Route::get('/findFriends', 'ProfileController@findFriends');    

    Route::get('/addFriend/{id}','ProfileController@addFriendRequest');

    Route::get('/requests', 'ProfileController@requests');

    Route::get('/accept/{name}/{id}', 'ProfileController@accept');

    Route::get('/remove/{id}', 'ProfileController@remove');
    
    Route::get('/friendsList/{id}', 'ProfileController@friendsList')->name('friendsList');    

    Route::get('/notifications/{id}', 'ProfileController@notifications');

    Route::get('unfriend/{id}', function ($id) {

        $delFriend = DB::table('friendships')
                ->where('requester', $id)
                ->where('user_requested', Auth::user()->id)                
                ->delete();

        $delFriend2 = DB::table('friendships')
                ->where('requester', Auth::user()->id)
                ->where('user_requested', $id)                
                ->delete();

        if ( $delFriend ) {
            // return back()->with('msg','Usunięto znajomego');
            return redirect()->route('friendsList');
        } elseif( $delFriend2 ) {
            // return back()->with('msg','Usunięto znajomego');
            return redirect()->route('friendsList');
        }
        
    });
    
});

