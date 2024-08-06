<template>
  <div class="mb-3 row">
    <label :for="id" class="col-sm-3 col-form-label">{{ label }}</label>
    <div class="col-sm-9">
      <textarea
          class="form-control"
          :id="id"
          :rows="rows"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :required="required"
      ></textarea>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormTextarea',
  props: {
    id: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    modelValue: {
      type: String,
      default: ''
    },
    rows: {
      type: Number,
      default: 3
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
