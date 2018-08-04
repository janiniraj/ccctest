<?php namespace App\Http\Controllers\Backend;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Student\StudentRepository;

/**
 * Class StudentController.
 */
class StudentController extends Controller
{
    /**
     * @var StudentRepository
     */
    protected $students;

    /**
     * @param StudentRepository $students
     */
    public function __construct(StudentRepository $students)
    {
        $this->students = $students;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {die("DFdf");
        return view('backend.students.index')
            ->withStudents($this->students->getActivePaginated(25, 'id', 'asc'));;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return view('backend.students.create');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->students->create($request->all());

        return redirect()->route('admin.students.index')->withFlashSuccess(trans('alerts.backend.students.created'));
    }

    /**
     * @param Student              $student
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(Student $student, Request $request)
    {
        return view('backend.students.edit')
            ->withStudent($student);
    }

    /**
     * @param Student              $student
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Student $student, Request $request)
    {
        $this->students->update($student, $request->all());

        return redirect()->route('admin.students.index')->withFlashSuccess(trans('alerts.backend.students.updated'));
    }

    /**
     * @param Student              $student
     * @param Request $request
     *
     * @return mixed
     */
    public function destroy(Student $student, Request $request)
    {
        $this->students->deleteById($student->id);

        return redirect()->route('admin.students.index')->withFlashSuccess(trans('alerts.backend.students.deleted'));
    }
}