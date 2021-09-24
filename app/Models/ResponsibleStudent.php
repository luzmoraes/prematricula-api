<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleStudent extends Model
{
    protected $table = 'responsible_student';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'responsible_id', 
        'student_id',
        'relationship'
    ];
}
