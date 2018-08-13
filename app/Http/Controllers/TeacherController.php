<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;
use Auth;
use App\teacherSubjects;
use Validator;
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /*se crea una variable teacherlist la cual llamara al modelo y ordenara los 
        datos que reciba de forma ascendente por el nombre y los paginara de a 8 en
        una tabla*/
        
    public function index()
    {
        try{
        $teachersList = DB::table('rolls')
        ->join('users','rolls.id','=','users.rolls_id')
        ->where('rolls.roll', '=' , 'Profesor')
        ->paginate(8);

        return view('teachers.teachers', ['teachersList' => $teachersList]);
        }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
        }
    }

    public function show($id)
    {
        try{
        $teacherSubjects = DB::table('teachersubjects')
         ->select('teachersubjects.id',
                  'subjects.subject',
                  'subjects.code_subject')
         ->join('subjects','teachersubjects.subjects_id','subjects.id')
         ->join('users','teachersubjects.users_id','users.id')
         ->where('users.id','=',$id)
         ->get();

        
        return view('teachers.teacher_subjects',['subjects'=>$teacherSubjects,'id'=>$id]);

        }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
        }
    }

    
    /*se pasa el parametro request a la funcion,se almacena una peticion get con el nombre del 
    input en el blade de teacherSearch ,luego se almacena una consulta donde se recojen los nombres 
    y los apellidos de los profesores que coincidan con lo de la variable teachersSearch,
    luego se ordenan por nombre del teacher y se hace una paginacion de 8 por tabla*/

    public function search(Request $request){

     }



    /*esta funcion es para cuando se puse el boton crear nos redirija 
      a la vista de creacion de profesores(a la parte de creacion de usuario)*/
    public function create ()
    {
        try{
        $subjects = DB::table('subjects')
        ->get();
        
        
        return view('teachers.teachers_create',['subjects'=>$subjects]);
        }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
        }
    }
    

    public function store(Request $request)
        {
           
        try{

           $validator = Validator::make($request->all(), [
            'names' => 'required',
            'last_name' => 'required',
            'identity_card' => 'required',
            'civil_status' => 'required',
            'email' => 'email|unique:users',
            'personal_phone' => 'required',
            //'cellphone' => 'required',
            //'address' => 'required',
            'gender' => 'required',
            'civil_status' => 'required',
            'password' => 'required',
            'subject_selected' => 'required'

         ]);
        if ($validator->fails()) {
            return redirect('teachers/create')
                        ->withErrors($validator)
                        ->withInput();
        }

            $roll = DB::table('rolls')
            ->where('rolls.roll', '=' , 'Profesor')
            ->get();

            $user= User::create([
			'names' => $request['names'],
			'last_name' => $request['last_name'],
			'email' => $request['email'],
			'personal_phone' => $request['personal_phone'],
			'cellphone' => $request['cellphone'],
			'address' => $request['address'],
			'gender' => $request['gender'],
			'identity_card' => $request['identity_card'],
			'civil_status' => $request['civil_status'],
			'password' => bcrypt($request['password']),
			'status' => $request['status'],
			'rolls_id' => $roll[0]->id,
            ]);
        
            for($x=0;$x<count($request->subject_selected);$x++){
            $subjects = new teachersubjects;
            $subjects->users_id = $user->id;
            $subjects->subjects_id = $request->subject_selected[$x];
            $subjects->save();
            }
           
            $userModel = Auth::user();
            $someContentModel = $user;
            activity('Profesor')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo :'.$user->names.'/'.$user->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

            session::flash('message', 'Profesor creado correctamente...');
            return redirect('/teachers');
        }
        catch(\Exception $e){
            session::flash('message','error');
            return redirect('teachers/create');
        }
        } 


    public function edit($id){
    
    try{
     $users = User::find($id);
        return view('teachers.teachers_edit', ['users' => $users]);

    }catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/teachers');
        }
    }

    public function update(Request $request, $id){

        try{

        $validator = Validator::make($request->all(), [
            'names' => 'required',
            'last_name' => 'required',
            'identity_card' => 'required',
            'civil_status' => 'required',
            'email' => 'email',
            'personal_phone' => 'required',
            //'cellphone' => 'required',
            //'address' => 'required',
            'gender' => 'required',
            'civil_status' => 'required',
            

         ]);
        if ($validator->fails()) {
            return redirect('teachers/'.$id.'/edit')
                        ->withErrors($validator);
        }

        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
       
            $userModel = Auth::user();
            $someContentModel = $user;
            activity('Profesor')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Edito:'.$user->names.'/'.$user->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        session::flash('message', 'Profesor editado correctamente');
        return redirect('/teachers');
        }
        catch(\Exception $e){
            session::flash('message',$e);
            return redirect('/teachers');
        }
       
    }




    public function destroy($id)
    {
    try {
        $user = User::find($id);
        $subjects = DB::table('teachersubjects')
        ->where('teachersubjects.users_id','=',$id)
        ->delete();

        
        $user->delete();

            $userModel = Auth::user();
            $someContentModel = $user;
            activity('Profesor')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Elimino :'.$user->names.'/'.$user->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

        session::flash('message', 'Profesor eliminado correctamente');
        return redirect('/teachers');
 
    } catch(\Exception $e) {
        session::flash('message2', 'el usuario que intenta eliminar se encuentra en una seccion');
        return redirect('/teachers');
    }
        
    }


   



}
