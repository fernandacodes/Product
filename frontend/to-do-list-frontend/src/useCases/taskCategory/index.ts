import { httpClient } from "../../infrastructure/configuration";
import type { UseCaseTaskCategoryView } from "./interface";

export class UseCaseTaskCategoryViewImpl implements UseCaseTaskCategoryView {
  async fetchCategories(): Promise<{ id: number; name: string; color: string }[]> {
    try {
      const categories = await httpClient.get<{ id: number; name: string; color: string }[]>('/task-categories');
      return categories;
    } catch (error) {
      console.error('Error fetching categories:', error);
      throw new Error('Failed to fetch categories');
    }
  }

  async createCategory(name: string, color: string): Promise<{ id: number }> {
    try {
      const newCategory = await httpClient.post<{ id: number }>('/task-categories', { name, color });
      return newCategory;
    } catch (error) {
      console.error('Error creating category:', error);
      throw new Error('Failed to create category');
    }
  }

  async updateCategory(id: number, name: string, color: string): Promise<{ id: number }> {
    try {
      const updatedCategory = await httpClient.put<{ id: number }>(`/task-categories/${id}`, { name, color });
      return updatedCategory;
    } catch (error) {
      console.error('Error updating category:', error);
      throw new Error('Failed to update category');
    }
  }

  async deleteCategory(id: number): Promise<{ message: string }> {
    try {
      const response = await httpClient.delete<{ message: string }>(`/task-categories/${id}`);
      return response;
    } catch (error) {
      console.error('Error deleting category:', error);
      throw new Error('Failed to delete category');
    }
  }
}
