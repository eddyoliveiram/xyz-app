<template>
  <button class="btn btn-primary btn-sm me-2" @click="$emit('click')">
    <i class="fas fa-edit"></i> Editar
  </button>
</template>

<script>
export default {
  name: 'EditButton',
};
</script>

<style scoped>
.btn-primary {
  border-radius: 0.25rem;
}
</style>
