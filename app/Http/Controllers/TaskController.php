<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        return view('tasks.index', [
            'tasks' => Task::latest()->get(),
            'editingTask' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create($this->validatedData($request));

        return redirect()->away('/tasks')->with('success', 'Task added to your list.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.index', [
            'tasks' => Task::latest()->get(),
            'editingTask' => $task,
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $data = $this->validatedData($request);
        $task->update($data);

        return redirect()->away('/tasks')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->away('/tasks')->with('success', 'Task deleted.');
    }

    public function toggle(Task $task): RedirectResponse
    {
        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
            'completed_at' => $task->status === 'completed' ? null : now(),
        ]);

        return redirect()->away('/tasks');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:pending,completed'],
        ]);
    }
}