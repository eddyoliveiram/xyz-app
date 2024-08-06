<template>
  <div id="app">
    <AdminNavbar v-if="showNavbar && state.isAdmin" :userName="state.userName" />
    <SubordinateNavbar v-if="showNavbar && !state.isAdmin" :userName="state.userName"  />

    <div v-bind:class="{ 'main-content': showNavbar }">
      <router-view />
    </div>
  </div>
</template>

<script>
import AdminNavbar from "@/components/pages/admin/Navbar.vue";
import SubordinateNavbar from "@/components/pages/subordinate/Navbar.vue";
import {computed, reactive, provide} from 'vue';
import {useRoute} from 'vue-router';

export default {
  name: 'App',
  components: {AdminNavbar, SubordinateNavbar},
  setup() {
    const route = useRoute();
    const showNavbar = computed(() => route.path !== '/');
    const isAuthenticated = computed(() => !!localStorage.getItem('token'));

    const state = reactive({
      isAdmin: localStorage.getItem('is_admin') === '1',
      userName: localStorage.getItem('user_name')
    });

    const updateState = () => {
      state.isAdmin = localStorage.getItem('is_admin') === '1';
      state.userName = localStorage.getItem('user_name');
    };

    provide('updateState', updateState);

    return {
      showNavbar,
      isAuthenticated,
      state
    };
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.main-content {
  margin-left: 250px; /* This should match the width of the sidebar */
  padding: 20px;
}
</style>
