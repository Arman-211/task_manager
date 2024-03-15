<template>
  <div class="task-list-page">
    <div class="actions">
      <div>
        <router-link to="/" class="btn btn-primary">Назад к главной странице</router-link>
      </div>
      <div class="create-task-action">
        <button class="btn btn-success" @click="openCreatePopup()">Создать задачу</button>
      </div>
    </div>
    <h2 class="list_task_title">Список задач</h2>
    <div class="status-filter">
      <label for="status">Фильтр по статусу:</label>
      <select id="status" v-model="selectedStatus" @change="filterTasks">
        <option value="all">All</option>
        <option value="Todo">Todo</option>
        <option value="InProgress">In Progress</option>
        <option value="Done">Done</option>
      </select>
    </div>
    <table>
      <thead>
      <tr>
        <th>Название</th>
        <th>Описание</th>
        <th>Статус</th>
        <th>Дата создания задачи</th>
        <th>Действия</th>
      </tr>
      </thead>
      <tbody>
      <tr v-if="isTasksEmpty">
        <td colspan="5">No tasks found.</td>
      </tr>
      <tr v-for="task in filteredTasks" :key="task.id" class="task-item">
        <td>{{ task.title }}</td>
        <td>{{ task.description }}</td>
        <td>
          <span :class="getStatusColor(task.status)"> {{ task.status }}</span>
        </td>
        <td>{{ formatCreatedAt(task.created_at) }}</td>
        <td>
          <button @click="openEditPopup(task)" class="btn btn-primary">Редактировать</button>
          <button @click="deleteTask(task.id)" class="btn btn-danger m-1">Удалить</button>
        </td>
      </tr>
      </tbody>
    </table>
    <updatePopup v-if="selectedTask" :task="selectedTask" @update-task="updateTask"
                 @close-popup="closePopup"></updatePopup>
    <createPopup v-if="showCreatedPopup" @create-task="createTask" @close-create-popup="closeCreatePopup"></createPopup>
  </div>
</template>

<script>
import updatePopup from './UpdatePopup';
import createPopup from './CreatePopup';
import http from '../../http';
import { fetchTasks, createTask, updateTask, deleteTask } from '@/services/taskService';

export default {
  components: {
    updatePopup,
    createPopup,
  },
  data() {
    return {
      tasks: [],
      newTask: {
        title: '',
        description: '',
        status: 'todo',
        created_at: '',
      },
      selectedTask: null,
      showCreatedPopup: false,
      csrfToken: null,
      error: null,
      selectedStatus: 'all'
    };
  },
  mounted() {
    this.fetchCsrfToken();
  },
  created() {
    this.loadTasks();
  },
  methods: {
    fetchCsrfToken() {
      http.get('/csrf-token')
          .then(response => {
            this.csrfToken = response.data.csrf_token;
            http.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
          })
          .catch(error => {
            console.error('Error fetching CSRF token: ', error);
          });
    },
    loadTasks() {
      fetchTasks()
          .then(response => {
            this.tasks = response.data;
          })
          .catch(error => {
            console.error('Error fetching tasks: ', error);
            this.error = 'Ошибка при загрузке задач.';
          });
    },

    createTask(newTask) {
      if (!newTask.title.trim()) {
        return;
      }

      createTask(newTask, this.csrfToken)
          .then(response => {
            this.tasks.push(response.data);
            newTask = {
              title: '',
              description: '',
              status: 'todo',
            };
            this.showCreatedPopup = false;
          })
          .catch(error => {
            console.error('Error creating task: ', error);
            this.error = 'Ошибка при создании задачи.';
          });
    },

    updateTask(updatedTask) {
      updateTask(updatedTask, this.csrfToken)
          .then(() => {
            const index = this.tasks.findIndex(t => t.id === updatedTask.id);
            if (index !== -1) {
              this.tasks.splice(index, 1, updatedTask);
            }
            this.selectedTask = null;
          })
          .catch(error => {
            console.error('Error updating task: ', error);
            this.error = 'Ошибка при обновлении задачи.';
          });
    },

    deleteTask(taskId) {
      deleteTask(taskId)
          .then(() => {
            this.tasks = this.tasks.filter(task => task.id !== taskId);
          })
          .catch(error => {
            console.error('Error deleting task: ', error);
            this.error = 'Ошибка при удалении задачи.';
          });
    },

    closePopup() {
      this.selectedTask = null;
    },
    closeCreatePopup() {
      this.showCreatedPopup = false;
    },
    formatCreatedAt(date) {
      return new Date(date).toLocaleString();
    },
    openEditPopup(task) {
      this.selectedTask = {...task};
    },
    openCreatePopup() {
      this.showCreatedPopup = true;
    },
    getStatusColor(status) {
      if (status === 'InProgress') {
        return 'badge bg-dark';
      } else if (status === 'Done') {
        return 'badge bg-success';
      } else {
        return 'badge bg-warning';
      }
    },
    filterTasks() {
      if (this.selectedStatus === 'all') {
        this.loadTasks();
      } else {
        http.get('/tasks', {
          params: {
            status: this.selectedStatus
          }
        })
            .then(response => {
              this.tasks = response.data;
            })
            .catch(error => {
              console.error('Error fetching filtered tasks: ', error);
              this.error = 'Ошибка при загрузке отфильтрованных задач.';
            });
      }
    }
  },
  computed: {
    filteredTasks() {
      return this.tasks;
    },
    isTasksEmpty() {
      return !this.tasks || this.tasks.length === 0;
    }
  }
};
</script>