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
        $question = Question::find($id);
        $answers = $question->Answers;

        $poin = [];
        $voted = [];
        foreach ($answers as $a) {
            $temp_poin = 0;
            $votes = $a->votes;
            foreach ($votes as $vote) {
                $temp_poin += $vote->poin;
            }
            $poin[$a->id] = $temp_poin;

            //mengisi relevansi jawaban dan menambahkan poin reputasi
            if (($a->ketepatan_jawaban === null) && ($poin[$a->id] >= 15)){
                $a->ketepatan_jawaban = 'ya';
                $a->save();
                $contributor = Reputation::firstWhere('users_id',$a->answer_user_id);
                $new_poin = $contributor->poin + 15;
                $contributor->update(['poin' => $new_poin]);
            }

            //cek apakah sudah pernah vote
            $voters = $a->votes->firstWhere('voter_user_id',Auth::id());
            if($voters){
                $voted[$a->id] = $voters -> poin;
            } else {
                $voted[$a->id] = 0;
            }
        }
        
        $user = Reputation::firstWhere('users_id',Auth::id());

        //jika id tidak ditemukan dalam record reputasi
        if(!$user){
            $user = Reputation::Create([
                "poin" => 0,
                "users_id" => Auth::id(),
            ]);
        };

        $reputasi = $user->poin;

        return view('answers.index', compact('question','answers','poin','reputasi','voted'));
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

        $votes = $answer->votes;
        $answer->votes()->detach();
        foreach ($votes as $vote) {
            $vote -> delete();
        }

        $answer -> delete();
        return redirect("answers/$q_id");
    }
}
