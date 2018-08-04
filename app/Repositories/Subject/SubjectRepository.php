<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;
use App\Exceptions\GeneralException;
Use App\SubjectModel;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class SubjectRepository.
 */
class SubjectRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = SubjectModel::class;

    /**
     * @return string
     */
    public function model()
    {
        return SubjectModel::class;
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc')
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
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
            $subject = self::MODEL;
            $subject = new $subject();
            $subject->name = $input['name'];
            $subject->email = $input['email'];
            $subject->degree = $input['degree'];

            $subject->password = bcrypt($input['password']);

            if ($subject->save()) {

                // event(new SubjectCreated($Subjects));
                return true;
            }
            throw new GeneralException("Error in creating subject.");
        });
    }

    /**
     * @param Model $subject
     * @param  $input
     *
     * @throws GeneralException
     *
     * return bool
     */
     
    public function update(Model $subject, array $input)
    {
        if ($this->model->where('email', $input['email'])->where('id', '!=', $subject->id)->first()) {
            throw new GeneralException(trans('exceptions.backend.subjects.already_exists'));
        }
        $subject->name = $input['name'];
        $subject->email = $input['email'];
        $subject->degree = $input['degree'];

        if($input['password'])
        {
            $subject->password = bcrypt($input['password']);
        }

        DB::transaction(function () use ($subject, $input) {
        	if ($subject->save()) {
                return true;
            }

            throw new GeneralException("Error in Editing Subject.");
        });
    }

    /**
     * @param Model $subject
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function forceDelete(Model $subject)
    {
        DB::transaction(function () use ($subject) {

            if ($subject->delete()) {
                return true;
            }

            throw new GeneralException("Error in deleting subject.");
        });
    }

}