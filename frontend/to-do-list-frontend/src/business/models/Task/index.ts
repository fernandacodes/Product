import type { TaskCategory } from "../TaskCategory";

export interface Task {
    id: number;
    title?: string;
    description?: string;
    created_at?: string;
    completed_at?: string | null;
    status?: 'pendente' | 'em andamento' | 'concluída';
    task_category_id?: number;
    parent_task_id?: number | null;
    category?: TaskCategory;
    subtasks?: Task[];
    parentTask?: Task;
}
