<?php

namespace App\Http\Controllers;

use App\Academic_periods;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic_period_editRequest;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Spatie\Activitylog\Models\Activity;
use Auth;
use Illuminate\Support\Facades\DB;
class Academic_PeriodsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try{
		$academic_periods = Academic_periods::paginate(8);
		return view('academic_periods.academic_period', ['academic_periods' => $academic_periods]);
		}catch(\Exception $e) {
        session::flash('message', 'Error inesperado');
        return redirect('/academic_periods');
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try{
		return view('academic_periods.create');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/academic_periods');
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		try{
		$timeOne = strtotime($request['date_first']);
		$timeTwo = strtotime($request['date_last']);
		$monthOne = date("F", $timeOne);
		$monthTwo = date("F", $timeTwo);

		$thisYear = date("Y");

		//if you can optimize this code do it guys..
		if (($monthOne == 'January' || $monthOne == 'February' || $monthOne == 'March' || $monthOne == 'April') && ($monthTwo == 'January' || $monthTwo == 'February' || $monthTwo == 'March' || $monthTwo == 'April')) {

			$period = $thisYear . '-1';
		} else if (($monthOne == 'May' || $monthOne == 'June' || $monthOne == 'July' || $monthOne == 'August') && ($monthTwo == 'May' || $monthTwo == 'June' || $monthTwo == 'July' || $monthTwo == 'August')) {

			$period = $thisYear . '-2';
		} else if (($monthOne == 'September' || $monthOne == 'October' || $monthOne == 'November' || $monthOne == 'December') && ($monthTwo == 'September' || $monthTwo == 'October' || $monthTwo == 'November' || $monthTwo == 'December')) {

			$period = $thisYear . '-3';
		}

		$aca = Academic_periods::where('academic_period', '=', $period)
			->get();
		if (count($aca) > 0) {
			return redirect('/academic_periods')->with('message', 'Periodo academico ya existe...');
		}

		$this->validate($request, [
			'date_first' => 'required',
			'date_last' => 'required',
			'status' => 'required',

		]);

		
		$Academic_periods = new Academic_periods;

		$Academic_periods->academic_period = $period;
        $Academic_periods->date_first = $request['date_first'];
        $Academic_periods->date_last = $request['date_last'];
        $Academic_periods->status = $request['status'];
		$Academic_periods->save();

		 


			$userModel = Auth::user();
            $someContentModel = $Academic_periods;
            activity('periodo_academico')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Creo :'.$Academic_periods->academic_period);;
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;


		return redirect('/academic_periods')->with('message', 'Periodo academico creado con exito...');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/academic_periods');
        }
	}

	public function search(Request $request) {
		try{
		$academic_periodSearch = \Request::get('academic_periodSearch');
		$academic_periods = Academic_periods::where('academic_periods.academic_period', 'like', '%' . $academic_periodSearch . '%')
			->orderBy('academic_periods.academic_period')
			->paginate(8);

		return view('academic_periods.academic_period', ['academic_periods' => $academic_periods]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/academic_periods');
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
		$academic_periods = Academic_periods::find($id);
		return view('academic_periods.edit_academic_periods', ['academic_periods' => $academic_periods]);
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/academic_periods');
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Academic_period_editRequest $request, $id) {
		try{
		$timeOne = strtotime($request['date_first']);
		$timeTwo = strtotime($request['date_last']);
		$monthOne = date("F", $timeOne);
		$monthTwo = date("F", $timeTwo);

		$thisYear = date("Y");

		//if you can optimize this code do it guys..
		if (($monthOne == 'January' || $monthOne == 'February' || $monthOne == 'March' || $monthOne == 'April') && ($monthTwo == 'January' || $monthTwo == 'February' || $monthTwo == 'March' || $monthTwo == 'April')) {
			$period = $thisYear . '-1';
		} else if (($monthOne == 'May' || $monthOne == 'June' || $monthOne == 'July' || $monthOne == 'August') && ($monthTwo == 'May' || $monthTwo == 'June' || $monthTwo == 'July' || $monthTwo == 'August')) {
			$period = $thisYear . '-2';
		} else if (($monthOne == 'September' || $monthOne == 'October' || $monthOne == 'November' || $monthOne == 'December') && ($monthTwo == 'September' || $monthTwo == 'October' || $monthTwo == 'November' || $monthTwo == 'December')) {
			$period = $thisYear . '-3';
		}

		$academic_periods = Academic_periods::find($id);
		$academic_periods->fill([
			'academic_period' => $period,
			'date_first' => $request['date_first'],
			'date_last' => $request['date_last'],
			'status' => $request['status'],
		]);
		$academic_periods->save();

		$userModel = Auth::user();
            $someContentModel = $academic_periods;
            activity('periodo_academico')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Edito :'.$academic_periods->academic_period);;
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;

		session::flash('message', 'Periodo academico editado correctamente...');
		return Redirect::to('/academic_periods');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/academic_periods');
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
		 Academic_periods::destroy($id);
		session::flash('message', 'Periodo academico eliminado correctamente...');
		
		/*$userModel = Auth::user();
            $someContentModel = $academic_periods;
            activity('periodo_academico')
            ->causedBy($userModel)
            ->performedOn($someContentModel)
            ->log('Usuario:'.Auth::user()->names.',Elimino :'.$academic_periods->academic_period);
            
            $lastLoggedActivity = Activity::all()->last();
            $lastLoggedActivity->subject; //returns an instance of an eloquent model
            $lastLoggedActivity->causer; //returns an instance of your user model
            $lastLoggedActivity->description; //returns 'Look, I logged something'
            $lastLoggedActivity->log_name;*/

		
		return Redirect::to('/academic_periods');
		}catch(\Exception $e) {
        session::flash('message', 'error inesperado');
        return redirect('/academic_periods');
        }
	}
}
