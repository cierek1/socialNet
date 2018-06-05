<?php

namespace App;

use App\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Profile;
use Cache;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    use Friendable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'plec', 'slug', 'pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //relacja z modelem Profil
    public function profile(){
        return $this->hasOne('App\Profile');
    }

    //relacja z modelem Post
    public function post(){
        return $this->hasOne('App\Post');
    }

    public function rFrends($id) {
        $fList1 = DB::table('friendships')
        ->join('users', 'friendships.requester', '=', 'users.id')
        ->where('friendships.status', 1)
        ->where('friendships.user_requested', $id)
        ->select('name')
        ->get();
        
        $fList2 = DB::table('friendships')
        ->join('users', 'friendships.user_requested', '=', 'users.id')
        ->where('friendships.status', 1)
        ->where('friendships.requester', $id)
        ->select('name')
        ->get();

        return array_merge($fList1->toArray(), $fList2->toArray());
    }

    

    //wyciągam dane o aktywnym userze z middleware activeUser
    public function isOnline() {
        return Cache::has('active-user' . $this->id);
    }

}
