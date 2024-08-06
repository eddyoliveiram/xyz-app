<template>
  <div class="card">

    <div class="card-header">
      <div class="row">
        <div class="col d-flex justify-content-start">
          <TrainingModal :trainingToEdit="trainingToEdit" @training-updated="fetchTrainings" @close-modal="closeModal" />
        </div>
        <div class="col d-flex justify-content-center align-items-center">
          <h5 class="card-title mb-0">Treinamentos</h5>
        </div>
        <div class="col d-flex justify-content-end">
        </div>
      </div>
    </div>

    <div class="card-body">
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
        <tr v-for="(training, index) in paginatedTrainings" :key="training.id">
          <th scope="row">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</th>
          <td>{{ training.title }}</td>
          <td>{{ training.description }}</td>
          <td>{{ training.start_date }}</td>
          <td>{{ training.end_date }}</td>
          <td>
            <button class="btn btn-primary btn-sm me-2" @click="editTraining(training)">
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
    <div class="card-footer text-center">
      <PaginationComp class="mt-2"
                      :totalItems="totalTrainings"
                      :itemsPerPage="itemsPerPage"
                      :currentPage="currentPage"
                      @page-changed="handlePageChange"
      />
    </div>
  </div>

</template>

<script>
import TrainingModal from './TrainingModal.vue';
import PaginationComp from '../pagination/PaginationComp.vue';
import axiosInstance from '@/axiosInstance';
import { ref, computed, onMounted } from 'vue';

export default {
  components: {
    TrainingModal,
    PaginationComp,
  },
  setup() {
    const trainings = ref([]);
    const trainingToEdit = ref(null);
    const currentPage = ref(1);
    const itemsPerPage = ref(7);
    const totalTrainings = ref(0);

    const paginatedTrainings = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value;
      const end = start + itemsPerPage.value;
      return trainings.value.slice(start, end);
    });

    const fetchTrainings = async () => {
      try {
        const response = await axiosInstance.get('/trainings');
        trainings.value = response.data;
        totalTrainings.value = response.data.length;
      } catch (error) {
        console.error('Erro ao buscar os treinamentos:', error);
        alert('Erro ao buscar os treinamentos.');
      }
    };

    const handlePageChange = (page) => {
      currentPage.value = page;
    };

    const editTraining = (training) => {
      trainingToEdit.value = null;
      setTimeout(() => {
        trainingToEdit.value = training;
      }, 0);
    };

    const closeModal = () => {
      trainingToEdit.value = null;
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
      currentPage,
      itemsPerPage,
      totalTrainings,
      paginatedTrainings,
      fetchTrainings,
      handlePageChange,
      editTraining,
      closeModal,
      deleteTraining,
    };
  },
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
