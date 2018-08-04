<?php namespace App\Repositories\Mark;

use App\Repositories\BaseRepository;
use App\Exceptions\GeneralException;
Use App\Mark;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class MarkRepository.
 */
class MarkRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Mark::class;

    /**
     * @return string
     */
    public function model()
    {
        return Mark::class;
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
            $mark = self::MODEL;
            $mark = new $mark();
            $mark->student_id = $input['student_id'];
            //$mark->semester_id = $input['semester_id'];
            $mark->subject_id = $input['subject_id'];
            $mark->marks = $input['marks'];

            if ($mark->save()) {
                return true;
            }
            throw new GeneralException("Error in creating mark.");
        });
    }

    /**
     * @param Model $mark
     * @param  $input
     *
     * @throws GeneralException
     *
     * return bool
     */

    public function update(Model $mark, array $input)
    {
        $mark->student_id = $input['student_id'];
        //$mark->semester_id = $input['semester_id'];
        $mark->subject_id = $input['subject_id'];
        $mark->marks = $input['marks'];

        DB::transaction(function () use ($mark, $input) {
        	if ($mark->save()) {
                return true;
            }

            throw new GeneralException("Error in Editing Mark.");
        });
    }

    /**
     * @param Model $mark
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function forceDelete(Model $mark)
    {
        DB::transaction(function () use ($mark) {

            if ($mark->delete()) {
                return true;
            }

            throw new GeneralException("Error in deleting mark.");
        });
    }

}