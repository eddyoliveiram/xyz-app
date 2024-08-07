<template>
  <table class="table table-striped">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Título</th>
      <th scope="col">Descrição</th>
      <th scope="col">Ações</th>
    </tr>
    </thead>
    <tbody>
    <tr v-if="trainings.length === 0">
      <td colspan="4" class="text-center">Nenhum treinamento cadastrado.</td>
    </tr>
    <tr v-else v-for="(training, index) in trainings" :key="training.id">
      <th scope="row">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</th>
      <td>{{ training.title }}</td>
      <td>{{ training.description }}</td>
      <td>
        <EditButton @click="$emit('edit-training', training)" />
        <DeleteButton :disabled="isProcessing" @click="$emit('delete-training', training.id)" />
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
import EditButton from '@/components/base/EditButton.vue';
import DeleteButton from '@/components/base/DeleteButton.vue';

export default {
  name: 'TrainingTable',
  props: {
    trainings: {
      type: Array,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    itemsPerPage: {
      type: Number,
      required: true
    }
  },
  components: {
    EditButton,
    DeleteButton
  },
  data() {
    return {
      isProcessing: false
    };
  }
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
