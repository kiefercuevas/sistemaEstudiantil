<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Sections;
use App\Students;
use App\Inscribed;
class ExamenFinalController extends Controller
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
        'inscribed.final_exam')
        ->join('students','inscribed.students_id','students.id')
        ->join('sections','inscribed.sections_id','sections.id')
        ->where('sections.id','=',$id)
        ->get();

        return view('parciales.examenFinal',['alumnos' =>$students,'id'=>$id]);
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
        $sections = DB::table('sections')
        ->join('subjects','sections.subjects_id','=','subjects.id')
        ->where('sections.id','=',$id)
        ->get();
        

        for($x=0;$x < $names;$x++ ){

        $students = DB::table('students')
        ->select('students.names',
            'students.last_name',
            'inscribed.first_midterm',
            'inscribed.second_midterm',
            'inscribed.pratice_score',
            'inscribed.final_exam',
            'students.condition',
            'students.inscribed_opportunity')
        ->join('inscribed','students.id','inscribed.students_id')
        ->where('students.id','=',$request->input('id')[$x])
        ->get();

        
          DB::table('inscribed')
          ->where('inscribed.students_id','=',$request->input('id')[$x])
          ->update(['final_exam' => $request->input('final_exam')[$x]]);
        
        $total = $students[0]->first_midterm+$students[0]->second_midterm+$students[0]->pratice_score+$students[0]->final_exam;            
        if($total >=65 && $total <=69){
            $literal = 'D';
            $condicion = str_replace($sections[0]->code_subject.'/',"",$students[0]->condition);
            DB::table('students')
        ->where('students.id','=',$request->input('id')[$x])
        ->update(['condition' => $condicion]);
        }elseif ($total >=70 && $total <=79) {
            $literal = 'C';
            $condicion = str_replace($sections[0]->code_subject.'/',"",$students[0]->condition);
            DB::table('students')
            ->where('students.id','=',$request->input('id')[$x])
            ->update(['condition' => $condicion]);
        
        }elseif ($total >=80 && $total <=89) {
            $literal = 'B';
            $condicion = str_replace($sections[0]->code_subject.'/',"",$students[0]->condition);
            DB::table('students')
            ->where('students.id','=',$request->input('id')[$x])
            ->update(['condition' => $condicion]);
        }elseif ($total >=90) {
            $literal = 'A';
            $condicion = str_replace($sections[0]->code_subject.'/',"",$students[0]->condition);
            DB::table('students')
            ->where('students.id','=',$request->input('id')[$x])
            ->update(['condition' => $condicion]);
        }else{
            $literal = 'F';
            $condicion = $students[0]->condition;
            DB::table('students')
            ->where('students.id','=',$request->input('id')[$x])
            ->update(['condition' => $condicion,
                      'inscribed_opportunity' => $students[0]->inscribed_opportunity + 1]);
        }

        DB::table('inscribed')
          ->where('inscribed.students_id','=',$request->input('id')[$x])
          ->update(['score' => $total,
                    'literal' => $literal]);
        }
        session::flash('message', 'las calificaciones del examen final se han puesto correctamente');
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
