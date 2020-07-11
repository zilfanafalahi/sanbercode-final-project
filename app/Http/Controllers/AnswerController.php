<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Answer;
use App\Comment;
use App\Reputation;

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
        $user = Reputation::firstWhere('users_id',Auth::id());

        //jika id tidak ditemukan dalam record reputasi
        if(!$user){
            $user = Reputation::Create([
                "poin" => 0,
                "users_id" => Auth::id(),
            ]);
        };

        $reputasi = $user->poin;

        $question = Question::find($id);
        $answers = $question->Answers;

        $poin = [];
        foreach ($answers as $a) {
            $temp_poin = 0;
            $votes = $a->votes;
            foreach ($votes as $vote) {
                $temp_poin += $vote->poin;
            }
            $poin[$a->id] = $temp_poin;
        }
        
        return view('answers.index', compact('question','answers','poin','reputasi'));
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
