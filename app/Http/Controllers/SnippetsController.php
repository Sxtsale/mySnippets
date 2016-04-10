<?php

namespace App\Http\Controllers;

use App\Snippets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SnippetsController extends HomeController
{

    public function mySnippet($snippet_id)
    {
        return redirect('mySnipet/'.$snippet_id.'/edit');
    }

    public function validatorMessages()
    {
        return [
            'required'    => 'Polje \':attribute\' je obavezno.',
        ];
    }

    public function validatorRules()
    {
        return [
            'name' => 'required',
            'extension' => 'required',
            'snippet' => 'required',
        ];
    }

    public function validateSnippetInputs($inputs, $rules, $messages)
    {
        return Validator::make($inputs, $rules, $messages);
    }

    public function saveSnippet($inputs, $username, $last_snippet_id)
    {
        $snipets = new Snippets();

            $snipets->name = $inputs['name'];
            $snipets->snippet_id = $last_snippet_id;
            $snipets->revision_id = "0";
            $snipets->extension = $inputs['extension'];
            $snipets->snippet = $inputs['snippet'];
            $snipets->username = $username;

        $snipets->save();
    }

    public function saveUpdateSnippet($inputs, $username, $last_revision_id)
    {
        $snipets = $this->snippetsModel();

            $snipets->name = $inputs['name'];
            $snipets->snippet_id = $inputs['snippet_id'];
            $snipets->revision_id = $last_revision_id;
            $snipets->extension = $inputs['extension'];
            $snipets->snippet = $inputs['snippet'];
            $snipets->username = $username;

        $snipets->save();
    }

    public function deleteSnippet($snippet_id)
    {
        $this->snippetsModel()->where('snippet_id', $snippet_id)->delete();

        return redirect('/')
            ->with(session()->flash('success', 'Uspešno ste obrisali vaš snippet. ('.Input::get('name').')'));
    }

    public function storeSnippet(Request $request)
    {
        $inputs = $request->all();
        $messages = $this->validatorMessages();
        $rules = $this->validatorRules();
        $validator = $this->validateSnippetInputs($inputs, $rules, $messages);

        if($validator->fails()){
            return Redirect()->action('HomeController@createSnippet')
                ->withErrors($validator)
                ->with(session()->flash('warning', 'Molimo vas da popunite sva polja.'))
                ->withInput();
        }else{

            $username = HomeController::getUsername();
            $last_snippet_id = $this->lastSnippetId();
            $this->saveSnippet($inputs, $username, $last_snippet_id);

            return Redirect()->action('HomeController@home')
                ->withErrors($validator)
                ->with(session()->flash('success', 'Uspešno ste kreirali vaš snippet. ('.$inputs['name'].')'))
                ->withInput();
        }
    }
    
    public function updateSnippet(Request $request)
    {
        $inputs = $request->all();
        $messages = $this->validatorMessages();
        $rules = $this->validatorRules();
        $validator = $this->validateSnippetInputs($inputs, $rules, $messages);
        
        if($validator->fails()){
            return Redirect('/mySnippet/'.$inputs['snippet_id'])
                ->withErrors($validator)
                ->with(session()->flash('warning', 'Molimo vas da popunite sva polja.'))
                ->withInput();
        }else{
            $username = $this->getUsername();
            $last_revision_id = $this->lastRevisionId($inputs['snippet_id']);
            $this->saveUpdateSnippet($inputs, $username, $last_revision_id);

            return Redirect()->action('HomeController@home')
                ->withErrors($validator)
                ->with(session()->flash('success', 'Uspešno ste prepravili vaš snippet. ('.$inputs['name'].')'))
                ->withInput();
        }
    }

    public function mySnippetEdit($snippet_id)
    {
        $snippet_details = $this->SelectSnippet($snippet_id, 1);
        $revision_id = $this->lastRevisionId($snippet_id);

        foreach($snippet_details as $snippet_detail)
        {
            $name = $snippet_detail->name;
            $extension = $snippet_detail->extension;
            $snippet = $snippet_detail->snippet;
        }

        return view('mySnippet', ['title' => 'MySnippets - '.$name, 'name' => $name, 'extension' => $extension, 'snippet' => $snippet, 'snippet_id' => $snippet_id, 'revision_id' => $revision_id]);
    }

    public function lastSnippetId()
    {
        $last_snippet_id = $this->snippetsModel()->orderBy('snippet_id')->get();

            if($last_snippet_id == []){
                $last_snippet_id = "0";
            }else{
                foreach ($last_snippet_id as $lsi){
                    $last_snippet_id = $lsi->snippet_id;
                }
                $last_snippet_id++;
            }
        return $last_snippet_id;
    }

    public function lastRevisionId($snippet_id)
    {
        $last_revision_id = $this->snippetsModel()->where('snippet_id', $snippet_id)->orderBy('revision_id')->get();

            foreach ($last_revision_id as $lri){
                $last_revision_id = $lri->revision_id;
            }

        $last_revision_id++;

        return $last_revision_id;
    }

    public function allSnippetRevisions($snippet_id)
    {
        $snippet_details = $this->SelectSnippet($snippet_id, $this->lastRevisionId($snippet_id));

            $i = 0;
            foreach ($snippet_details as $snippet_detail){
                $name[$i] = $snippet_detail->name;
                $extension[$i] = $snippet_detail->extension;
                $snippet[$i] = $snippet_detail->snippet;
                $i++;
            }
        $check_difference = $this->checkDifference($i, $name, $extension, $snippet);

        return view('mySnippetRevisions', ['title' => 'MySnippets - '.$name[0], 'snippet_details' => $snippet_details, 'name' => $name[0], 'extension' => $extension[0], 'snippet_id' => $snippet_id, 'revision_id' => $this->lastRevisionId($snippet_id), 'difference_name' => $check_difference[0], 'difference_extension' => $check_difference[1], 'difference_snippet' => $check_difference[2], 'counter' => $i]);
    }

    public function viewSnippetRevision($snippet_id, $revision_id)
    {
        $snippet_revision_details = $this->SelectSnippetRevision($snippet_id, $revision_id);
        $revision_id = $this->lastRevisionId($snippet_id);

            foreach ($snippet_revision_details as $snippet_revision_detail){
                $name = $snippet_revision_detail->name;
                $extension = $snippet_revision_detail->extension;
                $snippet = $snippet_revision_detail->snippet;
            }

        return view('mySnippetRevision', ['title' => 'MySnippets - '.$name, 'snippet_revision_details' => $snippet_revision_details, 'name' => $name, 'extension' => $extension, 'snippet' => $snippet, 'snippet_id' => $snippet_id, 'revision_id' => $revision_id ]);
    }

    public function SelectSnippet($snippet_id, $limit)
    {
        return $this->snippetsModel()->where('snippet_id', $snippet_id)->orderBy('revision_id', 'desc')->take($limit)->get();
    }

    public function SelectSnippetRevision($snippet_id, $revision_id)
    {
        return $this->snippetsModel()
            ->where(['snippet_id' => $snippet_id, 'revision_id' => $revision_id])
            ->get();
    }

    public function checkDifference($i, $name, $extension, $snippet)
    {
        if($i <= 1){
            $difference_name[0] = DifferenceController::toTable(DifferenceController::compare("@empty", $name[$i - 1]));
            $difference_extension[0] = DifferenceController::toTable(DifferenceController::compare("@empty", $extension[$i - 1]));
            $difference_snippet[0] = DifferenceController::toTable(DifferenceController::compare("@empty", $snippet[$i - 1]));
        }else{
            for($j = 1; $j <= $i - 1; $j++){
                $difference_name[0] = DifferenceController::toTable(DifferenceController::compare("@empty", $name[$i - 1]));
                $difference_extension[0] = DifferenceController::toTable(DifferenceController::compare("@empty", $extension[$i - 1]));
                $difference_snippet[0] = DifferenceController::toTable(DifferenceController::compare("@empty", $snippet[$i - 1]));
                $difference_name[$j] = DifferenceController::toTable(DifferenceController::compare($name[$i - $j], $name[$i - $j - 1]));
                $difference_extension[$j] = DifferenceController::toTable(DifferenceController::compare($extension[$i - $j], $extension[$i - $j - 1]));
                $difference_snippet[$j] = DifferenceController::toTable(DifferenceController::compare($snippet[$i - $j], $snippet[$i - $j-1]));
            }
        }
        return [$difference_name, $difference_extension, $difference_snippet];
    }
}
