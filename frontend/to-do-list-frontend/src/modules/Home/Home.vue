<template>
  <div class="task-list">
    <h1>Minhas Tarefas</h1>

    <div v-if="tasks.length === 0">
      <p>Não há tarefas. Crie uma nova!</p>
    </div>

    <div v-else>
      <ul>
        <li v-for="task in tasks" :key="task.id">
          <div>
            <h3>{{ task.title }}</h3>
            <p>Status: {{ task.status }}</p>
            <button @click="deleteTask(task.id)">Deletar</button>
          </div>
        </li>
      </ul>
    </div>

    <div>
      <button @click="openModal">Criar Tarefa</button>
    </div>

    <!-- Modal -->
    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal-content">
        <h3>Criar Nova Tarefa</h3>
        <input v-model="newTaskTitle" placeholder="Título da tarefa" />
        <select v-model="newTaskStatus">
          <option v-for="option in statusOptions" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
        <div>
          <button @click="saveTask" :disabled="isSaving">Salvar</button>
          <button @click="closeModal">Cancelar</button>
        </div>
      </div>
    </div>

    <div class="export-buttons">
      <button @click="exportTasks('pdf')" :disabled="tasks.length === 0">Exportar em PDF</button>
      <button @click="exportTasks('csv')" :disabled="tasks.length === 0">Exportar em CSV</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { UseCaseTaskViewImpl } from "../../useCases/tasks";
import { showToast } from "../../dls/components/Toast"; // Importando a função showToast para mostrar as mensagens de toast
import type { Task } from "../../business/models/Task";

const taskService = new UseCaseTaskViewImpl();

const tasks = ref<Task[]>([]);
const newTaskTitle = ref<string>("");
const newTaskStatus = ref<Task["status"]>("pendente"); // Status inicial compatível com o model
const isModalOpen = ref<boolean>(false);
const isSaving = ref<boolean>(false);

const statusOptions = [
  { label: 'Pendente', value: 'pending' },
  { label: 'Em andamento', value: 'in_progress' },
  { label: 'Concluída', value: 'completed' },
];

onMounted(async () => {
  try {
    tasks.value = await taskService.fetchTasks();
  } catch (error) {
    console.error("Erro ao carregar as tarefas", error);
  }
});

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  newTaskTitle.value = "";
  newTaskStatus.value = "pendente"; // Reset para o status padrão
};

const saveTask = async () => {
  if (newTaskTitle.value.trim() && newTaskStatus.value) {
    isSaving.value = true;

    const newTaskPayload: Task = {
      title: newTaskTitle.value,
      status: newTaskStatus.value,
      description: "",
      created_at: new Date().toISOString(),
      completed_at: null,
      task_category_id: null,
      parent_task_id: null,
    };

    try {
      const createdTask = await taskService.createTask(newTaskPayload);
      tasks.value.push(createdTask);

      showToast({
        message: "Tarefa criada com sucesso!",
        title: "Sucesso",
        color: "green",
        position: "top",
        timeout: 3000,
      });

      closeModal();
    } catch (error) {
      showToast({
        message: "Erro ao criar a tarefa.",
        title: "Erro",
        color: "red",
        position: "top",
        timeout: 3000,
      });
    } finally {
      isSaving.value = false;
    }
  } else {
    showToast({
      message: "Por favor, preencha todos os campos!",
      title: "Erro",
      color: "red",
      position: "top",
      timeout: 3000,
    });
  }
};

const deleteTask = async (taskId: number) => {
  try {
    await taskService.deleteTask(taskId);
    tasks.value = tasks.value.filter((task) => task.id !== taskId);
  } catch (error) {
    console.error("Erro ao deletar a tarefa", error);
  }
};

const exportTasks = async (format: "pdf" | "csv") => {
  try {
    const url = format === "pdf" ? "/tasks/export/pdf" : "/tasks/export/csv";

    const response = await fetch(url);
    const blob = await response.blob();
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `tasks.${format}`;
    link.click();
  } catch (error) {
    console.error("Erro ao exportar as tarefas", error);
  }
};
</script>


<style scoped>
.task-list {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

ul {
  list-style-type: none;
  padding-left: 0;
}

li {
  background-color: #f4f4f4;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
}

button {
  margin-left: 10px;
  padding: 5px 10px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

input {
  padding: 5px;
  margin-right: 10px;
}

button:hover {
  background-color: #c0392b;
}

button:active {
  background-color: #e74c3c;
}

.export-buttons {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 20px;
}

button:disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

/* Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  max-width: 400px;
  width: 100%;
}

.modal-content input {
  margin-bottom: 10px;
  width: 100%;
}
</style>
