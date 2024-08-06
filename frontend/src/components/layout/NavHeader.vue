<template>
  <div>
    <div class="sidebar-header">
      <div class="text-center mb-2">
        <img src="@/assets/logo.png" alt="Logo" class="logo" width="50">
      </div>
      <h5>
        <div>XYZ Treinamentos -</div> Ambiente Administrativo
      </h5>
    </div>
    <div class="text-bg-success mb-4">Usuário: {{ userName }}</div>
  </div>
</template>

<script>
export default {
  name: 'NavHeader',
  props: {
    userName: {
      type: String,
      required: true
    }
  }
};
</script>

<style scoped>
.sidebar-header {
  font-size: 1.5rem;
  text-align: center;
  color: #fff;
  padding-bottom: 20px;
}
</style>
