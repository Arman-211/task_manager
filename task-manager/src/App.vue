<template>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark px-4 py-2">
    <router-link class="navbar-brand" to="/">Task Manager</router-link>
    <button class="navbar-toggler" type="button" @click="toggleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" :class="{ 'show': navbarOpen }">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link class="nav-link" to="/">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/task-list">Task Page</router-link>
        </li>
      </ul>
    </div>
  </nav>
  <router-view/>
</template>

<script>
export default {
  data() {
    return {
      navbarOpen: false
    };
  },
  methods: {
    toggleNavbar() {
      this.navbarOpen = !this.navbarOpen;
    }
  }
}
</script>