<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\Comment;

class CommentController extends Controller
{   
    // Question - comment
    public function show_question($id)
    {
        $question = Question::find($id);
        $comments = $question -> comments;
        
        return view('comments.index_question', compact('question','comments'));
    }


    public function store_question(Request $request, $id)
    {
        $question = Question::find($id);
        unset($request["_token"]);
        // dd($request->all());
        $new_comment = Comment::create($request->all());
        $question -> comments() -> attach($new_comment);
        return redirect('/questions/'.$id.'/comments');
    }


    // Answer-comments
    public function show_answer($q_id,$id)
    {   
        $question = Question::find($q_id);
        $answer = Answer::find($id);
        $comments = $answer -> comments;
        
        return view('comments.index_answer', compact('question','answer','comments'));
    }


    public function store_answer(Request $request, $q_id, $id)
    {
        $answer = answer::find($id);
        unset($request["_token"]);
        $new_comment = Comment::create($request->all());
        $answer -> comments() -> attach($new_comment);
        // dd($new_comment);
        return redirect("/answers/$q_id/$id/comments");
    }

    
    public function edit_question($q_id,$id)
    {
        $question = Question::find($q_id);
        $comment = Comment::find($id);

        return view('comments.edit_question', compact('question','comment'));
    }
    
    public function edit_answer($q_id,$a_id,$id)
    {
        $question = Question::find($q_id);
        $answer = Answer::find($a_id);
        $comment = Comment::find($id);

        return view('comments.edit_answer', compact('question','answer','comment'));
    }
    public function update_question(Request $request, $q_id, $id)
    {
        unset($request["_token"]);
        unset($request["_method"]);
        // dd($request->all());
        $comment = Comment::find($id);
        $comment -> update($request->all());
        return redirect("/questions/$q_id/comments");
    }

    public function update_answer(Request $request, $q_id, $a_id,$id)
    {
        unset($request["_token"]);
        unset($request["_method"]);
        // dd($request->all());
        $comment = Comment::find($id);
        $comment -> update($request->all());
        return redirect("/answers/$q_id/$a_id/comments");
    }

    public function destroy_question($q_id,$id)
    {
        $comment = Comment::find($id);
        $comment -> questions() -> detach();
        $comment->delete();
        return redirect("/questions/$q_id/comments");
    }

    public function destroy_answer($q_id,$a_id,$id)
    {
        $comment = Comment::find($id);
        $comment -> answers() -> detach();
        $comment->delete();
        return redirect("/answers/$q_id/$a_id/comments");
    }
}
