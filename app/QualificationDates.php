<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationDates extends Model
{
    protected $table = 'qualification_dates';
    protected $fillable = [
    'first_midterm_date_from',
    'first_midterm_date_to',
    'second_midterm_date_from',
    'second_midterm_date_to',
    'pratice_score_date_from',
    'pratice_score_date_to',
    'final_exam_date_from',
    'final_exam_date_to'];
}
