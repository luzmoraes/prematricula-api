<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'allergic' => 'boolean',
        'active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birthday',
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
        'birthday',
        'blood_type',
        'race_color',
        'allergic',
        'allergic_description',
        'cep',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'authorized_responsibilities',
        'active'
    ];

    public function responsibles(){
        return $this->belongsToMany('App\Models\Responsible', 'responsible_student')->withPivot('relationship');
    }

    public function enrollment(){
        return $this->belongsToMany('App\Models\Enrollment');
    }

}
