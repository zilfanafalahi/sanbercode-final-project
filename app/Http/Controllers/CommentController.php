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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
