<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;

class QuestionsController extends Controller
{
    //

    public function index()
    {
        $questions=Questions::paginate(10);
        return view('questions.questions',compact('questions'));
    }

    public function create(){
        return view('questions.add');
    }

    public function store(Request $request){
         $question  =  new Questions();

         $question->question = $request->question;
         if($question->save()){
            return redirect()->route('questions');
         }

    }
    public function edit($id){
        $question=Questions::find($id);
        return view('questions.edit',compact('question'));
    }

    public function update(Request $request,$id){
        $question=Questions::find($id);
        $question->question = $request->question;
        $question->save();
        return redirect()->route('questions');
    }
    public function destroy($id){
        $Delete = Questions::where('id',$id)->delete();
        return redirect()->route('questions');

    }

}
