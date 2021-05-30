<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\CommonQuestion;
use App\Http\Controllers\Controller;

class CommonQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions  = CommonQuestion::select('id','question_ar','answer_ar'
        )->latest()->paginate(5);

        return view('dashboard.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'question_ar' => 'required|unique:common_questions|max:255',
            'question_en' => 'required|unique:common_questions|max:255',
            'answer_ar'   => 'required|max:255',
            'answer_en'   => 'required|max:255',
        ],[
            'question_ar.required'  => 'يرجي ادخال السؤال بالعربيه',
            'question_ar.unique'    => 'السؤال بالعربيه مسجل مسبقا',
            'question_en.required'  => 'يرجي ادخال السؤال بالانجليزيه',
            'question_en.unique'    => 'لسؤال بالانجليزيه مسجل مسبقا',
            'answer_ar.required'    => 'يرجي ادخال الاجابه بالعربيه',
            'answer_en.required'    => 'يرجي ادخال الاجابه بالانجليزيه',
        ]);
        CommonQuestion::create([
            'question_ar'     => $request->question_ar,
            'question_en'     => $request->question_en,
            'answer_ar'       => $request->answer_ar,
            'answer_en'       => $request->answer_en,
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['question']   = CommonQuestion::find($id);
        return view('dashboard.questions.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = CommonQuestion::find($id);
        return view('dashboard.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'question_ar' => 'required|max:255|unique:common_questions,question_ar,'.$id,
            'question_en' => 'required|max:255|unique:common_questions,question_en,'.$id,
            'answer_ar'   => 'required',
            'answer_en'   => 'required',
        ],[

            'question_ar.required'  => 'يرجي ادخال السؤال بالعربيه',
            'question_ar.unique'    => 'السؤال بالعربيه مسجل مسبقا',
            'question_en.required'  => 'يرجي ادخال السؤال بالانجليزيه',
            'question_en.unique'    => 'لسؤال بالانجليزيه مسجل مسبقا',
            'answer_ar.required'    => 'يرجي ادخال الاجابه بالعربيه',
            'answer_en.required'    => 'يرجي ادخال الاجابه بالانجليزيه',
        ]);
        $question = CommonQuestion::find($id);
        $question->update([
            'question_ar'     => $request->question_ar,
            'question_en'     => $request->question_en,
            'answer_ar'       => $request->answer_ar,
            'answer_en'       => $request->answer_en,
        ]);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CommonQuestion::findOrFail($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.questions.index');
    }
}
