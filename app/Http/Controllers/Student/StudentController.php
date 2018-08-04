<?php namespace App\Http\Controllers\Student;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Student\StudentRepository;
use Auth;
use App\Mark;
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
        $this->marks = new Mark();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info()
    {
        $student = Auth::user();

        return view('student.info');
    }

    public function marksInfo()
    {
        $student = Auth::user();

        return view('student.marks-info');
    }

}