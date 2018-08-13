<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Rolls;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Auth;
class EmployeesController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try{
		$employees = DB::table('rolls')
        ->join('users','rolls.id','=','users.rolls_id')
        ->where('rolls.roll', '=' , 'Empleado')
        ->paginate(8);
		
		return view('employees.employee', ['employees' => $employees]);
		} 
		catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
    }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try{
		$rolls = Rolls::all();
		return view('employees.create', ['rolls' => $rolls]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
    }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateEmployeeRequest $request) {
		try{
		$roll = DB::table('rolls')
            ->where('rolls.roll', '=' , 'Empleado')
            ->get();

		$user =User::create([
			'names' => $request['names'],
			'last_name' => $request['last_name'],
			'email' => $request['email'],
			'office_phone' => $request['office_phone'],
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
			$userModel = Auth::user();
            $someContentModel = $user;
            activity('Empleado')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo :'.$user->names.'/'.$user->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

		return redirect('/employees')->with('message', 'Empleado creado con exito...');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
    }
	}

	public function search(Request $request) {
		try{
		$employeeSearch = \Request::get('employeeSearch');
		$employees = User::where('users.names', 'like', '%' . $employeeSearch . '%')
			->orwhere('users.last_name', 'like', '%' . $employeeSearch . '%')
			->orderBy('users.names')
			->paginate(8);

		return view('employees.employee', ['employees' => $employees]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
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
		$employees = User::find($id);
		return view('employees.edit', ['employees' => $employees]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
    }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id, UpdateEmployeeRequest $request) {

		try{
		$employees = User::find($id);
		$employees->fill($request->all());
		$employees->save();
		
		session::flash('message', 'Empleado editado correctamente...');

		$userModel = Auth::user();
            $someContentModel = $employees;
            activity('Empleado')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Edito :'.$employees->names.'/'.$employees->identity_card);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

		return Redirect::to('/employees');

		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {

		try{
		User::destroy($id);
        session::flash('message', 'Empleado eliminada correctamente...');

        return view('/employees');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/employees');
    }

	}

}