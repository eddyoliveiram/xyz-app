<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col d-flex justify-content-start">
          <TrainingModal :trainingToEdit="trainingToEdit" @training-updated="handleTrainingUpdated" @close-modal="closeModal" />
        </div>
        <div class="col d-flex justify-content-center align-items-center">
          <h5 class="card-title mb-0">Treinamentos</h5>
        </div>
        <div class="col d-flex justify-content-end">
        </div>
      </div>
    </div>
    <div class="card-body">
      <TrainingTable
          :trainings="paginatedTrainings"
          :currentPage="currentPage"
          :itemsPerPage="itemsPerPage"
          @edit-training="editTraining"
          @delete-training="confirmDeleteTraining"
      />
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
import TrainingTable from './TrainingTable.vue';
import PaginationComp from '@/components/common/PaginationComponent.vue';
import axiosInstance from '@/axiosInstance';
import { ref, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';

export default {
  components: {
    TrainingModal,
    TrainingTable,
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
        Swal.fire('Erro', 'Erro ao buscar os treinamentos.', 'error');
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

    const confirmDeleteTraining = (id) => {
      Swal.fire({
        title: 'Você tem certeza?',
        text: 'Você não poderá reverter isso!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#999',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteTraining(id);
        }
      });
    };

    const deleteTraining = async (id) => {
      try {
        await axiosInstance.delete(`/trainings/${id}`);
        fetchTrainings();
        Swal.fire('Excluído!', 'Seu treinamento foi excluído.', 'success');
      } catch (error) {
        console.error('Erro ao excluir o treinamento:', error);
        Swal.fire('Erro', 'Erro ao excluir o treinamento.', 'error');
      }
    };

    const handleTrainingUpdated = () => {
      fetchTrainings();
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
      confirmDeleteTraining,
      handleTrainingUpdated,
    };
  },
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
