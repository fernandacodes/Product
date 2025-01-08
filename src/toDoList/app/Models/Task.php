<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',            // Nome da tarefa
        'description',      // Detalhes sobre a tarefa
        'created_at',       // Data e Hora de Criação
        'completed_at',     // Data e Hora de Conclusão (opcional)
        'status',           // Status: pendente, em andamento ou concluída
        'task_category_id', // Chave estrangeira para a categoria
        'parent_task_id',   // Chave estrangeira para a tarefa principal (para subtarefas)
    ];

    /**
     * Relação com a categoria da tarefa.
     */
    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'task_category_id');
    }

    /**
     * Relação com subtarefas.
     */
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    /**
     * Relação com a tarefa principal.
     */
    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }
}
