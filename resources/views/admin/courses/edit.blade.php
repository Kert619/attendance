@extends('admin.layouts.layout')
@section('title','Courses')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Courses</span></li>
                <li class="breadcrumb-item active">Edit Course</li>
            </ol>
        </nav>
        <hr>
        <form action="{{ route('admin.courses.update', ['id' => $course->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="previous_url" value="{{ old('previous_url', $previousUrl) }}">
            <div class="mb-3">
                <label class="form-label">Course <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="course" autocomplete="off" value="{{ old('course', $course->course) }}">
                @error('course')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Trainor <span class="text-danger">*</span></label>
                <select class="form-select shadow-none rounded-0" name="trainor_id">
                    <option value="" @if(old('trainor_id')=='' ) selected @endif>--Select Trainor--</option>
                    @foreach($trainors as $trainor)
                    <option value="{{ $trainor->id }}" @if($course->trainor_id == $trainor->id) selected @endif>
                        {{ $trainor->fullname }}
                    </option>
                    @endforeach
                </select>
                @error('trainor_id')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                Update Course
            </button>
        </form>
    </div>
</div>
@endsection