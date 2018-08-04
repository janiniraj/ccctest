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
    {
        return view('backend.students.index')
            ->withStudents($this->students->getActivePaginated(25, 'id', 'asc'));
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

        return redirect()->route('admin.students.index')->withFlashSuccess("Student Created Successfully.");
    }

    /**
     * @param User              $student
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(User $student, Request $request)
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
    public function update(User $student, Request $request)
    {
        $this->students->update($student, $request->all());

        return redirect()->route('admin.students.index')->withFlashSuccess("Student updated Successfully.");
    }

    /**
     * @param Student              $student
     * @param Request $request
     *
     * @return mixed
     */
    public function destroy(User $student, Request $request)
    {
        $this->students->deleteById($student->id);

        return redirect()->route('admin.students.index')->withFlashSuccess("Student deleted Successfully.");
    }
}