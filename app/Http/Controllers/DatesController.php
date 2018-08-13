<?php

namespace App\Http\Controllers;

use App\QualificationDates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;
use Auth;
class DatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view('dates.dates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_midterm_date_from' => 'required',
            'first_midterm_date_to' => 'required',
            'second_midterm_date_from' => 'required',
            'second_midterm_date_to' => 'required',
            'pratice_score_date_from' => 'required',
            'pratice_score_date_to' => 'required',
            'final_exam_date_from' => 'required',
            'final_exam_date_to' => 'required',
         ]);
        if ($validator->fails()) {
            return redirect('dates/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $dates= QualificationDates::create([
			'first_midterm_date_from' => $request['first_midterm_date_from'],
			'first_midterm_date_to' => $request['first_midterm_date_to'],
			'second_midterm_date_from' => $request['second_midterm_date_from'],
			'second_midterm_date_to' => $request['second_midterm_date_to'],
			'pratice_score_date_from' => $request['pratice_score_date_from'],
			'pratice_score_date_to' => $request['pratice_score_date_to'],
			'final_exam_date_from' => $request['final_exam_date_from'],
			'final_exam_date_to' => $request['final_exam_date_to'],
            ]);
        
        $userModel = Auth::user();
            $someContentModel = $dates;
            activity('fechas-calificaciones')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo : fechas');
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

            session::flash('message', 'fechas  creadas correctamente...');
            return redirect('/home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QualificationDates  $qualificationDates
     * @return \Illuminate\Http\Response
     */
    public function show(QualificationDates $qualificationDates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QualificationDates  $qualificationDates
     * @return \Illuminate\Http\Response
     */
    public function edit(QualificationDates $qualificationDates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QualificationDates  $qualificationDates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualificationDates $qualificationDates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QualificationDates  $qualificationDates
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualificationDates $qualificationDates)
    {
        //
    }
}
