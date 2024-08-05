<template>
  <div>
    <TrainingModal :trainingToEdit="trainingToEdit" @training-updated="fetchTrainings" />

    <table class="table mt-4">
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
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ training.title }}</td>
        <td>{{ training.description }}</td>
        <td>{{ training.start_date }}</td>
        <td>{{ training.end_date }}</td>
        <td>
          <button class="btn btn-warning btn-sm me-2" @click="editTraining(training)">
            <i class="fas fa-edit"></i> Editar
          </button>
          <button class="btn btn-danger btn-sm" @click="deleteTraining(training.id)">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </td>
      </tr>
      </tbody>
    </table>


  </div>
</template>

<script>
import TrainingModal from './TrainingModal.vue';
import axiosInstance from '@/axiosInstance';
import { ref, onMounted } from 'vue';

export default {
  components: {
    TrainingModal,
  },
  setup() {
    const trainings = ref([]);
    const trainingToEdit = ref(null);

    const fetchTrainings = async () => {
      try {
        const response = await axiosInstance.get('/trainings');
        trainings.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar os treinamentos:', error);
        alert('Erro ao buscar os treinamentos.');
      }
    };

    const openModal = () => {
      trainingToEdit.value = null;
    };

    const editTraining = (training) => {
      trainingToEdit.value = training;
    };

    const deleteTraining = async (id) => {
      if (confirm('Tem certeza que deseja excluir este treinamento?')) {
        try {
          await axiosInstance.delete(`/trainings/${id}`);
          fetchTrainings();
          alert('Treinamento excluído com sucesso!');
        } catch (error) {
          console.error('Erro ao excluir o treinamento:', error);
          alert('Erro ao excluir o treinamento.');
        }
      }
    };

    onMounted(() => {
      fetchTrainings();
    });

    return {
      trainings,
      trainingToEdit,
      fetchTrainings,
      openModal,
      editTraining,
      deleteTraining,
    };
  },
};
</script>

<style scoped>
.table {
  width: 100%;
  margin-top: 1rem;
}
</style>
