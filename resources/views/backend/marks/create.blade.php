@extends('layouts.app')
@section('content')
    <div class="container">
        {{ html()->form('POST', route('admin.marks.store'))->class('form-horizontal')->open() }}
        <div class="form-group">

            {{ html()->label('Student')->class('col-md-2 form-control-label')->for('student_id') }}
            {{ html()->select('student_id')
                            ->options($students)
                            ->class('form-control')
                            ->placeholder('Student')
                            ->required() }}
        </div>

        <div class="form-group">

            {{ html()->label('Semester')->class('col-md-2 form-control-label')->for('semester_id') }}
            {{ html()->select('semester_id')
                            ->options(config('const.semesters'))
                            ->class('form-control')
                            ->id('semester_id')
                            ->placeholder('Semester')
                            ->required() }}
        </div>

        <div class="form-group">

            {{ html()->label('Subject')->class('col-md-2 form-control-label')->for('subject_id') }}
            {{ html()->select('subject_id')
                            ->options([])
                            ->class('form-control')
                            ->id('subject_id')
                            ->placeholder('Subject')
                            ->required() }}
        </div>

        <div class="form-group">

            {{ html()->label('Marks')->class('col-md-2 form-control-label')->for('marks') }}
            {{ html()->input('number', 'marks')
                            ->class('form-control')
                            ->placeholder('Maks')
                            ->attribute('maxlength', 191)
                            ->required()
                            ->autofocus() }}
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{route('admin.marks.index')}}" class="btn btn-primary">Back to Listing</a>
        {{ html()->form()->close() }}

    </div>
    <script>
        $(document).ready(function () {
            var defaultSubjectOption = $("#subject_id").html();
            $("#semester_id").on('change', function() {
                var semsterId = $(this).val();
                if(semsterId)
                {
                    $.ajax({
                        url: "<?php echo url('/').'/admin/subjects/get-by-semester/'; ?>"+ semsterId,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function (data) {
                            if(data)
                            {
                                var html = defaultSubjectOption;
                                $.each(data, function (k,v) {
                                    html += '<option value="'+k+'">'+v+'</option>';
                                });
                                $("#subject_id").html(html);
                            }
                            else
                            {
                                $("#subject_id").html(defaultSubjectOption);
                            }
                        }
                    })
                }
                else
                {
                    $("#subject_id").html(defaultSubjectOption);
                }
            });
        })
    </script>
@endsection