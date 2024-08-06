<template>
  <div class="mb-3 row">
    <label :for="id" class="col-sm-3 col-form-label">{{ label }}</label>
    <div class="col-sm-9">
      <input
          :type="type"
          class="form-control"
          :id="id"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :required="required"
      >
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    id: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: 'text'
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
