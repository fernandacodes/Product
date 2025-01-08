import type { Task } from "../Task";

export interface TaskCategory {
    id: number;
    name: string;
    color: string;
    tasks?: Task[];
  }
  