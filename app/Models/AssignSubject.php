<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignSubject extends Model
{
    use HasFactory;
    public function student_class(){
        return $this->belongsTo(StudentClass::class,'class_id','id');
    }
 
  public function school_subject(){
        return $this->belongsTo(SchoolSubject::class,'subject_id','id');
    }
    public function students()
    {
        return $this->hasMany(AssignStudent::class, 'class_id', 'class_id');
    }
}
