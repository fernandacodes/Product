import type { Task } from "../../business/models/Task";

export interface UseCaseTaskView {
  fetchTasks(): Promise<Task[]>; // Retorna uma lista de objetos Task completos
  createTask(newTask: Task): Promise<Task>; // Criação com base no modelo Task
  updateTask(id: number, updatedTask: Partial<Task>): Promise<Task>; // Atualização com base no modelo Task
  deleteTask(id: number): Promise<{ message: string }>; // Exclusão
  exportTasksToCSV(): Promise<void>; // Exportação para CSV
  exportTasksToPDF(): Promise<void>; // Exportação para PDF
}
