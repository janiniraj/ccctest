<?php namespace App\Http\Controllers\Backend;

use App\Mark;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Mark\MarkRepository;
use App\Repositories\Student\StudentRepository;

/**
 * Class MarkController.
 */
class MarkController extends Controller
{
    /**
     * @var MarkRepository
     */
    protected $marks;

    /**
     * @param MarkRepository $marks
     */
    public function __construct(MarkRepository $marks)
    {
        $this->marks = $marks;
        $this->students = new StudentRepository();
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('backend.marks.index')
            ->withMarks($this->marks->getActivePaginated(25, 'id', 'asc'));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        $students = $this->students->all(['name', 'id'])->pluck('name', 'id');

        return view('backend.marks.create')->with(['students' => $students]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->marks->create($request->all());

        return redirect()->route('admin.marks.index')->withFlashSuccess("Mark Created Successfully.");
    }

    /**
     * @param MarkModel              $mark
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(MarkModel $mark, Request $request)
    {
        return view('backend.marks.edit')
            ->withMark($mark);
    }

    /**
     * @param MarkModel              $mark
     * @param Request $request
     *
     * @return mixed
     */
    public function update(MarkModel $mark, Request $request)
    {
        $this->marks->update($mark, $request->all());

        return redirect()->route('admin.marks.index')->withFlashSuccess("Mark updated Successfully.");
    }

    /**
     * @param MarkModel              $mark
     * @param Request $request
     *
     * @return mixed
     */
    public function destroy(MarkModel $mark, Request $request)
    {
        $this->marks->deleteById($mark->id);

        return redirect()->route('admin.marks.index')->withFlashSuccess("Mark deleted Successfully.");
    }
}