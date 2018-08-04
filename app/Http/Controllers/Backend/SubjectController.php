<?php namespace App\Http\Controllers\Backend;

use App\SubjectModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Subject\SubjectRepository;

/**
 * Class SubjectController.
 */
class SubjectController extends Controller
{
    /**
     * @var SubjectRepository
     */
    protected $subjects;

    /**
     * @param SubjectRepository $subjects
     */
    public function __construct(SubjectRepository $subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('backend.subjects.index')
            ->withSubjects($this->subjects->getActivePaginated(25, 'id', 'asc'));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return view('backend.subjects.create');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->subjects->create($request->all());

        return redirect()->route('admin.subjects.index')->withFlashSuccess("Subject Created Successfully.");
    }

    /**
     * @param SubjectModel              $subject
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(SubjectModel $subject, Request $request)
    {
        return view('backend.subjects.edit')
            ->withSubject($subject);
    }

    /**
     * @param SubjectModel              $subject
     * @param Request $request
     *
     * @return mixed
     */
    public function update(SubjectModel $subject, Request $request)
    {
        $this->subjects->update($subject, $request->all());

        return redirect()->route('admin.subjects.index')->withFlashSuccess("Subject updated Successfully.");
    }

    /**
     * @param SubjectModel              $subject
     * @param Request $request
     *
     * @return mixed
     */
    public function destroy(SubjectModel $subject, Request $request)
    {
        $this->subjects->deleteById($subject->id);

        return redirect()->route('admin.subjects.index')->withFlashSuccess("Subject deleted Successfully.");
    }
}