<template>
  <button :type="type" :class="buttonClass">
    <i :class="icon"></i> {{ label }}
  </button>
</template>

<script>
export default {
  name: 'FormButton',
  props: {
    type: {
      type: String,
      default: 'button'
    },
    label: {
      type: String,
      required: true
    },
    icon: {
      type: String,
      default: ''
    },
    variant: {
      type: String,
      default: 'primary',
      validator(value) {
        return ['primary', 'success', 'danger', 'warning', 'info', 'light', 'dark'].includes(value);
      }
    }
  },
  computed: {
    buttonClass() {
      return `btn btn-${this.variant} w-100`;
    }
  }
};
</script>

<style scoped>
.btn {
  border-radius: 0.25rem;
}
</style>
