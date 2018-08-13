<?php

namespace App;


use Illuminate\Database\Eloquent\Model;




class Language_quotes extends Model
{
    protected $table = 'language_quotes';
    protected $fillable = ['language','date','time','location'];
}
