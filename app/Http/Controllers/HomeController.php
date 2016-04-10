<?php

namespace App\Http\Controllers;

use AdamWathan\EloquentOAuth\Facades\OAuth;

use App\Http\Requests;
use App\Snippets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $redirecto = '/';

    public function home()
    {
        return view('home', ['title' => 'MySnippets - Home page', 'all_snippets' => $this->allUsersSnippets(0)]);
    }
    
    public function createSnippet()
    {
        return view('createSnippet', ['title' => 'MySnippets - Create your snippet', 'last_snippets' => $this->allUsersSnippets(4)]);
    }

    public function gitHubLogin()
    {
        $this->saveUser();
        
        return redirect('/');
    }

    public function snippetsModel()
    {
        return new Snippets();
    }

    public function saveUser()
    {
        return OAuth::login('github', function($user, $userDetails){
            $user->email = $userDetails->email;
                if($userDetails->full_name == null){
                    $user_name = "";
                }else{
                    $user_name = $userDetails->full_name;
                }
            $user->name = $user_name;
            $user->provider_user_id = $userDetails->id;
            $user->username = $userDetails->nickname;
            $user->save();
        });
    }
    
    public function getUsername()
    {
        if(Auth::check()){
            $username = Auth::user()->username;
        }else{
            $username = "";
        }

        return $username;
    }

    public function allUsersSnippets($limit)
    {
        $all_snippets = $this->snippetsModel()->where('username', $this->getUsername())->orderBy('id', 'desc')->get();

        $snippets = [];
        $snippetsRevisionId = [];

            foreach ($all_snippets as $snippet){
                if (!array_key_exists($snippet->snippet_id, $snippetsRevisionId)){
                    $snippetsRevisionId[$snippet->snippet_id] = -1;
                    $snippets[$snippet->snippet_id] = -1;
                }
                if ($snippetsRevisionId[$snippet->snippet_id] < $snippet->revision_id) {
                    $snippetsRevisionId[$snippet->snippet_id] = $snippet->revision_id;
                    $snippets[$snippet->snippet_id] = $snippet;
                }
            }

        if ($limit == 0)
            $limit = count($snippets);

        return $this->returnLimitUsersSnippets($snippets, $limit);
    }

    public function returnLimitUsersSnippets($snippets, $limit)
    {
        return array_slice($snippets, 0, $limit, true);
    }
    
    public function gitHubLogout()
    {
        Auth::logout();
        
        return redirect('/');
    }

}
