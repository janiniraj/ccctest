<?php namespace App\Http\Controllers\API;

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
     * @return \Illuminate\Contracts\JSON\Factory|\Illuminate\JSON\JSON
     */
    public function info()
    {
        $student = Auth::user();

        $marks = $student->marks;

        $markArray = [];

        foreach($marks as $singleKey => $singleValue)
        {
            $markArray[$singleKey] = [
                "id" => $singleValue->id,
                "semester_id" => config('const.semesters')[$singleValue->subject->semester_id],
                "subject_id" => $singleValue->subject->name,
                "marks" => $singleValue->marks,
                "created_at" => $singleValue->created_at,
            ];
        }

        $finalData = [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'degree' => $student->degree,
            'marks' => $markArray
        ];

        return response()->json($finalData);
    }

}