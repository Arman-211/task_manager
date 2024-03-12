<template>
    <div class="popup-overlay">
        <div class="popup-content">
            <div class="task-form">
                <h2>Создать новую задачу</h2>
                <input type="text" v-model="newTask.title" placeholder="Название задачи" class="input-field">
                <textarea v-model="newTask.description" placeholder="Описание задачи" class="textarea-field"></textarea>
                <select v-model="newTask.status" class="select-field">
                    <option value="Todo">Todo</option>
                    <option value="InProgress">In Progress</option>
                    <option value="Done">Done</option>
                </select>
            </div>
            <button @click="createTask" class="btn btn-primary">Создать задачу</button>
            <button @click="cancelCreate" class="btn btn-secondary">Отмена</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newTask: {
                title: '',
                description: '',
                status: 'Todo',
                created_at: '',
            },
        };
    },
    methods: {
        createTask() {
            this.$emit('create-task', { ...this.newTask });
            this.closeCreatePopup();
        },
        cancelCreate() {
            this.closeCreatePopup();
        },
        closeCreatePopup() {
            this.$emit('close-create-popup');
        }
    }
};
</script>