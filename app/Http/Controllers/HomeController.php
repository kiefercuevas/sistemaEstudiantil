<?php

namespace App\Http\Controllers;

use App\Students;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Redirect;


class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try{
		$query = User::orderBy('names', 'asc')->paginate(8);
		return view('home', ['query' => $query]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/home');
    }

		//return view('layouts.landingPage', ['users' => $users]);

	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {

	try{
		
		$users = User::find($id);
		return view('users.edit', ['users' => $users]);
	}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/home');
	}
	}
	public function store(Request $request) {
		
	}

	public function update(Request $request, $id) {
		
		$this->validate($request, [
            'names' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation'=>'required|min:8',
         ]);
		$users = User::find($id);
		$users->names = $request->names;
		$users->last_name = $request->last_name;
		$users->password = bcrypt($request->password);
		if ($request->password == $request->password_confirmation) {
			$users->save();
			session::flash('message', 'Usuario editado correctamente...');
			return Redirect::to('/home');
		}
		
		
 
	}


	public function search(Request $request) {
		try{
		$userType = $request->input('user');
		$data = \Request::get('query');

		if ($userType == 'Estudiante') {
			$query = Students::where('students.names', 'like', '%' . $data . '%')
				->orwhere('students.last_name', 'like', '%' . $data . '%')
				->orderBy('students.names', 'asc')
				->paginate(8);

			return view('students.student', ['studentsList' => $query]);

		} else if ($userType == 'Profesor') {

			$query = DB::table('users')
				->join('rolls', function ($join) {
					$join->on('users.rolls_id', '=', 'rolls.id');
				})
				->where([
					['users.status', '=', 1],
					['rolls.roll', '=', 'Profesor'],
					['users.names', 'like', '%' . $data . '%'],
				])
				->paginate(8);

			return view('teachers.teachers', ['teachersList' => $query]);

		} else {

			$query = DB::table('users')
				->where([
					['users.names', 'like', '%' . $data . '%'],
					['users.status', '=', 1],
					['users.rolls_id', '=', 3],
				])
				->paginate(8);

			return view('employees.employee', ['employees' => $query]);
		}
	}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/home');
		}




}
}