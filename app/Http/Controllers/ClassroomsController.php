<?php

namespace App\Http\Controllers;

use App\Classrooms;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Auth;
use Spatie\Activitylog\Models\Activity;
class ClassroomsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try{
		$classrooms = Classrooms::paginate(8);
		return view('classrooms.classroom', ['classrooms' => $classrooms]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/classrooms');
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try{
		return view('classrooms.create');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/classrooms');
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ClassroomRequest $request) {
		try{
		$classrooms = Classrooms::create([
			'location' => $request['location'],
			'capacity' => $request['capacity'],
		]);

			$userModel = Auth::user();
            $someContentModel = $classrooms;
            activity('Aula')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo :'.$classrooms->location);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;



		return redirect('/classrooms')->with('message', 'Aula creada con exito...');

		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/classrooms');
        }
	}

	public function search(Request $request) {
		try{
		$classroomSearch = \Request::get('classroomSearch');
		$classrooms = Classrooms::where('classrooms.location', 'like', '%' . $classroomSearch . '%')
			->orderBy('classrooms.location')
			->paginate(8);

		return view('classrooms.classroom', ['classrooms' => $classrooms]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/classrooms');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		try{
		$classrooms = Classrooms::find($id);
		return view('classrooms.edit_classroom', ['classrooms' => $classrooms]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/classrooms');
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {

		try{

		$this->validate($request, [
             'location' => 'required',
             'capacity'=>'required|numeric|min:3|max:35',
           ]);

		$classrooms = Classrooms::find($id);
		$classrooms->fill($request->all());
		$classrooms->save();

		$userModel = Auth::user();
            $someContentModel = $classrooms;
            activity('Aula')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Edito :'.$classrooms->location);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

		session::flash('message', 'Aula editada correctamente...');
		return Redirect::to('/classrooms');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/classrooms');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
	
	try {
		Classrooms::destroy($id);
		session::flash('message', 'Aula eliminada correctamente...');

		/*$userModel = Auth::user();
            $someContentModel = $classrooms;
            activity('Aula')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Elimino :'.$classrooms->location);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;*/

		return Redirect::to('/classrooms');
	} 
	catch(\Exception $e) {
        session::flash('message2', 'el aula que intenta eliminar se encuentra asignada en una seccion');
        return redirect('/classrooms');
    }

	}
}
