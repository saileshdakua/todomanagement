@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Welcome, {{ session('user_name') }} 🎉</h3>
            <div>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container mt-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Add Task</h3>
                </div>

                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                            @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                            @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ old('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success">Save Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection