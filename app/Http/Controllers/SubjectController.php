<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subjects;
use Session;
use Redirect;
use App\Http\Requests\create_subjects_Request;
use App\Http\Requests\edit_subjects_Request;
use Auth;
use Spatie\Activitylog\Models\Activity;
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
        $subjects = Subjects::paginate(3);
        return view('subjects.index', ['subject'=>$subjects]);
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/subjects');}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
        $subjects = Subjects::all();
        return view('subjects.create', ['subject'=>$subjects]);
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/subjects');}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(create_subjects_Request $request)
    {
        try{
        $subjects = Subjects::create([
            'code_subject' => $request['code_subject'],
            'subject' => $request['subject'],
            'credits' => $request['credits'],      

        ]);

        $userModel = Auth::user();
            $someContentModel = $subjects;
            activity('Materia')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo :'.$subjects->subject.'/'.$subjects->code_subject);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        return redirect('/subjects')->with('message', 'Materia creada con exito...');
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/subjects');}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
        $subjects = Subjects::find($id);
        return view('subjects.edit', ['subjects'=>$subjects]);
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/subjects');}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(edit_subjects_Request $request, $id)
    {
        try{
        $subjects = Subjects::find($id);
        $subjects->fill($request->all());
        $subjects->save();
        session::flash('message', 'Materia editada correctamente...');

        $userModel = Auth::user();
            $someContentModel = $subjects;
            activity('Materia')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Edito :'.$subjects->subject.'/'.$subjects->code_subject);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        return Redirect::to('/subjects');
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/subjects');}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        Subjects::destroy($id);
        session::flash('message', 'Materia eliminada correctamente...');
        return Redirect::to('/subjects');
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/subjects');}
    }
}
