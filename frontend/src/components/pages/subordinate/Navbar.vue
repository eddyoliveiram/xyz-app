<template>
  <div class="wrapper">
    <div class="sidebar">
      <NavHeader :userName="userName" />
      <ul class="nav flex-column">
        <NavItem to="/subordinate/home" icon="fas fa-house" text="Início" />
        <NavItem to="/subordinate/records" icon="fas fa-clock" text="Meu histórico" />
<!--        <NavItem to="#" icon="fas fa-cogs" text="Configurações" />-->
        <LogoutButton @logout="logout" />
      </ul>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import NavHeader from '@/components/layout/NavHeader.vue';
import NavItem from '@/components/layout/NavItem.vue';
import LogoutButton from '@/components/layout/LogoutButton.vue';

export default {
  name: 'NavbarSubordinate',
  components: {
    NavHeader,
    NavItem,
    LogoutButton
  },
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
  background-color: #28a745 !important; /* Cor verde para o link ativo */
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
