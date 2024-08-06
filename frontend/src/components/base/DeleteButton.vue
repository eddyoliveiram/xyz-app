<template>
  <button :class="buttonClass" :disabled="disabled" @click="$emit('click')">
    <i class="fas fa-trash"></i> Excluir
  </button>
</template>

<script>
export default {
  name: 'DeleteButton',
  props: {
    disabled: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    buttonClass() {
      return {
        'btn btn-danger btn-sm': true,
        'disabled': this.disabled
      };
    }
  }
};
</script>

<style scoped>
.btn-danger {
  border-radius: 0.25rem;
}
</style>
