<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Answer;
use App\Vote;


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
        return redirect('/questions');
    }
}
