<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */


Route::get('/', function () {
	return redirect('/login');
});



Auth::routes();

Route::get('home_s', 'HomeController@search');
Route::resource('home', 'HomeController');

Route::get('admin/profile', ['middleware' => 'auth', function () {
    
}]);

//routes manteniemiento estudiante
Route::get('students_s', 'StudentsController@search');
Route::resource('students', 'StudentsController');

//routes mantenimiento empleados
Route::get('employees_s', 'EmployeesController@search');
Route::resource('employees', 'EmployeesController');

//routes para el mantenimiento de profesores
Route::get('teachers_s', 'TeacherController@search');
Route::resource('teachers', 'TeacherController');


//routes mantenimiento aulas
Route::get('classrooms_s', 'ClassroomsController@search');
Route::resource('classrooms', 'ClassroomsController');

//routes mantenimiento periodos academicos
Route::get('academic_periods_s', 'Academic_PeriodsController@search');
Route::resource('academic_periods', 'Academic_PeriodsController');

//routes mantenimiento secciones
Route::get('sections_s', 'SectionsController@search');
Route::resource('sections', 'SectionsController');

//routes mantenimiento de usuarios
Route::resource('users', 'HomeController');

//routes mantenimiento inscribed
Route::resource('inscribed','InscribedController');

//routes mantenimiento historico
 Route::resource('log', 'LogController');

//routes mantenimiento de citas de idiomas
Route::get('ingles', 'IdiomaController@ingles');
Route::get('frances', 'IdiomaController@frances');
Route::name('idioma_create_path')->get('idioma/create', 'IdiomaController@create');
Route::name('idioma_store_path')->post('idioma', 'IdiomaController@store');
Route::name('idioma_edit_path')->get('idioma/{id}/edit', 'IdiomaController@edit');
Route::name('idioma_update_path')->put('idioma/{id}', 'IdiomaController@update');
Route::name('idioma_show_path')->get('idioma/{id}', 'IdiomaController@show');

//routes mantenimiento de Subjects
Route::resource('subjects', 'SubjectController');

//routes calificaciones
Route::resource('qualifications','qualificationContoller');

//routes horarioProfesor
Route::resource('horarioProfesor','HorariosProfesorController');
//routes horariostudent
Route::resource('horariostudent','HorarioStudentController');
//routes materiasProfesor
Route::resource('materiasProfesor','TeacherSubjects');

//route para obtener materias
Route::get('/ajax-teacher',function(){

	$subject_id = Input::get('subject_id');

	$teachers = DB::table('users')
			->join('teachersubjects','users.id','teachersubjects.users_id')
			->where('teachersubjects.subjects_id','=',$subject_id)
			->get();
		return Response::json($teachers);
});

//routes para notas
Route::resource('primerParcial','PrimerParcialController');
Route::resource('segundoParcial','SegundocialController');
Route::resource('practicas','PracticasController');

Route::resource('examenFinal','ExamenFinalController');

//routes para fecha de notas
Route::resource('dates','DatesController');

//route para excell
Route::resource('listaEstudiantes','ExcellController');
