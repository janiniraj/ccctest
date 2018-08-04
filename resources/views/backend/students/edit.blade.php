@extends('layouts.app');
@section('content')
    <div class="container">



        {{ html()->form('PATCH', route('admin.students.update',$student->id) )->class('form-horizontal')->open() }}
        <div class="form-group">

            {{ html()->label('Name')->class('col-md-2 form-control-label')->for('name') }}
            {{ html()->text('name')
                            ->class('form-control')
                            ->placeholder('Name')
                            ->attribute('maxlength', 191)
                            ->required()
                            ->autofocus()
                            ->value($student->name)}}
        </div>

        <div class="form-group">

            {{ html()->label('Email Address')->class('col-md-2 form-control-label')->for('email') }}
            {{ html()->email('email')
                            ->class('form-control')
                            ->placeholder('Email Address')
                            ->required()
                            ->value($student->email)}}
        </div>

        <div class="form-group">

            {{ html()->label('password')->class('col-md-2 form-control-label')->for('password') }}
            {{ html()->password('password')
                            ->class('form-control')
                            ->placeholder('Password')
                            ->attribute('maxlength', 191)
                            ->value("")
                            ->required() }}
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{route('admin.students.index')}}" class="btn btn-primary">Back to Listing</a>
        {{ html()->form()->close() }}

    </div>

@endsection