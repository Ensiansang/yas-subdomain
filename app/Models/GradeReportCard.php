<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeReportCard extends Model
{
    use HasFactory;
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'user_id', 'user_id');
    }
}
