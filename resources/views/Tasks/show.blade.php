@extends('layouts.app')

@section('content')


<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Welcome, {{ session('user_name') }} 🎉</h3>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
                <a href="#" class="btn btn-info">Enter Time Sheet</a> {{-- Link this later --}}
            </div>
        </div>
        <div class="card-body">
            <h4>Task Details</h4>
            <hr>
            <h4><strong>Title :</strong>{{ $task->title }}</h4>
            <p><strong>Description:</strong> {{ $task->description ?? 'NA' }}</p>
            <p><strong>Start Date:</strong> {{ $task->start_date }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge bg-{{ 
                    $task->status === 'completed' ? 'success' : 
                    ($task->status === 'in-progress' ? 'primary' : 'warning') }}">
                    {{ ucfirst($task->status) }}
                </span>
            </p>
        </div>
    </div>
</div>
@endsection