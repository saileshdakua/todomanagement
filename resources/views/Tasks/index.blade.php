@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Welcome, {{ session('user_name') }} 🎉</h3>
            <div>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container mt-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Your Tasks</h3>
                </div>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }} </div>

                @endif

                @if($tasks->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->start_date }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                @php
                                $statusColor = match($task->status) {
                                'pending' => 'warning',
                                'in-progress' => 'primary',
                                'completed' => 'success',
                                default => 'secondary',
                                };
                                @endphp

                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst(str_replace('-', ' ', $task->status)) }}
                                </span>

                            </td>
                            <td>{{ $task->description ? $task->description : 'NA' }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this task?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>No tasks found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection