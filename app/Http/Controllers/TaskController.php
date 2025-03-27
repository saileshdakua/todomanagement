<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    // Helper to get logged-in user from session token
    private function getAuthenticatedUser()
    {
        $user = User::where('remember_token', session('auth_token'))->first();
        return $user;
    }

    // Show all tasks for the logged-in user
    public function index()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        $tasks = Task::where('user_id', $user->id)->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    // Show form to create a task
    public function create()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        return view('tasks.create');
    }

    // Store task
    public function store(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,completed,in-progress'
        ], [
            'title.required' => 'Task title is required.',
            'start_date.required' => 'Start date is required.',
            'due_date.required' => 'Due date is required.',
            'due_date.after_or_equal' => 'Due date must be after or equal to start date.',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => $request->status
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        $task = Task::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, $id)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        $task = Task::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }


    // Delete task
    public function destroy($id)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        $task = Task::where('id', $id)->where('user_id', $user->id)->first();
        if ($task) {
            $task->delete();
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
        }

        return redirect()->route('tasks.index')->with('error', 'Task not found or unauthorized.');
    }

    public function show($id)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) return redirect('/login')->with('error', 'Unauthorized.');

        $task = Task::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        return view('tasks.show', compact('task'));
    }
}
