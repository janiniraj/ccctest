<?php namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Mark;
use App\SubjectModel;
use Validator;
/**
 * Class AdminController.
 */
class AdminController extends Controller
{
    /**
     * @var AdminRepository
     */
    protected $students;

    /**
     * @param AdminRepository $students
     */
    public function __construct()
    {
        $this->student = new User();
        $this->marks    = new Mark();
        $this->subject  = new SubjectModel();
    }

    /**
     * @return \Illuminate\Contracts\JSON\Factory|\Illuminate\JSON\JSON
     */
    public function studentListing()
    {
        $students = $this->student->where('role', 'student')->get();

        $finalData = [];

        foreach($students as $key => $student)
        {
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

            $finalData[$key] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'degree' => $student->degree,
                'marks' => $markArray
            ];
        }       

        $response = [
            'success' => true,
            'data' => $finalData
        ];

        return response()->json($response);
    }

    /**
     * @return \Illuminate\Contracts\JSON\Factory|\Illuminate\JSON\JSON
     */
    public function studentCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'name' => 'required',
            'password'=> 'required',
            'degree'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Error in Request Validation'
            ]);
        }

        $postData = $request->all();

        $check = $this->student->where('email', $postData['email'])->count();

        if($check > 0)
        {
            return response()->json([
                'success' => false,
                'error' => 'Student Already Exist.'
            ]);
        }

        $flag = $this->student->create([
            'email' => $postData['email'],
            'name' => $postData['name'],
            'password'=> bcrypt($postData['password']),
            'degree'=> $postData['degree']
        ]);

        if($flag)
        {
            $response = [
                'success' => true,
                'message' => 'Student Created Successfully.'
            ];
        }
        else
        {
            $response = [
                'success' => false,
                'message' => 'Error in creating Student.'
            ];
        }

        return response()->json($response);
    }

    /**
     * @return \Illuminate\Contracts\JSON\Factory|\Illuminate\JSON\JSON
     */
    public function studentUpdate($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'name' => 'required',
            'degree'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Error in Request Validation'
            ]);
        }

        $postData = $request->all();

        $student = $this->student->find($id);

        /*$student = $this->student->where('email', $postData['email'])->first();

        if(empty($student))
        {
            return response()->json([
                'success' => false,
                'error' => 'Student does not exist.'
            ]);
        }*/

        $student->email     = $postData['email'];
        $student->name      = $postData['name'];
        $student->degree    = $postData['degree'];

        if(isset($postData['password']) && $postData['password'])
        {
            $student->password = bcrypt($postData['password']);
        }
        

        $flag = $student->save();

        if($flag)
        {
            $response = [
                'success' => true,
                'message' => 'Student Updated Successfully.'
            ];
        }
        else
        {
            $response = [
                'success' => false,
                'message' => 'Error in creating Student.'
            ];
        }

        return response()->json($response);
    }

}