<template>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Gestor</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-chalkboard-teacher"></i> Gerenciar Treinamentos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-users"></i> Gerenciar Subordinados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-file-alt"></i> Relatórios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Configurações</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#" @click.prevent="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
import axiosInstance from '/src/axiosInstance'

export default {
  name: 'NavbarGestor',
  methods: {
    async logout() {
      try {
        await axiosInstance.post('/logout');
        localStorage.removeItem('token');
        delete axiosInstance.defaults.headers.common['Authorization'];
        this.$router.push('/');
      } catch (error) {
        console.error('Error during logout:', error);
      }
    }
  }
}
</script>
