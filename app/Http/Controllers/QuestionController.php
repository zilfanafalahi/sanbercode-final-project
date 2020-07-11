<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Answer;
use App\Comment;
use App\Reputation;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $questions = Question::all();
        $poin = [];
        foreach ($questions as $q) {
            $temp_poin = 0;
            $votes = $q->votes;
            foreach ($votes as $vote) {
                $temp_poin += $vote->poin;
            }
            $poin[$q->id] = $temp_poin;
        }
        return view('questions.index', compact('questions','poin','reputasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'judul' => 'required',
            'isi' => 'required',
            'tag' => 'required'
        ]);
        
        $user = Auth::id();

        $new_questions = Question::create([
            "judul" => $request['judul'],
            "isi" => $request['isi'],
            "tag" => $request['tag'],
            "users_id" => $user
        ]);
        
        return redirect('/questions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questions = Question::find($id);
        return view('questions.show', compact('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $questions = Question::find($id);
        return view('questions.edit', compact('questions'));
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
        $this->validate($request,[
            'judul' => 'required',
            'isi' => 'required',
            'tag' => 'required'
        ]);

        $questions = Question::find($id)->update($request->all());
        return redirect('/questions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questions = Question::find($id);
        $answers = $questions->Answers;
        
        foreach ($answers as $answer) {
            $comments = $answer -> comments;
            $answer -> comments()-> detach();
            foreach ($comments as $comment){
                $comment -> delete();
            };
            $answer -> delete();
        }

        $comments = $questions -> comments;
        $questions -> comments() -> detach();
        foreach ($comments as $comment){
            $comment -> delete();
        };

        $questions->delete();

        return redirect('/questions');
    }

    public function cari(Request $request)
    {
        $cari = $request->get('cari');
        $questions = DB::questions('questions')
        ->where('questions','like',"%".$cari."%")
        ->paginate();
 
        return view('index',['questions' => $cari]);
    }
}
