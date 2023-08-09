<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['subject', 'grade', 'date_uploaded'];

    public function student(){
    	return $this->belongsTo(User::class, 'user_id','id');
    }

    // public function student_class()
    // {
    //     return $this->belongsTo(StudentClass::class, 'student_classes_id','id');
    // }

    public function assign_subject(){
    	return $this->belongsTo(AssignSubject::class, 'subject','id');
    }
    public function gradeReportCard()
    {
        return $this->hasOne(GradeReportCard::class, 'user_id', 'user_id');
    }
}
