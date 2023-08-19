<?php

namespace App\Http\Controllers;

use App\Models\Task; // Ditambahkan
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $pageTitle = 'Task List';
        $tasks = Task::all(); // Diperbarui
        return view('tasks.index', [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks,
        ]);
    }
    // code untuk validasi

    public function create()
    {
        $pageTitle = 'Create Task';
        return view('tasks.create', ['pageTitle' => $pageTitle]);
    }

    public function store(Request $request) {
        
    $request->validate([
        'name' => 'required',
        'due_date' => 'required',
        'status' => 'required'
        ],
        $request->all()
    );

        $task = new Task([
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        $task->save();
        return redirect()->route('tasks.index');
        
        // Task::create([
        //     'name' => $request->name,
        //     'detail' => $request->detail,
        //     'due_date' => $request->due_date,
        //     'status' => $request->status,
        // ]);

        // return redirect()->route('tasks.index');
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Task';
        $task = Task::find($id); // Diperbarui
        return view('tasks.edit', ['pageTitle' => $pageTitle, 'task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update([
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);
        // Code untuk melakukan redirect menuju GET /tasks
        return redirect()->route('tasks.index');
    }

    public function delete($id) {
        // menyebutkan judul dari halaman berupa "delete task"
        $pageTitle = "Delete Task";
        // memperoleh data task dengan menggunakan id
        $task = Task::find($id);
        // menghasilkan nilai return berupa file view dengan halaman data task di atas
        return view('tasks.delete', ['pageTitle'=>$pageTitle, 'task'=> $task]);
    }

    public function destroy($id) {
        $task = Task::find($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }

    // Progress
    public function progress()
    {
        $title = 'Task Progress';

        $tasks = Task::all();

        $filteredTasks = $tasks->groupBy('status');
        $tasks = [
            Task::STATUS_NOT_STARTED => $filteredTasks->get(
                Task::STATUS_NOT_STARTED, []
            ),
            Task::STATUS_IN_PROGRESS => $filteredTasks->get(
                Task::STATUS_IN_PROGRESS, []
            ),
            Task::STATUS_IN_REVIEW => $filteredTasks->get(
                Task::STATUS_IN_REVIEW, []
            ),
            Task::STATUS_COMPLETED => $filteredTasks->get(
                Task::STATUS_COMPLETED, []
            ),
        ];

        return view('tasks.progress', [
            'pageTitle' => $title,
            'tasks' => $tasks,
        ]);
    }
}