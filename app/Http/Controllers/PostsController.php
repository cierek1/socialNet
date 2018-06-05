<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Post;
use Goutte\Client;

class PostsController extends Controller
{
    public function index()
    {
        $posty = DB::table('posts')->get();

        return view('posts', compact('posty'));
    }

    public function addPost(Request $request)
    {
        $content = $request->content;

        $urls = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);
        $msg = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content);
        $results = [];

        if ($urls > 0) {
            $url = $match[0][0];

            $client = new Client();
            try {
                $crawler = $client->request('GET', $url);

                $statusCode = $client->getResponse()->getStatus();
                if ($statusCode == 200) {
                    $title = $crawler->filter('title')->text();

                    if ($crawler->filterXpath('//meta[@name="description"]')->count()) {
                        $description = $crawler->filterXpath('//meta[@name="description"]')->attr('content');
                    }elseif ($crawler->filterXpath('//meta[@property="og:description"]')->count()) {
                        $description = $crawler->filterXpath('//meta[@property="og:description"]')->attr('content');
                    }

                    if ($crawler->filterXpath('//meta[@name="og:image"]')->count()) {
                        $image = $crawler->filterXpath('//meta[@name="og:image"]')->attr('content');
                    } elseif ($crawler->filterXpath('//meta[@name="twitter:image"]')->count()) {
                        $image = $crawler->filterXpath('//meta[@name="twitter:image"]')->attr('content');
                    }elseif ($crawler->filterXpath('//meta[@property="og:image"]')->count()) {
                        $image = $crawler->filterXpath('//meta[@property="og:image"]')->attr('content');
                    } else {
                        if ($crawler->filter('img')->count()) {
                            $image = $crawler->filter('img')->attr('src');
                        } else {
                            $image = 'no_image';
                        }
                    }

                    $results['title'] = $title;
                    $results['url'] = $url;
                    $results['host'] = parse_url($url)['host'];
                    $results['description'] = isset($description) ? $description : '';
                    $results['image'] = $image;
                    $results['msg'] = $msg;
                } 
            }catch (\Exception $e) {
                    // log
                }
        }

        $createPost = DB::table('posts')
            ->insert(['content' => $msg, 'user_id' => Auth::user()->id, 'url'=>@$url, 'title'=>@$title, 'description'=>@$description, 'img'=>@$image, 'host'=>@$results['host'], 'status' => '0', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);   

        if ($createPost) {
            // $posts_json = DB::table('users')
            //     ->rightJoin('profiles', 'profiles.user_id','users.id')
            //     ->rightJoin('posts',  'posts.user_id' , 'users.id')
            //     ->orderBy('posts.created_at', 'desc')
            //     ->get();
            // return $posts_json;

            return Post::with('User', 'likes')->orderBy('created_at', 'DESC')->get();
        }
    }

    public function singlePost($id){
        return Post::find($id);
    }

    public function updatePost(Request $request) {
        $id = $request->id;
        $content = $request->content;
        $content = preg_replace( "|\n/|", "", $content );
        
        // update posta z bazy
        $urls = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);
        $msg = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content);
        $results = [];

        if ($urls > 0) {
            $url = $match[0][0];

            $client = new Client();
            try {
                $crawler = $client->request('GET', $url);

                $statusCode = $client->getResponse()->getStatus();
                if ($statusCode == 200) {
                    $title = $crawler->filter('title')->text();

                    if ($crawler->filterXpath('//meta[@name="description"]')->count()) {
                        $description = $crawler->filterXpath('//meta[@name="description"]')->attr('content');
                    }elseif ($crawler->filterXpath('//meta[@property="og:description"]')->count()) {
                        $description = $crawler->filterXpath('//meta[@property="og:description"]')->attr('content');
                    }

                    if ($crawler->filterXpath('//meta[@name="og:image"]')->count()) {
                        $image = $crawler->filterXpath('//meta[@name="og:image"]')->attr('content');
                    } elseif ($crawler->filterXpath('//meta[@name="twitter:image"]')->count()) {
                        $image = $crawler->filterXpath('//meta[@name="twitter:image"]')->attr('content');
                    }elseif ($crawler->filterXpath('//meta[@property="og:image"]')->count()) {
                        $image = $crawler->filterXpath('//meta[@property="og:image"]')->attr('content');
                    } else {
                        if ($crawler->filter('img')->count()) {
                            $image = $crawler->filter('img')->attr('src');
                        } else {
                            $image = 'no_image';
                        }
                    }

                    $results['title'] = $title;
                    $results['url'] = $url;
                    $results['host'] = parse_url($url)['host'];
                    $results['description'] = isset($description) ? $description : '';
                    $results['image'] = $image;
                    $results['msg'] = $msg;
                } 
            }catch (\Exception $e) {
                    // log
                }
        }

        $createPost = DB::table('posts')
            ->where('id', $id)
            ->update(['content' => @$msg, 'user_id' => Auth::user()->id, 'url'=>@$url, 'title'=>@$title, 'description'=>@$description, 'img'=>@$image, 'host'=>@$results['host'], 'status' => '0']);   

        if ($createPost) {
            // $posts_json = DB::table('users')
            //     ->rightJoin('profiles', 'profiles.user_id','users.id')
            //     ->rightJoin('posts',  'posts.user_id' , 'users.id')
            //     ->orderBy('posts.created_at', 'desc')
            //     ->get();
            // return $posts_json;

            return Post::with('User', 'likes')->orderBy('created_at', 'DESC')->get();
        }else {
            $posty = Post::with('User', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
            return $posty;
        }
    }

    public function deletePost($id){
        $deletePost = DB::table('posts')->where('id', $id)->delete();

        $uid = Auth::user()->id;
        $deleteLike = DB::table('like_posts')->where('post_id', $id)->delete();

        if ($deletePost || $deleteLike) {
            // $posts_json = DB::table('users')
            //     ->rightJoin('profiles', 'profiles.user_id','users.id')
            //     ->rightJoin('posts',  'posts.user_id' , 'users.id')
            //     ->orderBy('posts.created_at', 'desc')
            //     ->get();
            // return $posts_json;

            return Post::with('User', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }
    }

    public function postProfile(){
        return Post::where('user_id', Auth::user()->id)
            ->with('User', 'likes', 'comments')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function likePost($id){
        //dodajemy lik'a
        $likePost = DB::table('like_posts')
        ->insert([
            'post_id' => $id,
            'user_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($likePost) {
            //wyswietlamy poty po zalajkowaniu
            return Post::with('User', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }
    }

    //usuwamy like
    public function deleteLike($id){
        $uid = Auth::user()->id;
       $deleteLike = DB::table('like_posts')->where('post_id', $id)->where('user_id', $uid )->delete();

        if ($deleteLike) {
            return Post::with('User', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        } 
    }

    public function addComment(Request $request){
        $comment = $request->comment;
        $id = $request->id;

        $createComment = DB::table('comments')
            ->insert(['comment' => $comment, 'user_id' => Auth::user()->id, 'post_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        if ($createComment) {
            // $posts_json = DB::table('users')
            //     ->rightJoin('profiles', 'profiles.user_id','users.id')
            //     ->rightJoin('posts',  'posts.user_id' , 'users.id')
            //     ->orderBy('posts.created_at', 'desc')
            //     ->get();
            // return $posts_json;

            return Post::with('User', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }
    }

    public function addImg(Request $request) {
        $prof_img =  $request->get('image');
        $back_img = $request->get('background_img');

        //usuwamy zbędny fragment w tablicy
        $exploded_prof_img = explode(",",$prof_img);
        $exploded_back_img = explode(",",$prof_img);

        //extensions
        if (str_contains($exploded_prof_img[0], 'gif')) {
            $ext = 'gif';
        }else if(str_contains($exploded_prof_img[0], 'png')) {
            $ext = 'png';
        }else {
            $ext = 'jpg';
        }

        if (str_contains($$exploded_back_img[0], 'gif')) {
            $ext = 'gif';
        }else if(str_contains($$exploded_back_img[0], 'png')) {
            $ext = 'png';
        }else {
            $ext = 'jpg';
        }
       
       //dekodowanie
       $decode_prof_img = base64_decode($exploded_prof_img[1]);
       $decode_back_img = base64_decode($exploded_back_img[1]);
       
       //nazwa pliku
       $filename_prof_img = str_random() . "." . $ext;
       $filename_back_img = str_random() . "." . $ext;
       
       //sciezka do folderu
       $path1 = public_path() . "/storage/img/" . $filename_prof_img;
       $path2 = public_path() . "/storage/img/" . $filename_back_img;

       //upload img
       file_put_contents($path1,$decode_prof_img);
       file_put_contents($path2,$decode_back_img);
    }
}
