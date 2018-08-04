<?php

namespace App\Repositories\Student;

use App\Repositories\BaseRepository;
use App\Exceptions\GeneralException;
use App\User;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class StudentRepository.
 */
class StudentRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param int    $studentd
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($studentd = 25, $orderBy = 'created_at', $sort = 'desc')
    {
        return $this->model
            ->where('role', 'student')
            ->orderBy($orderBy, $sort)
            ->paginate($studentd);
    }

    /**
     * @param array $input
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        if ($this->model->where('email', $input['email'])->first()) {
            throw new GeneralException("Already exist.");
        }

        DB::transaction(function () use ($input) {
            $student = self::MODEL;
            $student = new $student();
            $student->name = $input['name'];
            $student->email = $input['email'];

            $student->password = bcrypt($input['password']);

            if ($student->save()) {

                // event(new StudentCreated($Students));
                return true;
            }
            throw new GeneralException("Error in creating student.");
        });
    }

    /**
     * @param Model $student
     * @param  $input
     *
     * @throws GeneralException
     *
     * return bool
     */
     
    public function update(Model $student, array $input)
    {
        if ($this->model->where('email', $input['email'])->where('id', '!=', $student->id)->first()) {
            throw new GeneralException(trans('exceptions.backend.students.already_exists'));
        }
        $student->name = $input['name'];
        $student->email = $input['email'];

        if($input['password'])
        {
            $student->password = bcrypt($input['password']);
        }

        DB::transaction(function () use ($student, $input) {
        	if ($student->save()) {
                return true;
            }

            throw new GeneralException("Error in Editing Student.");
        });
    }

    /**
     * @param Model $student
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function forceDelete(Model $student)
    {
        DB::transaction(function () use ($student) {

            if ($student->delete()) {
                return true;
            }

            throw new GeneralException("Error in deleting student.");
        });
    }

}