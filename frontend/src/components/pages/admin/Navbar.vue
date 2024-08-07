<template>
  <div class="wrapper">
    <div class="sidebar">
      <NavHeader :userName="userName" :isAdmin="true" />
      <ul class="nav flex-column">
        <NavItem to="#" icon="fas fa-tachometer-alt" text="Dashboard" />
        <NavItem to="/admin/trainings" icon="fas fa-chalkboard-teacher" text="Gerenciar Treinamentos" />
        <NavItem to="/admin/subordinates" icon="fas fa-users" text="Gerenciar Subordinados" />
<!--        <NavItem to="#" icon="fas fa-file-alt" text="Relatórios" />-->
        <!--        <NavItem to="#" icon="fas fa-cogs" text="Configurações" />-->
        <LogoutButton @logout="logout" />
      </ul>
    </div>
  </div>
</template>

<script>
import NavHeader from '@/components/layout/NavHeader.vue';
import NavItem from '@/components/layout/NavItem.vue';
import LogoutButton from '@/components/layout/LogoutButton.vue';
import axiosInstance from '@/axiosInstance';

export default {
  name: 'AdminNavbar',
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
        localStorage.removeItem('is_admin');
        localStorage.removeItem('user_name');
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

.content {
  margin-left: 250px;
  padding: 20px;
  flex-grow: 1;
  overflow-y: auto;
}
</style>
