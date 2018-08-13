<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class TeacherSubjects extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $subjects = DB::table('subjects')
        ->get();
        return view('teachers.teacher_createSubject',['subjects'=>$subjects,'id' => $id]);
        }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
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
        //se declara una variable para guardar todas las materias que pertenescan a ese id de profesor
        $subjectsRegistered = DB::table('teachersubjects')
            ->where('teachersubjects.users_id','=',$id)
            ->get();
        //se declara una variable arreglo para guardar los id de las materias que sean iguales a las ya registradas
        $sameSubject = [];    

        if(count($request->subject_selected) > 0){  //si se selecciono una materia entonces entra a este apartado.
        //mientras x sea menol que la cantidad de materias encontradas de este usuario has lo siguiente
        for($x=0;$x<count($subjectsRegistered);$x++){
            
            //otro for para mientras y sea menol que las materias seleccionadas has lo siguiente
            for($y=0;$y<count($request->subject_selected);$y++){

            /*al ser un for anidado hara el loop con la materiaregistrada[x] empezando de 0
            y verificara que en cada materia seleccionada no halla un id que sea igual a la ya registrada
            si encuentra un id igual entonces has lo siguiente*/    

            if($subjectsRegistered[$x]->subjects_id == $request->subject_selected[$y]){
               
                /*entrame dentro de la variable arreglo que declaramos arriba el id de la materia
                que sea igual a la materia registrada*/
                array_push($sameSubject,$request->subject_selected[$y]);
                }
            }
        }
        /*utilizamos el metodo array_diff el cual elimina posiciones de un arreglo
        entonces al arreglo de materias seleccionadas le eliminamos el arreglo de materias iguales
        esto eliminara todos los id que ya esten registrados dentro de los seleccionados , dejandonos
        solo los ids que no esten registrados*/
            $newSubjects = array_diff($request->subject_selected, $sameSubject);
            sort($newSubjects);//con sor ordenamos el arreglo para que no queden posiciones vacias y empieze desde 0;
            
            /*hacemos otro for mientras x sea menol que la cantidad de materias no registradas
            que se valla sumando*/
            for($x=0;$x<count($newSubjects);$x++){
            
            //aqui creamos un registro por cada materia no registrada que se selecciono
            DB::table('teachersubjects')->insert(
            ['users_id' => $id, 
            'subjects_id' => $newSubjects[$x]]
            );
            }//se envia el mensaje de que se registro correctamente y se vuelve al apartado de materias
            session::flash('message', 'Materias registradas...');
            return redirect('/teachers/'.$id);
            }
            else{//aqui si no se seleciono una materia entonces hace lo mismo de arriba pero con el mensaje no se han hecho cambios
            session::flash('message', 'no se han hecho cambios...');
            return redirect('/teachers/'.$id); 
            }
        }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
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
        $Subject = DB::table('teachersubjects')
        ->where('teachersubjects.id','=',$id);
        $Subject->delete();
        session::flash('message', 'se ha  eliminado la materia del profesor correctamente');
        return redirect('/teachers');
        
        }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
        }
    }
}
