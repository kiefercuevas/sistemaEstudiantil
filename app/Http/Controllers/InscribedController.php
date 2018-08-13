<?php

namespace App\Http\Controllers;

use App\Sections;
use App\Students;
use App\Inscribed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InscribedController extends Controller
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
        // try{
        

        //obteniendo los datos de los select id
        $subject_selected = $request->input('subject_selected');
        //contando los objetos de los checkboxes
        $subjectCount = count($subject_selected);

        //obteniendo id de estudiante
        $id_student = $request->input('id_student');

        $matchedObjects = [];

        $sectionSubjectRegisterPushed = [];

        $sectionSubjectPushed = [];

        $sectionTimePushed = [];
        
            if($subjectCount > 0){

                //validaciones de choques horarios

               
                for ($z=0; $z < $subjectCount; $z++) { 
                    
                    $sectionsTime = DB::table('sections')
                    ->select('sections.id',
                        'sections.section',
                    'sections.day_one',
                    'sections.day_two',
                    'sections.time_first',
                    'sections.time_last',
                    'sections.second_time_first',
                    'sections.second_time_last',
                    'sections.shift')
                    ->where('sections.id', '=', $subject_selected[$z])
                    ->get();                  
                    
                    //dd($sectionsToSelect);
                    
                    array_push($sectionTimePushed, $sectionsTime);

                }


                for ($h=0; $h < count($sectionTimePushed); $h++) { 
                    
                    for ($o=0; $o < count($sectionTimePushed); $o++) { 
                        
                        if(empty($sectionTimePushed[$h][0]->day_two)){
                            if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->time_first == $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->time_last == $sectionTimePushed[$o][0]->time_last && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora');
                                    return redirect('/students/'.$id_student);

                            }else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->time_first == $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->time_last == $sectionTimePushed[$o][0]->second_time_last && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora');
                                    return redirect('/students/'.$id_student);

                            }else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_first >= $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 3');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_last >= $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 4');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_first >= $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->second_time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 5');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_last >= $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->second_time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 6');
                                    return redirect('/students/'.$id_student);

                            }

                         
                        // cuando llegan los 2 dias!!!!!!     
                        }else if(!empty($sectionTimePushed[$h][0]->day_two)){
                            if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->time_first == $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->time_last == $sectionTimePushed[$o][0]->time_last && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora');
                                    return redirect('/students/'.$id_student);

                            }else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->time_first == $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->time_last == $sectionTimePushed[$o][0]->second_time_last && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora');
                                    return redirect('/students/'.$id_student);

                            }else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_first >= $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 3');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_last >= $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 4');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_first >= $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->second_time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 5');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_one == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->time_last >= $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->time_first <= $sectionTimePushed[$o][0]->second_time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 6');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_two == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->second_time_first == $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->second_time_last == $sectionTimePushed[$o][0]->second_time_last && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift){
                                
                                session::flash('message', 'Las secciones seleccionadas 2.1'.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 2.2');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_two == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->second_time_first >= $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->second_time_first <= $sectionTimePushed[$o][0]->second_time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 2.3');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_two == $sectionTimePushed[$o][0]->day_two && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->second_time_last >= $sectionTimePushed[$o][0]->second_time_first && $sectionTimePushed[$h][0]->second_time_last <= $sectionTimePushed[$o][0]->second_time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 2.4');
                                    return redirect('/students/'.$id_student);

                            }else if($sectionTimePushed[$h][0]->day_two == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->second_time_first >= $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->second_time_first <= $sectionTimePushed[$o][0]->time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 2.5');
                                    return redirect('/students/'.$id_student);

                            } else if($sectionTimePushed[$h][0]->day_two == $sectionTimePushed[$o][0]->day_one && $sectionTimePushed[$h][0]->id != $sectionTimePushed[$o][0]->id && $sectionTimePushed[$h][0]->shift == $sectionTimePushed[$h][0]->shift && ($sectionTimePushed[$h][0]->second_time_last >= $sectionTimePushed[$o][0]->time_first && $sectionTimePushed[$h][0]->second_time_last <= $sectionTimePushed[$o][0]->time_last)){
                                
                                session::flash('message', 'Las secciones seleccionadas '.$sectionTimePushed[$h][0]->section.' y '.$sectionTimePushed[$o][0]->section.' tienen la mismas hora 2.6');
                                    return redirect('/students/'.$id_student);

                            }  
                        }

                        // if($sectionSubjectPushed[$h][0]->code_subject == $sectionSubjectPushed[$o][0]->code_subject && $sectionSubjectPushed[$h][0]->id != $sectionSubjectPushed[$o][0]->id){
                            
                        //     session::flash('message', 'Las secciones seleccionadas '.$sectionSubjectPushed[$h][0]->section.' y '.$sectionSubjectPushed[$o][0]->section.' tienen la mismas materias');
                        //     return redirect('/students/'.$id_student);
                        // }
                    }
                } 

                //end validaciones de choques horarios












                //obteniendo las los codigo de secciones registradas
                $registerSubjects = DB::table('inscribed')
                ->select(
                    'inscribed.id',
                    'subjects.code_subject'
                    )
                ->join('sections','inscribed.sections_id','=','sections.id')
                ->join('subjects','sections.subjects_id','=','subjects.id')
                ->where('inscribed.students_id', '=', $id_student)
                ->get();
               
                //selected match subject section
                for ($z=0; $z < $subjectCount; $z++) { 
                    
                    $sectionsToSelect = DB::table('sections')
                    ->select('sections.id','subjects.code_subject','sections.section')
                    ->join('subjects','sections.subjects_id','=','subjects.id')
                    ->where('sections.id', '=', $subject_selected[$z])
                    ->get();                  
                    
                    //dd($sectionsToSelect);
                    
                    array_push($sectionSubjectPushed, $sectionsToSelect);

                }

                for ($h=0; $h < count($sectionSubjectPushed); $h++) { 
                    
                    for ($o=0; $o < count($sectionSubjectPushed); $o++) { 
                        
                        if($sectionSubjectPushed[$h][0]->code_subject == $sectionSubjectPushed[$o][0]->code_subject && $sectionSubjectPushed[$h][0]->id != $sectionSubjectPushed[$o][0]->id){
                            
                            session::flash('message', 'Las secciones seleccionadas '.$sectionSubjectPushed[$h][0]->section.' y '.$sectionSubjectPushed[$o][0]->section.' tienen la mismas materias');
                            return redirect('/students/'.$id_student);
                        }
                    }
                }
                //end obteniendo las los codigo de secciones registradas
                for ($a=0; $a < count($subject_selected); $a++) { 

                   $sectionSubjectId = DB::table('sections')
                    ->join('subjects','sections.subjects_id','=','subjects.id')
                    ->where('sections.id', '=', $subject_selected[$a])
                    ->get(); 

                    array_push($sectionSubjectRegisterPushed, $sectionSubjectId);

                    if(count($registerSubjects) > 0){
                    for ($j=0; $j < count($sectionSubjectRegisterPushed); $j++) { 

                       if($sectionSubjectRegisterPushed[$j][0]->code_subject == $registerSubjects[$a]->code_subject){

                            session::flash('message', 'El estudiante ya esta inscrito en la seccion '.$sectionSubjectRegisterPushed[$j][0]->section);
                            return redirect('/students/'.$id_student);

                       }
                    }
                    //----
                }
                }
                
                
                
                $registerSections = DB::table('inscribed')
                ->join('students','inscribed.students_id','=','students.id')              
                ->where('students.id', '=', $id_student)
                ->get();

                $registerSectionsCount = count($registerSections);
                if($registerSectionsCount > 0){

                    for ($i=0; $i < $registerSectionsCount; $i++) { 

                        for ($x=0; $x < $subjectCount; $x++) { 

                            $sections_quota = DB::table('sections')
                            ->select('sections.id',
                                'sections.section',
                                'sections.quota'
                                )
                            ->where('sections.id', '=', $subject_selected[$x])
                            ->get();
                                    
                           $inscribedStudent = DB::table('inscribed')
                            ->where('inscribed.sections_id', '=', $subject_selected[$x])
                            ->get();

                            
                            if(count($inscribedStudent) == $sections_quota[0]->quota){
                                session::flash('message', 'Sección '.$sections_quota[0]->section.' esta llena...');
                                return redirect('/students/'.$id_student);
                            }
                            if ($registerSections[$i]->sections_id == $subject_selected[$x]) {
                                    //dd($registerSections[$x]->sections_id );
                                  array_push($matchedObjects, $subject_selected[$x]);
                                  session::flash('message', 'Estudiante ya inscrito en esta sección...');
                                  return redirect('/students/'.$id_student);
                            }
                        }


                }
               

                }

                $newSections = array_diff($subject_selected, $matchedObjects);
                
                sort($newSections); 

               for($j=0;$j<count($newSections);$j++){

                    Inscribed::create([
                            'sections_id'=> $newSections[$j],
                            'students_id' => $id_student,
                        ]);

                    session::flash('message', 'Estudiante Inscrito correctamente...');
                }

                return redirect('/students');
            
            }

        
        
        // }catch(\Exception $e) {
        // session::flash('message', 'error inesperado');
        // return redirect('/students');}
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