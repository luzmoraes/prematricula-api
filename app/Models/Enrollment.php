<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    const STATUS_STARTED = 1;
    const STATUS_DONE = 2;
    const STATUS_CANCELED = 3;

    public static $statuses = [
        self::STATUS_STARTED => 'Iniciada',
        self::STATUS_DONE => 'Finalizada',
        self::STATUS_CANCELED => 'Cancelada',
    ];
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
        'student_id', 
        'responsible_id',
        'class',
        'year',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $appends = [
        'status_name'
    ];

    public function student() {
        return $this->hasOne('App\Models\Student');
    }

    public function responsible() {
        return $this->hasOne('App\Models\Responsible');
    }

    /**
     * Get the subperiod type name.
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return $this->status ? self::$statuses[$this->status] : '';
    }
}
