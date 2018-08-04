@extends('layouts.app')


@section ('title', 'Student Listing')


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Subject List
                        </h4>
                    </div><!--col-->


                </div><!--row-->

                <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Semester</th>
                                    <th>Created Time</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($subjects as $oneStudent)
                                    <tr>
                                        <td>{{ $oneStudent->name }}</td>
                                        <td>{{ config('const.semesters')[$oneStudent->semester_id] }}</td>
                                        <td>{{ $oneStudent->created_at->diffForHumans() }}</td>
                                        <td><a href="{{ route('admin.subjects.edit',$oneStudent->id) }}" class="btn btn-primary">Edit</a>
                                            <br><br>
                                            {{ html()->form('delete', route('admin.subjects.destroy', $oneStudent->id))->class('pull-right')->open() }}
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
                            &emsp;Total {!! $subjects->total() !!} Records
                        </div>
                    </div><!--col-->

                    <div class="col-5">

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->
        </div><!--card-->
        <br>
        <a href="{{route('admin.subjects.create')}}" class="btn btn-primary">Add a Subject</a>
    </div>
@endsection