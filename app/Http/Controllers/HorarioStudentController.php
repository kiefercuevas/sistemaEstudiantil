<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HorarioStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
        $seccionesStudent =DB::table('inscribed')
        ->select('inscribed.id',
            'subjects.code_subject',
            'classrooms.location',
            'sections.second_time_first',
            'sections.second_time_last',
            'sections.time_first',
            'sections.section',
            'sections.day_one',
            'sections.day_two',
            'sections.time_last'
        )
        ->join('sections','inscribed.sections_id', '=','sections.id' )
        ->join('subjects','sections.subjects_id', '=','subjects.id' )
        ->join('classrooms','sections.classrooms_id', '=','classrooms.id' )
        ->where('inscribed.students_id','=', $id)
        ->where('sections.status','=',1)
        ->get();

        
        return view('horarios.horarioStudent', ['sections' => $seccionesStudent]);
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/home');}
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
