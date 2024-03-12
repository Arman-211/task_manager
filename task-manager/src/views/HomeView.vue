<template>
    <div class="home">
        <div class="container">
            <img alt="Vue logo" src="../assets/logo.png" class="logo">
            <h1 class="title">Добро пожаловать в ваше Vue.js приложение</h1>
            <p class="description">Это пример красивой главной страницы</p>
            <router-link to="/task-list" class="btn btn-dark">Перейти к списку задач</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HomeView',
}
</script>