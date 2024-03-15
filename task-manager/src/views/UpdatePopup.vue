<template>
    <div class="popup-overlay">
      <div class="popup-content">
        <div class="update-form">
          <h2>Редактировать задачу</h2>
          <input type="text" v-model="editedTask.title" placeholder="Название задачи" class="input-field">
          <textarea v-model="editedTask.description" placeholder="Описание задачи" class="textarea-field"></textarea>
          <select v-model="editedTask.status" class="select-field">
            <option value="Todo">Todo</option>
            <option value="InProgress">In Progress</option>
            <option value="Done">Done</option>
          </select>
        </div>
        <button @click="updateTask" class="btn btn-primary m-lg-1">Обновить задачу</button>
        <button @click="cancelEdit" class="btn btn-secondary">Отмена</button>
      </div>
    </div>
</template>

<script>
export default {
    props: ['task'],
    data() {
        return {
            editedTask: { ...this.task }
        };
    },
    methods: {
        updateTask() {
            this.$emit('update-task', { ...this.editedTask });
            this.closePopup();
        },
        cancelEdit() {
            this.closePopup();
        },
        closePopup() {
            this.$emit('close-popup');
        }
    }
};
</script>
