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
                    <h3>Edit Task</h3>
                </div>

                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3 col-lg-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $task->start_date) }}">
                            @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3 col-lg-4">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}">
                            @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3 col-lg-4">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ old('status', $task->status) == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection