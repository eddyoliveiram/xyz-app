<template>
  <div class="container" align="left">
    <training-modal @training-updated="fetchTrainings" />
    <training-table :trainings="trainings" @edit-training="openEditModal" @delete-training="deleteTraining" />
  </div>
</template>

<script>
import { ref } from 'vue';
import TrainingModal from '@/components/gestor/TrainingModal.vue';
import TrainingTable from '@/components/gestor/TrainingTable.vue';
import axiosInstance from '@/axiosInstance';

export default {
  name: 'TrainingPage',
  components: {
    TrainingModal,
    TrainingTable,
  },
  setup() {
    const trainings = ref([]);
    const trainingToEdit = ref(null);

    const fetchTrainings = async () => {
      try {
        const response = await axiosInstance.get('/trainings');
        trainings.value = response.data;
      } catch (error) {
        console.error('Erro ao carregar treinamentos:', error);
      }
    };

    const openEditModal = (training) => {
      trainingToEdit.value = training;
      // Trigger modal opening through event or state management
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

    fetchTrainings();

    return {
      trainings,
      fetchTrainings,
      openEditModal,
      deleteTraining,
    };
  },
};
</script>
