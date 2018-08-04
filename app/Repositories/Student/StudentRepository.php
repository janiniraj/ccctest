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
        if ($this->model->where('slug', $input['slug'])->first()) {
            throw new GeneralException(trans('exceptions.backend.students.already_exists'));
        }

        DB::transaction(function () use ($input) {
            $Students = self::MODEL;
            $Students = new $Students();
            $Students->name = $input['name'];
            $Students->slug = $input['slug'];
            $Students->content = $input['content'];

            if ($Students->save()) {

                // event(new StudentCreated($Students));
                return true;
            }
            throw new GeneralException(trans('exceptions.backend.students.create_error'));
        });
    }

    /**
     * @param Model $permission
     * @param  $input
     *
     * @throws GeneralException
     *
     * return bool
     */
     
    public function update(Model $Students, array $input)
    {
        if ($this->model->where('slug', $input['slug'])->where('id', '!=', $Students->id)->first()) {
            throw new GeneralException(trans('exceptions.backend.students.already_exists'));
        }
        $Students->name = $input['name'];
        $Students->slug = $input['slug'];
        $Students->content = $input['content'];

        DB::transaction(function () use ($Students, $input) {
        	if ($Students->save()) {
                // event(new StudentUpdated($Students));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.students.update_error')
            );
        });
    }

    /**
     * @param Model $category
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function forceDelete(Model $category)
    {
        DB::transaction(function () use ($category) {

            if ($category->delete()) {
                // event(new StudentDeleted($category));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.students.delete_error'));
        });
    }

    /**
     * Get Student By Slug
     *
     * @param $slug
     * @return Model|null|object|static
     */
    public function getStudentBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}