<?php
namespace App\Http\Controllers;

use App\Friendship;
use App\Notifications;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Post;

class ProfileController extends Controller
{
    public function index($slug)
    {
        $uid = Auth::user()->id;

        //zwracamy użytkowników
        $userData = DB::table('users')
            ->leftJoin('profiles', 'profiles.user_id', 'users.id')
            ->where('slug', $slug)
            ->get();

        //uzytkownicy i profile userów
        $allUsers = DB::table('profiles')->leftJoin('users', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();

        $userSlug = User::where('slug', $slug)->first();

        $profileId = $userSlug->id;

        $posts = Post::where('user_id', $userSlug->id)
            ->with('User', 'likes', 'comments')
            ->orderBy('created_at', 'DESC')
            ->get();


        return view('profile.index', compact('userData','allUsers','slug', 'profileId'))->with('data', Auth::user()->profile);
    }

    public function uploadPhoto(Request $request)
    {
        //pobieramy ścieżkę zdjęcia z requesta
        $file = $request->file('pic');
        //oddzielamy nazwe zdjęcia
        $filename = $file->getClientOriginalName();
        $user_id = Auth::user()->id;
        $slug = Auth::user()->slug;
        $name = Auth::user()->name;
        $path = 'public/storage/'. $name;


        $file->move($path, $filename);

        DB::table('users')
            ->where('id', $user_id)
            ->update(['pic' => $filename]);

        return redirect()->action(
            'ProfileController@index',
            ['slug' => $slug]
        );
    }

    public function editProfileForm()
    {
        return view('profile.editProfile')->with('data', Auth::user()->profile);
    }

    public function updateProfile(Request $request)
    {
        $img = $request->get('image');
        $back_img = $request->get('background_pic');

        $id = Auth::user()->id;
        $name = Auth::user()->name;

        //obsługa wgrywania zdjęcia profilowego
        if ( !empty( $img ) ) {
            
            //usuwamy zbędny fragment w tablicy
            $exploded = explode(",",$img);

            //extensions
            if (str_contains($exploded[0], 'gif')) {
                $ext = 'gif';
            }else if(str_contains($exploded[0], 'png')) {
                $ext = 'png';
            }else {
                $ext = 'jpg';
            }

           $decode = base64_decode($exploded[1]);

           $filename = Auth::user()->slug . "." . $ext;

        //    $path = 'public/storage/demo'. $filename ;
           $path = public_path() . "/storage/".$name."/" . $filename;


            //upload img
            file_put_contents($path,$decode);

            $update = DB::table('users')
                ->where('id' , $id)
                ->update(['pic' => $filename]);

        }         

        //obsługa wgrywania zdjęcia tla
        if ( !empty( $back_img ) ) {
            
            //usuwamy zbędny fragment w tablicy
            $exploded = explode(",",$back_img);

            //extensions
            if (str_contains($exploded[0], 'gif')) {
                $ext = 'gif';
            }else if(str_contains($exploded[0], 'png')) {
                $ext = 'png';
            }else {
                $ext = 'jpg';
            }

           $decode = base64_decode($exploded[1]);

           $filename = str_random() . "." . $ext;

        //    $path = 'public/storage/demo'. $filename ;
           $path = public_path() . "/storage/".$name."/" . $filename;


            //upload img
            file_put_contents($path,$decode);

            $update = DB::table('profiles')
                ->where('user_id' , $id)
                ->update(['picBackground' => $filename]);

        }         

        //update danych profilowych
        $uInfo = $request->userInfo;
        $miasto = $uInfo[0]['miasto'];
        $kraj = $uInfo[0]['kraj'];
        $www = $uInfo[0]['website'];
        $omnie = $uInfo[0]['omnie'];

        //poprzedni przykłąd , wykorzystuje request i aktualizuje wszystko bezpośrednio , poza tokenem
        // DB::table('profiles')
        //     ->where('user_id', $user_id)
        //     ->update($request->except('_token'));
        // return back();

        $profile = DB::table('profiles')
            ->where('user_id', $id)
            ->update(['kraj' => $kraj , 'miasto' => $miasto , 'website' => $www , 'omnie' => $omnie]);

            $userData = DB::table('users')
                ->leftJoin('profiles', 'profiles.user_id', 'users.id')
                ->where('slug', Auth::user()->slug)
                ->select('kraj','miasto','website', 'omnie', 'pic', 'picBackground')
                ->get();
            return $userData;

        // if ( $profile == 1 ) {
        // }

    }

    public function findFriends()
    {
        $uid = Auth::user()->id;
        $allUsers = DB::table('profiles')->leftJoin('users', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();

        return view('profile.findFriends', compact('allUsers'));
    }

    public function addFriendRequest($id)
    {
        Auth::user()->addFriend($id);

        return back();
    }

    public function requests()
    {
        $uid = Auth::user()->id;

        $friendRequests = DB::table('friendships')
            ->rightJoin('users', 'users.id', '=', 'friendships.requester')
            ->where('status', 0) //jeżeli jest 0 wyświetla requesty, jeżeli 1 nie wyswietla
            ->where('friendships.user_requested', '=', $uid)->get();

        return view('profile.requests', compact('friendRequests'));
    }

    public function accept($name, $id)
    {
        $uid = Auth::user()->id;

        $checkRequest = Friendship::where('requester', $id)
            ->where('user_requested', $uid)
            ->first();

        if ($checkRequest) {

            $update = DB::table('friendships')
                ->where('user_requested', $uid)
                ->where('requester', $id)
                ->update(['status' => 1]);

            $notifications = new Notifications;
            $notifications->note = 'Zaakceptowano zaproszenie';
            $notifications->user_hero = $id;
            $notifications->user_logged = $uid;
            $notifications->status = '1';
            $notifications->save();

            if ($update) {
                return back()->with('msg', 'Użytkownik ' . ucwords($name) . ' dodany do znajomych.');
            }

        }
        else {
            return back()->with('msg', 'Coś poszo nie tak :/');
        }

    }

    public function remove($id)
    {
        $uid = Auth::user()->id;

        $update = DB::table('friendships')
            ->where('user_requested', $uid)
            ->where('requester', $id)
            ->delete();

        if ($update) {
            return back()->with('msg', 'Nie zaakceptowano');
        }

    }

    public function friendsList($id)
    {
        // $uid = Auth::user()->id;
        $uid = $id;        

        $fList1 = DB::table('friendships')
            ->join('users', 'friendships.requester', '=', 'users.id')
            ->where('friendships.status', 1)
            ->where('friendships.user_requested', $uid)
            ->select('name','pic','slug')
            ->get();
            
            $fList2 = DB::table('friendships')
            ->join('users', 'friendships.user_requested', '=', 'users.id')
            ->where('friendships.status', 1)
            ->where('friendships.requester', $uid)
            ->select('name','pic','slug')
            ->get();

        return array_merge($fList1->toArray(), $fList2->toArray());

        // $myfList = array_merge($fList1->toArray(), $fList2->toArray());        
        // return view('profile.frindsList', compact('myfList'));       

    }

    public function notifications($id)
    {

        $uid = Auth::user()->id;

        $notka = DB::table('notifications')
            ->leftJoin('users', 'users.id', 'notifications.user_logged')
            ->where('notifications.id', $id)
            ->where('user_hero', $uid)
            ->orderBy('notifications.id', 'desc')
            ->get();

        $updateNoti = DB::table('notifications')
            ->where('notifications.id', $id)
            ->update(['status' => 0]);

        return view('profile.notifications', compact('notka'));
    }

    public function sendMessage(Request $request)
    {
        $conID = $request->conID;
        $msg = $request->newMsg;

        //wyciagamy drugiego usera, który z nami gada
        $fetch_userTo = DB::table('messages')
            ->where('conversation_id', $conID)
            ->where('user_to', '=', Auth::user()->id)
            ->get();

        $secondUser = $fetch_userTo[0]->user_from;

        // return $secondUser;

        //dodajemy do bazy
        $sendM = DB::table('messages')->insert([
            'user_from' => Auth::user()->id,
            'user_to' => $secondUser,
            'msg' => $msg,
            'status' => 1,
            'conversation_id' => $conID
        ]);

        if ($sendM) {
            $userMsg = DB::table('messages')
                ->leftJoin('users', 'users.id', 'messages.user_from')
                ->where('messages.conversation_id', $conID)->get();
            return $userMsg;
        }else{
            return 'blad';
        }
    }

    public function newMessages()
    {
        $uid = Auth::user()->id;

        $friends1 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.user_requested') // who is not loggedin but send request to
            ->where('status', 1)
            ->where('requester', $uid) // who is loggedin
            ->get();

        $friends2 = DB::table('friendships')
            ->leftJoin('users', 'users.id', 'friendships.requester')
            ->where('status', 1)
            ->where('user_requested', $uid)
            ->get();

        $friends = array_merge($friends1->toArray(), $friends2->toArray());
        return view('newMessages', compact('friends', $friends));
    }

    public function sendNewMessage(Request $request)
    {
        $msg = $request->newMsgFrom;
        $friends_id = $request->friend_id;
        $uid = Auth::user()->id;

        //sprawdzamy czy rozmowa zostala juz rozpoczeta

        $checkCon1 = DB::table('conversation')
            ->where('user_one', $uid)
            ->where('user_two', $friends_id)
            ->get(); //zalogowany użyt rozpocząl rozmowe

        $checkCon2 = DB::table('conversation')
            ->where('user_two', $uid)
            ->where('user_one', $friends_id)
            ->get(); //zalogowany użyt otrzymal wiadomosc pierwszy

        $allCon = array_merge($checkCon1->toArray(), $checkCon2->toArray());

        if (count($allCon) != 0) {
            //stara rozmowa
            $conID_old = $allCon[0]->id;

            //wstawiamy dane do tabeli messages
            $sendM = DB::table('messages')->insert([
                'user_from' => $uid,
                'user_to' => $friends_id,
                'msg' => $msg,
                'status' => 1,
                'conversation_id' => $conID_old
            ]);

        }
        else {
            //nowa rozmowa
            $conID_new = DB::table('conversation')->insertGetId([
                'user_one' => $uid,
                'user_two' => $friends_id
            ]);

            //wstawiamy dane do tabeli messages
            $sendM = DB::table('messages')->insert([
                'user_from' => $uid,
                'user_to' => $friends_id,
                'msg' => $msg,
                'status' => 1,
                'conversation_id' => $conID_new
            ]);
        }

    }

    public function search(Request $request)
    {
        $queryString = $request->queryString;

        if ($queryString != '') {
            $users = User::with('profile')
            ->where('name', '!=' , Auth::user()->name)
            ->where('name', 'like', '%' . $queryString . '%')
            ->get();
        }
        else {
            $users = '';
        }
        return $users;
    }
}
