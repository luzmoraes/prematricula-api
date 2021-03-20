<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    /**
     * Male gender
     */
    const GENDER_MALE = 1;

    /**
     * Female gender
     */
    const GENDER_FEMALE = 2;

    /**
     * Student genders slugs.
     *
     * @var array
     */
    public static $genders = [
        self::GENDER_MALE => 'Masculino',
        self::GENDER_FEMALE => 'Feminino',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birthday',
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpf',
        'name',
        'birthday',
        'blood_type',
        'race_color',
        'gender',
        'allergic',
        'allergic_description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'allergic' => 'boolean',
    ];

    /**
     * Get the student's gender name.
     *
     * @return string
     */
    public function getGenderNameAttribute()
    {
        return $this->gender ? self::$genders[$this->gender] : '';
    }

    /**
     * Get the students of the responsible.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsible()
    {
        return $this->hasOne('App\Models\Responsible');
    }
}
