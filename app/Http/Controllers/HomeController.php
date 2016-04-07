<?php

namespace App\Http\Controllers;

use AdamWathan\EloquentOAuth\Facades\OAuth;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $redirecto = '/';

    public function home()
    {
        return view('home', ['title' => 'MySnippets - Home page', 'all_snippets' => $this->allUsersSnippets("")]);
    }
    
    public function createSnippet()
    {
        return view('createSnippet', ['title' => 'MySnippets - Create your snippet', 'last_snippets' => $this->allUsersSnippets("LIMIT 4")]);
    }

    public function gitHubLogin()
    {
        $this->saveUser();
        
        return redirect('/');
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
        $username = $this->getUsername();
        
            $all_snippets = DB::select("SELECT tt.* FROM snippets tt INNER JOIN (SELECT snippet_id, MAX(revision_id) AS revision_id FROM snippets WHERE username = '$username' GROUP BY snippet_id) groupedtt ON tt.snippet_id = groupedtt.snippet_id AND tt.revision_id = groupedtt.revision_id ORDER BY id DESC $limit");

        return $all_snippets;
    }
    
    public function gitHubLogout()
    {
        Auth::logout();
        
        return redirect('/');
    }

}
