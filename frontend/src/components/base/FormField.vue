<template>
  <input
      :type="type"
      class="form-control"
      :id="id"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :required="required"
  >
</template>

<script>
export default {
  name: 'FormField',
  props: {
    type: {
      type: String,
      default: 'text'
    },
    id: {
      type: String,
      required: true
    },
    modelValue: {
      type: [String, Number],
      default: ''
    },
    required: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style scoped>
.form-control {
  border-radius: 0.25rem;
}
</style>
