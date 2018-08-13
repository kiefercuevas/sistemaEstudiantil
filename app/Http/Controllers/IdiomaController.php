<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Redirect;
use App\Http\Requests\Languages_quotes_Request;
use App\Language_quotes;


class IdiomaController extends Controller {
	

	public function ingles(){
		 $language = Language_quotes::orderBy('date','ASC')->where('language','Ingles')->paginate(8);
        return view('languages.index',['language' => $language]);
	}

	public function frances(){
		 $language = Language_quotes::orderBy('date','ASC')->where('language','Frances')->paginate(8);
        return view('languages.index',['language' => $language]);
	}

	public function create()
    {
        $language = Language_quotes::all();
        return view('languages.create', ['language' => $language]);
    }

    public function store(Languages_quotes_Request $request)
    {
        Language_quotes::create([
            'language'=> $request['language'],
            'date' => $request['date'],
            'time' => $request['time'],
            'location' => $request['location'],

        ]);

        return redirect('home')->with('message', 'Cita de '.$request['language'] . 'creada con exito...');
    }

	public function edit($id)
    {
        $language = Language_quotes::find($id);
        return view('languages.edit', ['language' => $language]);
    }

    public function update(Languages_quotes_Request $request, $id)
    {
        $languages = Language_quotes::find($id);
        $languages->fill($request->all());
        $languages->save();
        session::flash('message', 'Cita de '.$request['language'] .' editada correctamente...');
        return Redirect::to('home');
    }

    public function show($id){
    	$language = Language_quotes::find($id);
    	return view('languages.show', ['language' => $language]);
    }

}