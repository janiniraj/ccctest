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
        DB::transaction(function () use ($input) {
            $subject = self::MODEL;
            $subject = new $subject();
            $subject->name = $input['name'];
            $subject->semester_id = $input['semester_id'];

            if ($subject->save()) {
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
        $subject->name = $input['name'];
        $subject->semester_id = $input['semester_id'];

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

    public function getBySemster($semesterId)
    {
        return $this->model->where('semester_id', $semesterId)->get();
    }
}