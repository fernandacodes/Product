<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    /**
     * Criar uma nova tarefa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'task_category_id' => 'nullable|exists:task_categories,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
        ]);

        $task = Task::create($request->all());

        return response()->json($task, 201);
    }

    /**
     * Listar todas as tarefas.
     */
    public function index()
    {
        $tasks = Task::with(['category', 'subtasks'])->get();
        return response()->json($tasks);
    }

    /**
     * Atualizar uma tarefa específica.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'task_category_id' => 'nullable|exists:task_categories,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    /**
     * Visualizar uma tarefa específica.
     */
    public function show($id)
    {
        $task = Task::with(['category', 'subtasks'])->findOrFail($id);
        return response()->json($task);
    }

    /**
     * Deletar uma tarefa específica.
     */
    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }

    /**
     * Gerar estatísticas das tarefas.
     */
    public function statistics()
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $averageCompletionTime = Task::whereNotNull('completed_at')
            ->avg(DB::raw('EXTRACT(EPOCH FROM (completed_at - created_at))')) / 3600;

        return response()->json([
            'total_tasks' => $totalTasks,
            'pending_tasks' => $pendingTasks,
            'in_progress_tasks' => $inProgressTasks,
            'completed_tasks' => $completedTasks,
            'average_completion_time_hours' => round($averageCompletionTime, 2),
        ]);
    }

    /**
     * Exportar tarefas para CSV.
     */
    public function exportToCsv()
    {
        $tasks = Task::all();
        $csv = "ID,Title,Description,Status,Created At,Completed At\n";

        foreach ($tasks as $task) {
            $csv .= "{$task->id},{$task->title},{$task->description},{$task->status},{$task->created_at},{$task->completed_at}\n";
        }

        Storage::disk('local')->put('tasks.csv', $csv);
        return response()->download(storage_path('app/tasks.csv'))->deleteFileAfterSend(true);
    }

    /**
     * Exportar tarefas para PDF.
     */
    public function exportToPdf()
    {
        $tasks = Task::all();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('tasks.pdf', compact('tasks'));

        return $pdf->download('tasks.pdf');
    }

    /**
     * Surpresa: Notificações em tempo real com websockets.
     */
}
