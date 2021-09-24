<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsible extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'cpf',
        'rg',
        'email',
        'cep',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
        'nationality',
        'profession',
        'active'
    ];

    public function students(){
        return $this->belongsToMany('App\Models\Student', 'responsible_student')->withPivot('relationship');
    }

    public function enrollment(){
        return $this->belongsToMany('App\Models\Enrollment');
    }
}
