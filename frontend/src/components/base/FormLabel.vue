<template>
  <label :for="forId" class="form-label">{{ label }}</label>
</template>

<script>
export default {
  name: 'FormLabel',
  props: {
    forId: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    }
  }
};
</script>
