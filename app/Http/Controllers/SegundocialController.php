<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Sections;
use App\Students;
use App\Inscribed;
class SegundocialController extends Controller
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
        $students = DB::table('inscribed')
        ->select('students.id',
        'students.names',
        'students.identity_card',
        'students.last_name',
        'inscribed.second_midterm')
        ->join('students','inscribed.students_id','students.id')
        ->join('sections','inscribed.sections_id','sections.id')
        ->where('sections.id','=',$id)
        ->get();

        return view('parciales.segundoParcial',['alumnos' =>$students,'id'=>$id]);
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
        $names = count($request->input('id'));
        

        for($x=0;$x < $names;$x++ ){

            DB::table('inscribed')
          ->where('inscribed.students_id','=',$request->input('id')[$x])
          ->update(['second_midterm' => $request->input('second_midterm')[$x]]);
 

        }
        session::flash('message', 'las calificaciones del segundo  parcial se han puesto correctamente');
        return redirect('/qualifications/'.$id);
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
