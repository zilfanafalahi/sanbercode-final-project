<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Answer;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $id)
    {      
        $new_answers = new Answer([
            'isi'=> $request->all()['isi'],
            'answer_user_id' => Auth::id()
        ]);

        $question = Question::find($id);
        $question->Answers()->save($new_answers);

        return redirect()->back();
    }

    public function show($id)
    {
        $question = Question::find($id);
        $answers = $question->Answers;
        return view('answers.index', compact('question','answers'));
    }

    public function edit($q_id,$id)
    {   
        $question = Question::find($q_id);
        $answer = Answer::find($id);
        return view('answers.edit', compact('question','answer'));
    }


    public function update(Request $request, $q_id,$id)
    {   
        unset($request['_token']);
        unset($request['_method']);
        $answer = Answer::find($id);
        $answer -> update($request->all());
        return redirect("/answers/$q_id");
    }

    public function destroy($q_id,$id)
    {
        $answer = Answer::find($id);
        $comment = $answer -> comments;
        $answer -> comments()-> detach();
        foreach ($comment as $comments){
            $comments -> delete();
        };
        $answer -> delete();
        return redirect("answers/$q_id");
    }
}
