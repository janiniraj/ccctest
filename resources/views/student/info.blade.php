@extends('layouts.app')
@section ('title', 'Info')
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Degree</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $student = Auth::user(); @endphp
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->degree }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-body-->
            </div><!--card-->
            <br>
            <a href="{{route('student.marks-info')}}" class="btn btn-primary">Check Marks</a>
        </div>
    </div>

@endsection