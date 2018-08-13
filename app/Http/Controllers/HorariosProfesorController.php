<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Session;
class HorariosProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
        $seccionesProfesor =DB::table('sections')
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
		'users.names'
		)
		->join('subjects','sections.subjects_id', '=','subjects.id' )
		->join('classrooms','sections.classrooms_id', '=','classrooms.id' )
		->join('users','sections.users_id','=','users.id')
        ->where('sections.users_id','=',Auth::user()->id)
        ->where('sections.status','=',1)
		->get();
        
        return view('horarios.horarioProfesor', ['sections' => $seccionesProfesor]);
        }catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/home');
        }
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
