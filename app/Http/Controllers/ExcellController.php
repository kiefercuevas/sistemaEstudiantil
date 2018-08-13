<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Students;
use Illuminate\Support\Facades\Session;
use Excel;
class ExcellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('students.lista_estudiantes');
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
        $archivo = $request->file('studentList');
        $nombre_original = $archivo->getClientOriginalName();
        $extension =$archivo->getClientOriginalExtension();
        $r1 = Storage::disk('archivos')->put($nombre_original,\File::get($archivo));
        $ruta = storage_path('archivos')."/".$nombre_original;
        
        if($r1){
            $ct=0;
            Excel::selectSheetsByIndex(0)->load($ruta,function($hoja){
                $hoja->each(function($fila){
                
               // $usersemails = Students::where('email','=',$fila->email->fisrt());
                  //if(count($usersemails)==0){
                  $estudiante = new Students;
                  $estudiante->names = $fila->nombre;
                  $estudiante->last_name =$fila->apellidos;
                  $estudiante->career =$fila->carrera;
                  $estudiante->shift =$fila->tanda;
                  $estudiante->condition = $fila->condicion;
                  $estudiante->Period =$fila->periodo;
                  $estudiante->spanish =$fila->notaespanol;
                  $estudiante->math =$fila->notamatematica;
                  $estudiante->save();
                  //}
                });
                

            });
            session::flash('message', 'estudiantes cargados correctamente...');
            return redirect('/home');
        }else{
            session::flash('message', 'Error al subir el archivo...');
            return redirect('/listaEstudiantes');
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
