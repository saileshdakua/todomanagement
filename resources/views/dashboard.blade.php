@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Welcome, {{ session('user_name') }} 🎉</h3>
            <div>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary me-2">Add Task</a>
                <button class="btn btn-danger" onclick="logout()">Logout</button>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ session('user_email') }}</p>
            <p><strong>Username:</strong> {{ session('user_name') }}</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function logout() {
        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, Logout!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('logout') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Logged Out",
                            text: response.message,
                            icon: "success",
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('login.form') }}";
                        });
                    }
                });
            }
        });
    }
</script>
@endpush