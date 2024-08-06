<template>
  <div class="wrapper">
    <div class="sidebar">
      <div class="sidebar-header">
        <div class="text-center mb-2">
          <img src="@/assets/logo.png" alt="Logo" class="logo" width="50">
        </div>
        <h5>XYZ Treinamentos</h5>
      </div>
      <div class="text-bg-success mb-4">Usuário: {{ userName }}</div>
      <ul class="nav flex-column">

        <li class="nav-item">
          <router-link class="nav-link text-start" to="#"><i class="fas fa-tachometer-alt"></i> Dashboard</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link text-start" to="#"><i class="fas fa-chalkboard-teacher"></i> Meus Treinamentos</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link text-start" to="#"><i class="fas fa-cogs"></i> Configurações</router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link text-start" href="#" @click.prevent="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';

export default {
  name: 'NavbarSubordinate',
  props: {
    userName: {
      type: String,
      required: true
    }
  },
  methods: {
    async logout() {
      try {
        await axiosInstance.post('/logout');
      } catch (error) {
        console.error('Error during logout request:', error);
      } finally {
        localStorage.removeItem('token');
        delete axiosInstance.defaults.headers.common['Authorization'];
        this.$router.push('/');
      }
    }
  }
};
</script>
<style scoped>
body {
  display: flex;
  height: 100vh;
  margin: 0;
}

.wrapper {
  display: flex;
  width: 100%;
}

.sidebar {
  width: 250px;
  background-color: #343a40;
  padding-top: 20px;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  overflow-y: auto;
}

.sidebar .nav-link {
  color: #fff;
}

.sidebar .nav-link:hover {
  background-color: #495057;
}

.sidebar .nav-link.active {
  background-color: #007bff;
}

.sidebar .sidebar-header {
  font-size: 1.5rem;
  text-align: center;
  color: #fff;
  padding-bottom: 20px;
}

.content {
  margin-left: 250px;
  padding: 20px;
  flex-grow: 1;
  overflow-y: auto;
}

.card {
  border: none;
  border-radius: 10px;
}

.card-body {
  padding: 2rem;
}

.card h5 {
  font-size: 1.25rem;
}

.card p {
  font-size: 1rem;
}
</style>