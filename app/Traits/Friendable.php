<?php

namespace App\Traits;

use App\Friendship;

trait Friendable{
    public function test(){
        return 'yo';
    }

    public function addFriend($id){

        $friendship = Friendship::create([
            'requester' => $this->id, //id osoby zalogowanej
            'user_requested' => $id,
            'status' => 0,

        ]);

        if ($friendship) {
            return $friendship;
        }

        return 'blad';
    }
}