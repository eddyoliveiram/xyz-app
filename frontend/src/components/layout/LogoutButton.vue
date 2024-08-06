<template>
  <li class="nav-item">
    <a class="nav-link text-start" href="#" @click.prevent="$emit('logout')">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </li>
</template>

<script>
export default {
  name: 'LogoutButton'
};
</script>

<style scoped>
.nav-link {
  color: #fff;
}

.nav-link:hover {
  background-color: #495057;
}

.nav-link.active {
  background-color: #007bff;
}
</style>
