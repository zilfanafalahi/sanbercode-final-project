<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Answer;
use App\Vote;
use App\Reputation;


class VoteController extends Controller
{
    public function upvotes_question($q_id)
    {   
        $question = Question::find($q_id);
        $new_vote = Vote::create([
            'poin' => 1,
            'voter_user_id' => Auth::id()
        ]);
        $question -> votes() -> attach($new_vote);
        
        //nambah poin utk penanya
        $askers = Reputation::firstWhere('users_id',$question->users_id);
        $new_poin = $askers->poin + 10;
        $askers->update(['poin' => $new_poin]);

        return redirect('/questions');
    }

    public function downvotes_question($q_id)
    {   
        $question = Question::find($q_id);
        $new_vote = Vote::create([
            'poin' => -1,
            'voter_user_id' => Auth::id()
        ]);
        $question -> votes() -> attach($new_vote);

        //ngurang poin utk penanya
        $askers = Reputation::firstWhere('users_id',$question->users_id);
        $new_poin = $askers->poin - 1;
        $askers->update(['poin' => $new_poin]);

        return redirect('/questions');
    }

    public function upvotes_answer($q_id,$a_id)
    {   
        $answer = answer::find($a_id);
        $new_vote = Vote::create([
            'poin' => 1,
            'voter_user_id' => Auth::id()
        ]);
        $answer -> votes() -> attach($new_vote);
        
        //nambah poin utk pemberi jawaban
        $contributor = Reputation::firstWhere('users_id',$answer->answer_user_id);
        $new_poin = $contributor->poin + 10;
        $contributor->update(['poin' => $new_poin]);

        return redirect('/answers/'.$q_id);
    }

    public function downvotes_answer($q_id,$a_id)
    {   
        $answer = answer::find($a_id);
        $new_vote = Vote::create([
            'poin' => -1,
            'voter_user_id' => Auth::id()
        ]);
        $answer -> votes() -> attach($new_vote);

        //ngurang poin utk pemberi jawaban
        $contributor = Reputation::firstWhere('users_id',$answer->answer_user_id);
        $new_poin = $contributor->poin - 1;
        $contributor->update(['poin' => $new_poin]);

        return redirect('/answers/'.$q_id);
    }
}
