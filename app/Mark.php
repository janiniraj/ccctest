<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\SubjectModel;

class Mark extends Model
{
    protected $table = 'marks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'subject_id', 'marks'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return mixed
     */
    public function student()
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    /**
     * @return mixed
     */
    public function subject()
    {
        return $this->hasOne(SubjectModel::class, 'id', 'subject_id');
    }

}
