export interface UseCaseTaskCategoryView {
    fetchCategories(): Promise<{ id: number; name: string; color: string }[]>; 
    createCategory(name: string, color: string): Promise<{ id: number }>;
    updateCategory(id: number, name: string, color: string): Promise<{ id: number }>;
    deleteCategory(id: number): Promise<{ message: string }>;
  }
  