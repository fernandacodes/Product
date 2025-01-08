import { httpClient } from "../../infrastructure/configuration";
import type { UseCaseTaskView } from "./interface";
import type { Task } from "../../business/models/Task";

export class UseCaseTaskViewImpl implements UseCaseTaskView {
  async fetchTasks(): Promise<Task[]> {
    try {
      const tasks = await httpClient.get<Task[]>('/tasks');
      return tasks;
    } catch (error) {
      console.error('Error fetching tasks:', error);
      throw new Error('Failed to fetch tasks');
    }
  }

  async createTask(newTask: Task): Promise<Task> {
    try {
      console.log(newTask)
      const createdTask = await httpClient.post<Task>('/tasks', newTask);
      return createdTask;
    } catch (error) {
      console.error('Error creating task:', error);
      throw new Error('Failed to create task');
    }
  }

  async updateTask(id: number, updatedTask: Partial<Task>): Promise<Task> {
    try {
      const task = await httpClient.put<Task>(`/tasks/${id}`, updatedTask);
      return task;
    } catch (error) {
      console.error('Error updating task:', error);
      throw new Error('Failed to update task');
    }
  }

  async deleteTask(id: number): Promise<{ message: string }> {
    try {
      const response = await httpClient.delete<{ message: string }>(`/tasks/${id}`);
      return response;
    } catch (error) {
      console.error('Error deleting task:', error);
      throw new Error('Failed to delete task');
    }
  }

  async exportTasksToCSV(): Promise<void> {
    try {
      const response = await httpClient.get<Blob>('/tasks/export/csv');
      const url = window.URL.createObjectURL(new Blob([response]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'tasks.csv');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    } catch (error) {
      console.error('Error exporting tasks to CSV:', error);
      throw new Error('Failed to export tasks to CSV');
    }
  }

  async exportTasksToPDF(): Promise<void> {
    try {
      const response = await httpClient.get<Blob>('/tasks/export/pdf');
      const url = window.URL.createObjectURL(new Blob([response]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'tasks.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    } catch (error) {
      console.error('Error exporting tasks to PDF:', error);
      throw new Error('Failed to export tasks to PDF');
    }
  }
}
