<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialDocument extends Model
{
    use HasFactory;
    protected $fillable = ['document_name', 'description', 'file_path', 'date_uploaded'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
