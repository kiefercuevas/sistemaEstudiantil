<?php

namespace App\Http\Controllers;

use App\Academic_periods;
use App\Classrooms;
use App\Sections;
use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Validator;
use Spatie\Activitylog\Models\Activity;
use Auth;



class SectionsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		try{
		$section = DB::table('sections')
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
		->get();

		return view('sections.section', ['sections' => $section]);
		}catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/sections');
        }
	}




	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	
	public function create() {
		try{
		$classrooms = Classrooms::all();
		$sections = DB::table('academic_periods')
		->join('sections','academic_periods.id','sections.academic_periods_id')
		->get();
		$academic_periods = Academic_periods::all();
		$subjects = Subjects::all();
		$teachers = DB::table('rolls')
			->join('users','rolls.id', '=','users.rolls_id' )
			->where([
				['users.status','=',1],
				['rolls.roll','=','Profesor']
				])
			->get();
		
		return view('sections.section_create', ['section' => $sections, 'classroom' => $classrooms, 'academic_period' => $academic_periods, 'subject' => $subjects,'teacher'=> $teachers]);
		}catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/sections');
        }
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		try{
        /*para restarle 1 minuto a la hora introducida*/
        $timelast       = $request->input('time_last');
        $secondTimeLast = $request->input('second_time_last');
        $timeToSubtract = 1;

        $timelastHourToSecond       = strtotime($timelast);
        $secondTimelastHourToSecond = strtotime($secondTimeLast);

        $minutesToSubtract = $timeToSubtract * 60;

        $timeLastNewHour       = date('H:i', $timelastHourToSecond - $minutesToSubtract);
        $secondTimelastNewHour = date('H:i', $secondTimelastHourToSecond - $minutesToSubtract);
        /*********************************************************************************/


		$noAsignada = DB::table('classrooms')
			->where('classrooms.location','=','no asignada')
			->get();
		
		$sectionName = DB::table('sections')
				->where('sections.section','=',$request->input('section'))
				->get();

		$acaPeriod = DB::table('academic_periods')
					->where('academic_periods.id','=',$request->input('academic_periods_id'))
					->get();

		$cupo = DB::table('classrooms')
			->where('classrooms.id','=',$request->input('classrooms_id'))
			->get();

		$this->validate($request, [
             			'subjects_id' => 'required',
            			'users_id' => 'required',
            			'shift' => 'required',
            			'classrooms_id' => 'required',
            			'day_one' => 'required',
            			'section' => 'required',
						'quota' => 'required',
						'time_first' => 'required',
						'time_last' => 'required',
						'academic_periods_id' => 'required'
         				]);		

		

		/*si la aula es igual a no asignada y el dia 2 esta vacio*/
				if($noAsignada[0]->id == $request->input('classrooms_id')
				  	&& empty($request->input('day_two'))) 
				   {

					   $this->validate($request, [
             			'subjects_id' => 'required',
            			'users_id' => 'required',
            			'shift' => 'required',
            			'classrooms_id' => 'required',
            			'day_one' => 'required',
            			'section' => 'required',
						'quota' => 'required',
						'time_first' => 'required',
						'time_last' => 'required',
						'academic_periods_id' => 'required'
         				]);
					
			/*si la consulta del nombre de seccion nos regresa algun dato sera mayor que 0 
			si es mayor que 0 entonces pasamos al otro if , si el nombre de la seccion
			introducido es igual al nombre de la seccion de dicha consulta y lo mismo con
			el periodo academico entonces lanzara un mensaje que diga , ya existe una seccion
			con ese nombre el el periodo academico elegido*/

					if(count($sectionName) > 0){
					if($request->input('section') == $sectionName[0]->section
					&& $request->input('academic_periods_id') == $sectionName[0]->academic_periods_id)
					{
						session::flash('message', 'ya existe una seccion con el nombre: '.
						$request->input('section').' en el perido academico '.$acaPeriod[0]->academic_period);


        	 			return redirect('/sections/create')
                        ->withInput();
					}}
					else{

					$seccionCreated = Sections::create([
			
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$request->input('second_time_last'),
				]);

				session::flash('message', 'Sección: '.$seccionCreated->section.' creada correctamente...');
				return redirect("/sections");
					}
				}

			/*para validar el cupo de la seccion no pase a la capacidad del aula*/
				if(count($cupo) > 0){
				if($request->input('quota') > $cupo[0]->capacity &&
					$noAsignada[0]->id != $request->input('classrooms_id')){

						session::flash('message', 'el cupo de la seccion es mayor a la capacidad del aula,
						ingrese un cupo menol o modifique la capacidad del aula');
        	 			return redirect('/sections/create')
                        ->withInput();
					}}
				
				
		
		 /*si la aula es diferente de no asignada y el dia 2 esta vacio*/
				if($noAsignada[0]->id != $request->input('classrooms_id')
				  	&& empty($request->input('day_two'))) {

						  
	  			//para validar si hay una seccion identica
					 $query1 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_one','=',$request->input('day_one'))
					   ->where('sections.time_first','=',$request->input('time_first'))
					   ->where('sections.time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();

				//para validar si hay una seccion igual en otro dia
					$query2 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_two','=',$request->input('day_one'))
					   ->where('sections.second_time_first','=',$request->input('time_first'))
					   ->where('sections.second_time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();

				//para ver si existe una seccion donde su hora de llegada este entre las horas introducidas
				//si existe entonces enviara un mensaje de error.	
					$query3 = DB::table('sections')
						->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
					
					$query4 = DB::table('sections')
						->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
					
					$query5 = DB::table('sections')
						->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
					
					$query6 = DB::table('sections')
						->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

		$profesor1 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.time_first','=',$request->input('time_first'))
		->where('sections.time_last','=',$timeLastNewHour)
		->where('sections.day_one','=',$request->input('day_one'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor2 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->where('sections.second_time_first','=',$request->input('time_first'))
				->where('sections.second_time_last','=',$timeLastNewHour)
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();		

		$profesor3 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();

		$profesor4 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor5 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor6 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();			
		
				$this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'academic_periods_id' => 'required',
         				]);

			
		if(count($profesor1) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor2) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor3) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor4) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor5) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor6) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}



					if(count($query1) > 0)
					{
						session::flash('message', 'ya existe una seccion identica a esta.Codigo Seccion: '.$query1[0]->section.' dias: '.$query1[0]->day_one.' - '.$query1[0]->day_two.' horas: '.$query1[0]->time_first.' / '
						.$query1[0]->time_last.'-'.$query1[0]->second_time_first.' / '.$query1[0]->second_time_last);
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query2) > 0){
						session::flash('message', 'la seccion que intenta ingresar choca con la otra seccion con las mismas horas.Codigo Seccion: '
						.$query2[0]->section.'en las horas: '.$query2[0]->time_first.'-'.$query2[0]->time_last);
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query3) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query3[0]->section);

        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query4) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query4[0]->section);
										
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query5) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query5[0]->section);
										
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query6) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query6[0]->section);
										
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					
					elseif(count($sectionName) > 0){
					if($request->input('section') == $sectionName[0]->section
					&& $request->input('academic_periods_id') == $sectionName[0]->academic_periods_id)
					{
						session::flash('message', 'ya existe una seccion con el nombre: '.
						$request->input('section').' en el perido academico '.$acaPeriod[0]->academic_period);


        	 			return redirect('/sections/create')
                        ->withInput();
					}}
					else
					{

					$seccionCreated =Sections::create([
			
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$request->input('second_time_last'),
				]);
				/*dd($seccionCreated->section);*/

				session::flash('message', 'Sección: '.$seccionCreated->section.' creada correctamente...');
				return redirect("/sections");

					}
	}
			
			$this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
							'day_two' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'second_time_first'=> 'required',
							'second_time_last'=> 'required',
							'quota'=> 'required',
							'academic_periods_id' => 'required'
         				]);

			
			
			
			
			
			
			/* si el dia 2 llega lleno y el aula es igual a no asignada  */
			if($noAsignada[0]->id == $request->input('classrooms_id')
				  	&& !empty($request->input('day_two'))) 
				   {

					   $this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
							'day_two' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'second_time_first'=> 'required',
							'second_time_last'=> 'required',
							'quota'=> 'required',
							'academic_periods_id' => 'required'
         				]);

					if(count($sectionName) > 0){
					if($request->input('section') == $sectionName[0]->section
					&& $request->input('academic_periods_id') == $sectionName[0]->academic_periods_id)
					{
						session::flash('message', 'ya existe una seccion con el nombre: '.
						$request->input('section').' en el perido academico '.$acaPeriod[0]->academic_period);


        	 			return redirect('/sections/create')
                        ->withInput();
					}
					}
					else{

					$seccionCreated = Sections::create([
			
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$secondTimelastNewHour,
				]);

				session::flash('message', 'Sección: '.$seccionCreated->section.' creada correctamente...');
				return redirect("/sections");
					}	 
	}
				
			
				
				
				
				/*si la aula es diferente de no asignada y el dia 2 esta lleno*/
				if($noAsignada[0]->id != $request->input('classrooms_id')
				  	&& !empty($request->input('day_two'))){

					$query1 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_one','=',$request->input('day_one'))
					   ->where('sections.time_first','=',$request->input('time_first'))
					   ->where('sections.time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();


					$query2 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_two','=',$request->input('day_one'))
					   ->where('sections.second_time_first','=',$request->input('time_first'))
					   ->where('sections.second_time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();


					
					$query3 = DB::table('sections')
						->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
						
						
					
					$query4 = DB::table('sections')
						->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						
					
					$query5 = DB::table('sections')
						->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						
					
					$query6 = DB::table('sections')
						->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						


							/*validaciones con el dia 2 y sus horas*/
					$query7 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_two','=',$request->input('day_two'))
					   ->where('sections.second_time_first','=',$request->input('second_time_first'))
					   ->where('sections.second_time_last','=',$secondTimelastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();

					   
					
					


					$query8 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_one','=',$request->input('day_two'))
					   ->where('sections.time_first','=',$request->input('second_time_first'))
					   ->where('sections.time_last','=',$secondTimelastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();

					   

					
					$query9 = DB::table('sections')
						->whereBetween('sections.second_time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						

					
					$query10 = DB::table('sections')
						->whereBetween('sections.second_time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						

					$query11 = DB::table('sections')
						->whereBetween('sections.time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

					
					
					$query12 = DB::table('sections')
						->whereBetween('sections.time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

		$profesor1 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.time_first','=',$request->input('time_first'))
		->where('sections.time_last','=',$timeLastNewHour)
		->where('sections.day_one','=',$request->input('day_one'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor2 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->where('sections.second_time_first','=',$request->input('time_first'))
				->where('sections.second_time_last','=',$timeLastNewHour)
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();		

		$profesor3 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();

		$profesor4 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor5 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor6 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();

		$profesor7 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.second_time_first','=',$request->input('second_time_first'))
		->where('sections.second_time_last','=',$secondTimelastNewHour)
		->where('sections.day_two','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor8 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.time_first','=',$request->input('second_time_first'))
		->where('sections.time_last','=',$secondTimelastNewHour)
		->where('sections.day_one','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor9 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.second_time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_two','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();			   
					
		$profesor10 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.second_time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_two','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();			

		$profesor11 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_one','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();
					

		$profesor12 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_one','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();			

		
				$this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
							'day_two' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'second_time_first'=> 'required',
							'second_time_last'=> 'required',
							'quota'=> 'required',
							'academic_periods_id' => 'required'
         				]);

			
		if(count($profesor1) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor2) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor3) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor4) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor5) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor6) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor7) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor8) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor9) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor10) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor11) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}
		elseif(count($profesor12) > 0)
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections/create')
                        ->withInput();
					}		  

					

					
					/*para validar el cupo de la seccion no pase a la capacidad del aula*/
			if(count($cupo) > 0){
				if($request->input('quota') > $cupo[0]->capacity &&
					$noAsignada[0]->id != $request->input('classrooms_id')){

						session::flash('message', 'el cupo de la seccion es mayor a la capacidad del aula,
						ingrese un cupo menol o modifique la capacidad del aula');
        	 			return redirect('/sections/create')
                        ->withInput();
					}}
					
					if(count($query1) > 0)
					{
						session::flash('message', 'ya existe una seccion identica a esta.Codigo Seccion: '.$query1[0]->section);
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query2) > 0){
						session::flash('message', 'la seccion que intenta ingresar choca con la otra seccion con las mismas horas.Codigo Seccion: '
						.$query2[0]->section.'en las horas: '.$query2[0]->time_first.'-'.$query2[0]->time_last);
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query3) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query3[0]->section.
						  ' en las horas: '.$query3[0]->time_first.'-'.$query3[0]->time_last);

        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query4) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query4[0]->section.
						  ' en las horas: '.$query4[0]->time_first.'-'.$query4[0]->time_last);
										
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query5) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query5[0]->section.
						  ' en las horas: '.$query5[0]->time_first.'-'.$query5[0]->time_last);
										
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query6) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre
						horas con otra seccion.Codigo Seccion: '.$query6[0]->section.
						  ' en las horas: '.$query6[0]->time_first.'-'.$query6[0]->time_last);
										
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query7) > 0){
						
						session::flash('message', 'ya existe una seccion identica a esta.Codigo Seccion: '.$query7[0]->section);
        	 			return redirect('/sections/create')
                        ->withInput();
						
						return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query8) > 0){
						session::flash('message', 'la seccion que intenta ingresar choca con la otra seccion con las mismas horas
						.Codigo Seccion: '
						.$query8[0]->section.'en las horas: '.$query8[0]->time_first.'-'.$query8[0]->time_last);
        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query9) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query9[0]->section.
						  ' en las horas: '.$query9[0]->time_first.'-'.$query9[0]->time_last);

        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query10) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query10[0]->section.
						  ' en las horas: '.$query10[0]->time_first.'-'.$query10[0]->time_last);

        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query11) > 0 ){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query11[0]->section.
						  ' en las horas: '.$query11[0]->time_first.'-'.$query11[0]->time_last);

        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($query12) > 0){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query12[0]->section.
						  ' en las horas: '.$query12[0]->time_first.'-'.$query12[0]->time_last);

        	 			return redirect('/sections/create')
                        ->withInput();
					}
					elseif(count($sectionName) > 0){
					if($request->input('section') == $sectionName[0]->section
					&& $request->input('academic_periods_id') == $sectionName[0]->academic_periods_id)
					{
						session::flash('message', 'ya existe una seccion con el nombre: '.
						$request->input('section').' en el periodo academico '.$acaPeriod[0]->academic_period);


        	 			return redirect('/sections/create')
                        ->withInput();
					}}
					else{
					
					$seccionCreated = Sections::create([
			
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$secondTimelastNewHour,
				]);

				session::flash('message', 'Sección: '.$seccionCreated->section.' creada correctamente...');
				return redirect("/sections");
					}

		}	
				  




	}catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/sections');
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
		$section = Sections::find($id);
		$classrooms = DB::table('classrooms')
		->get();
		$academic_periods = DB::table('academic_periods')
		->get();
		$subjects = DB::table('subjects')
		->get();
		$sectionUsed = DB::table('academic_periods')
		->join('sections','academic_periods.id','sections.academic_periods_id')
		->get(); 
		$teachers = DB::table('rolls')
			->join('users','users.rolls_id', '=', 'rolls.id')
			->where([
				['users.status', '=', 1],
				['rolls.roll', '=', 'Profesor'],
			])
			->get();

		
		return view('sections.section_edit', [
			'section' => $section,
			'classrooms' => $classrooms,
			'academic_periods' => $academic_periods,
			'subjects' => $subjects,
			'teachers' => $teachers,
			'subjects' => $subjects,
			'sectionUseds' => $sectionUsed
		]);
		}catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/sections');
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
		/*para restarle 1 minuto a la hora introducida*/	
		 $timelast =$request->input('time_last');
		 $secondTimeLast = $request->input('second_time_last');
		 $timeToSubtract= 1;
		 
		 $timelastHourToSecond = strtotime($timelast);
		 $secondTimelastHourToSecond = strtotime($secondTimeLast);

		 $minutesToSubtract = $timeToSubtract*60;

		 $timeLastNewHour = date('H:i',$timelastHourToSecond-$minutesToSubtract);
		 $secondTimelastNewHour =date('H:i',$secondTimelastHourToSecond-$minutesToSubtract);
	/*********************************************************************************/
		$noAsignada = DB::table('classrooms')
			->where('classrooms.location','=','no asignada')
			->get();
		
		$sectionName = DB::table('sections')
				->where('sections.section','=',$request->input('section'))
				->get();

		$acaPeriod = DB::table('academic_periods')
					->where('academic_periods.id','=',$request->input('academic_periods_id'))
					->get();
		
		$sameSection = DB::table('sections')
					->where('sections.id','=',$id)
					->where('sections.status','=' ,$request->input('status'))
					->where('sections.time_first','=' ,$request->input('time_first'))
					->where('sections.time_last','=' ,$request->input('time_last'))
					->where('sections.quota','=' ,$request->input('quota'))
					->where('sections.day_one','=' ,$request->input('day_one'))
					->where('sections.day_two','=' ,$request->input('day_two'))
					->where('sections.shift','=' ,$request->input('shift'))
					->where('sections.classrooms_id','=' ,$request->input('classrooms_id'))
					->where('sections.subjects_id','=' ,$request->input('subjects_id'))
					->where('sections.academic_periods_id','=' ,$request->input('academic_periods_id'))
					->where('sections.users_id','=' ,$request->input('users_id'))
					->where('sections.second_time_first','=' ,$request->input('second_time_first'))
					->where('sections.second_time_last','=' ,$request->input('second_time_last'))
					->get();
		
		$cupo = DB::table('classrooms')
			->where('classrooms.id','=',$request->input('classrooms_id'))
			->get();
			
				/*con esta validacion hacemos posible que si no se ha cambiado nada dentro de
				editar entonces que al darle al boton editar funcione correctamente*/
				if(count($sameSection) > 0 && count($sectionName) > 0){
				if($sectionName[0]->id == $id){	

					$sectionCreated = Sections::find($id);
					$sectionCreated->fill($request->all());
        			$sectionCreated->save();

				session::flash('message', 'Sección: '.$sectionCreated->section.' editada correctamente...');
				return redirect("/sections");
					}
				}
				
				if(count($sameSection) > 0){
				if($sameSection[0]->section != $request->input('section') 
				&& $sameSection[0]->id == $id 
				&& count($sectionName) == 0){

					$sectionCreated = Sections::find($id);
					$sectionCreated->fill([
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$request->input('second_time_last')]);
        			$sectionCreated->save();

				session::flash('message', 'Sección: '.$sectionCreated->section.' editada correctamente...');
				return redirect("/sections");
				   }else{
					session::flash('message', 'ya existe una seccion con ese nombre');
					return redirect('/sections'.'/'.$id.'/edit');
				   }
				}
					
		/*para validar el cupo de la seccion no pase a la capacidad del aula*/
				if(count($cupo) > 0){
				if($request->input('quota') > $cupo[0]->capacity &&
					$noAsignada[0]->id != $request->input('classrooms_id')){

						session::flash('message', 'el cupo de la seccion es mayor a la capacidad del aula,
						ingrese un cupo menol o modifique la capacidad del aula');
        	 			return redirect('/sections/create')
                        ->withInput();
					}}

		/*si la aula es igual a no asignada y el dia 2 esta vacio*/
			if($noAsignada[0]->id == $request->input('classrooms_id')
				  	&& empty($request->input('day_two'))) 
				   {

					   $this->validate($request, [
             			'subjects_id' => 'required',
            			'users_id' => 'required',
            			'shift' => 'required',
            			'classrooms_id' => 'required',
            			'day_one' => 'required',
            			'section' => 'required',
						'quota' => 'required',
						'time_first' => 'required',
						'time_last' => 'required',
         				]);
					

				if($sectionName[0]->id == $id){	

					$sectionCreated = Sections::find($id);
					$sectionCreated->fill([
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$request->input('second_time_last')]);
        			$sectionCreated->save();

				session::flash('message', 'Sección: '.$sectionCreated->section.' editada correctamente...');
				return redirect("/sections");
					}
				}
		
		 /*si la aula es diferente de no asignada y el dia 2 esta vacio*/
				if($noAsignada[0]->id != $request->input('classrooms_id')
				  	&& empty($request->input('day_two'))) {

					
	  
					 $query1 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_one','=',$request->input('day_one'))
					   ->where('sections.time_first','=',$request->input('time_first'))
					   ->where('sections.time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();
					   
					   


					$query2 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_two','=',$request->input('day_one'))
					   ->where('sections.second_time_first','=',$request->input('time_first'))
					   ->where('sections.second_time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();
					
					$query3 = DB::table('sections')
						->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
					
					$query4 = DB::table('sections')
						->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
					
					$query5 = DB::table('sections')
						->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
					
					$query6 = DB::table('sections')
						->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
				
		$profesor1 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.time_first','=',$request->input('time_first'))
		->where('sections.time_last','=',$timeLastNewHour)
		->where('sections.day_one','=',$request->input('day_one'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor2 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->where('sections.second_time_first','=',$request->input('time_first'))
				->where('sections.second_time_last','=',$timeLastNewHour)
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();		

		$profesor3 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();

		$profesor4 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor5 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor6 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();			
		
				$this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'academic_periods_id' => 'required',
         				]);

			
		if((count($profesor1) > 0) && ($profesor1[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor2) > 0) && ($profesor2[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor3) > 0) && ($profesor3[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor4) > 0) && ($profesor4[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor5) > 0) && ($profesor5[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor6) > 0) && ($profesor6[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}

					
					
					
					if((count($query1) > 0)  && ($query1[0]->section != $request->input('section')))
					{
					session::flash('message', 'ya existe una seccion identica a esta.Codigo Seccion: '.$query1[0]->section);
        	 			
					return redirect('/sections'.'/'.$id.'/edit')
                    ->withInput();
						}

					elseif((count($query2) > 0)  && ($query2[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar choca con la otra seccion.Codigo Seccion: '
						.$query2[0]->section);
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query3) > 0)  && ($query3[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query3[0]->section);

        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query4) > 0)  && ($query4[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query4[0]->section);
										
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query5) > 0)  && ($query5[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query5[0]->section);
										
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query6) > 0)  && ($query6[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas con
										otra seccion.Codigo Seccion: '.$query6[0]->section);
										
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif($request->input('classrooms_id') != $noAsignada[0]->id)
					{

					$sectionCreated = Sections::find($id);
					$sectionCreated->fill([
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$request->input('second_time_last')]);
        			$sectionCreated->save();

					session::flash('message', 'Sección: '.$sectionCreated->section.' editada correctamente...');
					return redirect("/sections");

					}
	}
	
			
			
			
			
			
			
			
			
			/* si el dia 2 llega lleno y el aula es igual a no asignada  */
			if($noAsignada[0]->id == $request->input('classrooms_id')
				  	&& !empty($request->input('day_two'))) 
				   {

					   
					   
					$this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
							'day_two' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'second_time_first'=> 'required',
							'second_time_last'=> 'required',
							'academic_periods_id' => 'required'
         				]);
					
			if(count($sameSection) > 0 && count($sectionName) > 0){
				if($sectionName[0]->id == $id){	

					$sectionCreated = Sections::find($id);
					$sectionCreated->fill([
			
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$secondTimelastNewHour,
				]);
        			$sectionCreated->save();

				session::flash('message', 'Sección: '.$sectionCreated->section.' editada correctamente...');
				return redirect("/sections");
					}}
	}
				/*para validar el cupo de la seccion no pase a la capacidad del aula*/
				if(count($cupo) > 0){
				if($request->input('quota') > $cupo[0]->capacity &&
					$noAsignada[0]->id != $request->input('classrooms_id')){

						session::flash('message', 'el cupo de la seccion es mayor a la capacidad del aula,
						ingrese un cupo menol o modifique la capacidad del aula');
        	 			return redirect('/sections/create')
                        ->withInput();
					}}
				
				
				
				
				/*si la aula es diferente de no asignada y el dia 2 esta lleno*/
				if($noAsignada[0]->id != $request->input('classrooms_id')
				  	&& !empty($request->input('day_two'))){

					$query1 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_one','=',$request->input('day_one'))
					   ->where('sections.time_first','=',$request->input('time_first'))
					   ->where('sections.time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();


					$query2 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_two','=',$request->input('day_one'))
					   ->where('sections.second_time_first','=',$request->input('time_first'))
					   ->where('sections.second_time_last','=',$timeLastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();


					
					$query3 = DB::table('sections')
						->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();
						
						
					
					$query4 = DB::table('sections')
						->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						
					
					$query5 = DB::table('sections')
						->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						
					
					$query6 = DB::table('sections')
						->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_one'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						


							/*validaciones con el dia 2 y sus horas*/
					$query7 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_two','=',$request->input('day_two'))
					   ->where('sections.second_time_first','=',$request->input('second_time_first'))
					   ->where('sections.second_time_last','=',$secondTimelastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();

					   
					
					


					$query8 = DB::table('sections')
					   ->where('sections.status','=',$request->input('status'))
					   ->where('sections.day_one','=',$request->input('day_two'))
					   ->where('sections.time_first','=',$request->input('second_time_first'))
					   ->where('sections.time_last','=',$secondTimelastNewHour)
					   ->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					   ->where('sections.shift','=',$request->input('shift'))
					   ->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
					   ->get();

					   

					
					$query9 = DB::table('sections')
						->whereBetween('sections.second_time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						

					
					$query10 = DB::table('sections')
						->whereBetween('sections.second_time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_two','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

						

					$query11 = DB::table('sections')
						->whereBetween('sections.time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

					
					
					$query12 = DB::table('sections')
						->whereBetween('sections.time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
						->where('sections.classrooms_id','=',$request->input('classrooms_id'))
					    ->where('sections.shift','=',$request->input('shift'))
					   	->where('sections.day_one','=',$request->input('day_two'))
						->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
						->get();

		$profesor1 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.time_first','=',$request->input('time_first'))
		->where('sections.time_last','=',$timeLastNewHour)
		->where('sections.day_one','=',$request->input('day_one'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor2 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->where('sections.second_time_first','=',$request->input('time_first'))
				->where('sections.second_time_last','=',$timeLastNewHour)
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();		

		$profesor3 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();

		$profesor4 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_one','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor5 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_first',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();
					
		$profesor6 = DB::table('sections')
				->where('sections.users_id','=',$request->input('users_id'))
				->whereBetween('sections.second_time_last',[$request->input('time_first'),$timeLastNewHour])
				->where('sections.day_two','=',$request->input('day_one'))
				->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
				->where('sections.shift','=',$request->input('shift'))
				->get();

		$profesor7 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.second_time_first','=',$request->input('second_time_first'))
		->where('sections.second_time_last','=',$secondTimelastNewHour)
		->where('sections.day_two','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor8 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->where('sections.time_first','=',$request->input('second_time_first'))
		->where('sections.time_last','=',$secondTimelastNewHour)
		->where('sections.day_one','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();

		$profesor9 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.second_time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_two','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();			   
					
		$profesor10 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.second_time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_two','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();			

		$profesor11 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.time_first',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_one','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();
					

		$profesor12 = DB::table('sections')
		->where('sections.users_id','=',$request->input('users_id'))
		->whereBetween('sections.time_last',[$request->input('second_time_first'),$secondTimelastNewHour])
		->where('sections.day_one','=',$request->input('day_two'))
		->where('sections.academic_periods_id','=',$request->input('academic_periods_id'))
		->where('sections.shift','=',$request->input('shift'))
		->get();			

		$this->validate($request, [
             				'subjects_id' => 'required',
            				'users_id' => 'required',
            				'shift' => 'required',
            				'classrooms_id' => 'required',
            				'day_one' => 'required',
							'day_two' => 'required',
            				'section' => 'required',
							'quota' => 'required',
							'time_first' => 'required',
							'time_last' => 'required',
							'second_time_first'=> 'required',
							'second_time_last'=> 'required',
							'quota'=> 'required',
							'academic_periods_id' => 'required'
         				]);
				
			
		if((count($profesor1) > 0) && ($profesor1[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor2) > 0) && ($profesor2[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor3) > 0) && ($profesor3[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor4) > 0) && ($profesor4[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor5) > 0) && ($profesor5[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor6) > 0) && ($profesor6[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor7) > 0) && ($profesor7[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor8) > 0) && ($profesor8[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor9) > 0) && ($profesor9[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor10) > 0) && ($profesor10[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor11) > 0) && ($profesor11[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
		elseif((count($profesor12) > 0) && ($profesor12[0]->section != $request->input('section')))
					{
						session::flash('message', 'el profesor que escogio ya se encuentra en una seccion a la misma hora');
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}		  
					  

					


					

					
					if((count($query1) > 0)  && ($query1[0]->section != $request->input('section')))
					{
						session::flash('message', 'ya existe una seccion identica a esta.Codigo Seccion: '.$query1[0]->section);
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query2) > 0)  && ($query2[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar choca con la otra seccion con las mismas horas.Codigo Seccion: '
						.$query2[0]->section.'en las horas: '.$query2[0]->time_first.'-'.$query2[0]->time_last);
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query3) > 0)  && ($query3[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query3[0]->section.
						  ' en las horas: '.$query3[0]->time_first.'-'.$query3[0]->time_last);

        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query4) > 0)  && ($query4[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query4[0]->section.
						  ' en las horas: '.$query4[0]->time_first.'-'.$query4[0]->time_last);
										
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query5) > 0)  && ($query5[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query5[0]->section.
						  ' en las horas: '.$query5[0]->time_first.'-'.$query5[0]->time_last);
										
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query6) > 0)  && ($query6[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre
						horas con otra seccion.Codigo Seccion: '.$query6[0]->section.
						  ' en las horas: '.$query6[0]->time_first.'-'.$query6[0]->time_last);
										
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query7) > 0)  && ($query7[0]->section != $request->input('section'))){
						
						session::flash('message', 'ya existe una seccion identica a esta.Codigo Seccion: '.$query7[0]->section);
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
						
						return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query8) > 0)  && ($query8[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar choca con la otra seccion con las mismas horas
						.Codigo Seccion: '
						.$query8[0]->section.'en las horas: '.$query8[0]->time_first.'-'.$query8[0]->time_last);
        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query9) > 0)  && ($query9[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query9[0]->section.
						  ' en las horas: '.$query9[0]->time_first.'-'.$query9[0]->time_last);

        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query10) > 0)  && ($query10[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query10[0]->section.
						  ' en las horas: '.$query10[0]->time_first.'-'.$query10[0]->time_last);

        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query11) > 0)  && ($query11[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query11[0]->section.
						  ' en las horas: '.$query11[0]->time_first.'-'.$query11[0]->time_last);

        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif((count($query12) > 0)  && ($query12[0]->section != $request->input('section'))){
						session::flash('message', 'la seccion que intenta ingresar tiene un choque entre horas
						con otra seccion.Codigo Seccion: '.$query12[0]->section.
						  ' en las horas: '.$query12[0]->time_first.'-'.$query12[0]->time_last);

        	 			return redirect('/sections'.'/'.$id.'/edit')
                        ->withInput();
					}
					elseif($request->input('classrooms_id') != $noAsignada[0]->id)
					{

					$sectionCreated = Sections::find($id);
					$sectionCreated->fill([
			
					'shift' => $request->input('shift'),
					'classrooms_id' => $request->input('classrooms_id'),
					'day_one' => $request->input('day_one'),
					'day_two' => $request->input('day_two'),
					'academic_periods_id' => $request->input('academic_periods_id'),
					'time_first' => $request->input('time_first'),
					'subjects_id' => $request->input('subjects_id'),
					'time_last' =>$timeLastNewHour,
					'section' => $request->input('section'),
					'quota' => $request->input('quota'),
					'status' => $request->input('status'),
					'users_id' => $request->input('users_id'),
					'second_time_first'=> $request->input('second_time_first'),
					'second_time_last'=>$secondTimelastNewHour,
				]);
        			$sectionCreated->save();

					session::flash('message', 'Sección: '.$sectionCreated->section.' editada correctamente...');
					return redirect("/sections");

					}
					

		}	
		}catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/sections');
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
		$section = Sections::find($id);
		$section->delete();

		session::flash('message', 'Sección eliminada correctamente...');
		return redirect('/sections');
		}catch(\Exception $e){
            session::flash('message','error inexperado');
            return redirect('/sections');
        }
	}
}
