<?php

namespace App\Http\Controllers;

use App\Students;
use App\inscribed;
use App\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;
use Spatie\Activitylog\Models\Activity;
class StudentsController extends Controller
{

     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         try {
        $studentsList = Students::orderBy('names', 'asc')->paginate(8);

        return view('students.student', ['studentsList' => $studentsList]);
        
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
        return view('students.students_create');
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
        $this->validate($request, [
             'names' => 'required',
            'last_name' => 'required',
            'identity_card' => 'required',
            'civil_status' => 'required',
            'email' => 'email|required|unique:students',
            'shift' => 'required',
         ]);

        $students = Students::create([
            'names'=> $request->input('names'),
            'last_name' => $request->input('last_name'),
            'career' => $request->input('career'),
            'birthday' => $request->input('birthday'),
            'identity_card' => $request->input('identity_card'),
            'civil_status' => $request->input('civil_status'),
            'email' => $request->input('email'),
            'shift' => $request->input('shift'),
            'condition' => $request->input('condition').'/ORI-101',
            'debt' => 0,
            'inscribed_opportunity' => 0,
        ]);

            $userModel = Auth::user();
            $someContentModel = $students;
            activity('Estudiante')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo :'.$students->names.'/'.$students->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        session::flash('message', 'Estudiante creado correctamente...');
        return redirect('/students');
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
    }


    public function search(Request $request){
    try {
        $studentSearch = \Request::get('studentSearch');
        $studentsList = Students::where('students.names', 'like', '%'.$studentSearch.'%')
        ->orwhere('students.last_name', 'like', '%'.$studentSearch.'%')
        ->orderBy('students.names')
        ->paginate(8);
        
        return view('students.student', ['studentsList' => $studentsList]);
    }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
        $student = Students::find($id);
        $subjects = explode('/', $student['condition']);
        $inscritos = DB::table('inscribed')
                ->where('students_id','=',$id)
                ->get();
        
        // $inscribed_number = DB::table('inscribed')
        //         ->join('subjects', function ($join){
        //             $join->on('inscribed.sections_id','=','sections.id')
        //             ->where('sections.section', '=', $section);               
        //         })
        //         ->get();

        for ($x=0; $x < count($subjects); $x++) { 
            $sections[$x] = DB::table('sections')
            ->select('sections.id',
		    'sections.section',
		    'sections.status',
		    'sections.time_first',
		    'sections.time_last',
		    'classrooms.location',
		    'sections.quota',
		    'sections.shift',
		    'sections.day_one',
		    'sections.day_two',
		    'sections.second_time_first',
		    'sections.second_time_last',
		    'subjects.subject',
		    'subjects.code_subject',
            'subjects.credits'
		)
        ->join('subjects','sections.subjects_id', '=','subjects.id' )
		->join('classrooms','sections.classrooms_id', '=','classrooms.id' )
        ->where('sections.status', '=', 1)
        ->where('sections.shift', '=', $student['shift'])
        ->where('subjects.code_subject', '=', $subjects[$x])
        ->get();        
        }
        
        
        
        return view('sections.offers_student', ['sections'=> $sections, 'student'=> $student]);
        
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
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
        $student = Students::find($id);
        return view('students.students_edit', ['student' => $student]);
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
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
    try{
        $this->validate($request, [
             'names' => 'required|max:45',
             'last_name' => 'required|max:45',
             'career' => 'required',
             'email' => 'email',
             'shift' => 'required',
             'identity_card' => 'required|min:13',
             'birthday' => 'before:today',
         ]);

        $student = Students::find($id);
        $student->fill($request->all());
        $student->save();

            $userModel = Auth::user();
            $someContentModel = $student;
            activity('Estudiante')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Edito :'.$student->names.'/'.$student->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        session::flash('message', 'Estudiante editado correctamente...');

        return redirect('/students');
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
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
        $student = Students::find($id);
        $sectionsInscribed = DB::table('inscribed')
        ->where('inscribed.students_id','=',$id)
        ->delete();

        $student->delete();

            $userModel = Auth::user();
            $someContentModel = $student;
            activity('Estudiante')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Elimino :'.$student->names.'/'.$student->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        session::flash('message', 'Estudiante Eliminado correctamente...');
        return redirect('/students');

        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/students');
        }
    }

}