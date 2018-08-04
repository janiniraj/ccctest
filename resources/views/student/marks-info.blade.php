@extends('layouts.app')
@section ('title', 'Mark Info')
@section('content')
    <div class="container">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">
                                Info
                            </h4>
                        </div><!--col-->


                    </div><!--row-->

                    <div class="row mt-4">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Semester</th>
                                        <th>Subject</th>
                                        <th>Marks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $student = Auth::user(); @endphp
                                    @foreach($student->marks as $mark)
                                        <tr>
                                            <td>{{ config('const.semesters')[$mark->subject->semester_id] }}</td>
                                            <td>{{ $mark->subject->name }}</td>
                                            <td>{{ $mark->marks }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-body-->
            </div><!--card-->
            <br>
            <a href="{{route('student.info')}}" class="btn btn-primary">Check Info</a>
        </div>
    </div>

@endsection