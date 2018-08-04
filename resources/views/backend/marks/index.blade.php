@extends('layouts.app')


@section ('title', 'Mark Listing')


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Mark List
                        </h4>
                    </div><!--col-->


                </div><!--row-->

                <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Semester Name</th>
                                    <th>Subject Name</th>
                                    <th>Marks</th>
                                    <th>Created Time</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($marks as $oneStudent)
                                    <tr>
                                        <td>{{ $oneStudent->student->name }}</td>
                                        <td>{{ $oneStudent->subject->name }}</td>
                                        <td>{{ config('const.semesters')[$oneStudent->subject->semester_id] }}</td>
                                        <td>{{ $oneStudent->marks }}</td>
                                        <td>{{ $oneStudent->created_at->diffForHumans() }}</td>
                                        <td>
                                            {{ html()->form('delete', route('admin.marks.destroy', $oneStudent->id))->class('pull-right')->open() }}
                                            <button type="submit" class="btn btn-warning">Delete</button>
                                            {{ html()->form()->close() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!--col-->
                </div><!--row-->
                <div class="row">
                    <div class="col-7">
                        <div class="float-left">
                            &emsp;Total {!! $marks->total() !!} Records
                        </div>
                    </div><!--col-->

                    <div class="col-5">

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->
        </div><!--card-->
        <br>
        <a href="{{route('admin.marks.create')}}" class="btn btn-primary">Add Mark</a>
    </div>
@endsection