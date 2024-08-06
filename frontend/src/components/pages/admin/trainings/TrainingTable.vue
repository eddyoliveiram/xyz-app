<template>
  <table class="table">
    <thead>
    <tr>
      <th>#</th>
      <th>Título</th>
      <th>Descrição</th>
      <th>Data de Início</th>
      <th>Data de Término</th>
      <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(training, index) in trainings" :key="training.id">
      <th scope="row">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</th>
      <td>{{ training.title }}</td>
      <td>{{ training.description }}</td>
      <td>{{ training.start_date }}</td>
      <td>{{ training.end_date }}</td>
      <td>
        <EditButton @click="editTraining(training)" />
        <DeleteButton :disabled="isProcessing" @click="handleDelete(training.id)" />
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
    },
  },
  components: {
    EditButton,
    DeleteButton,
  },
  data() {
    return {
      isProcessing: false
    };
  },
  methods: {
    editTraining(training) {
      this.$emit('edit-training', training);
    },
    async handleDelete(id) {
      if (this.isProcessing) return;
      this.isProcessing = true;
      try {
        await this.deleteTraining(id);
      } finally {
        this.isProcessing = false;
      }
    },
    deleteTraining(id) {
      // Confirm delete
      if (confirm('Tem certeza que deseja excluir este treinamento?')) {
        this.$emit('delete-training', id);
      }
    }
  }
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
