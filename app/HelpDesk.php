<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpDesk extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'message', 'status'];
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
}
