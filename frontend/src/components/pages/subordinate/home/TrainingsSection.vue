<template>
  <div>
<!--    <button @click="testFetchAllTrainings" class="btn btn-secondary mb-3">Testar Rota</button>-->
    <TrainingsTable
        :trainings="trainings"
        @enroll-training="enrollTraining"
        @cancel-enrollment="cancelEnrollment"
        @update-status="updateTrainingStatus"
    />
  </div>
</template>

<script>
import TrainingsTable from './TrainingsTable.vue';
import axiosInstance from '@/axiosInstance';
import {ref, onMounted} from 'vue';

export default {
  name: 'TrainingsSection',
  components: {
    TrainingsTable
  },
  setup() {
    const trainings = ref([]);
    const userId = ref(localStorage.getItem('user_id'));

    const fetchAllTrainings = async () => {
      try {
        const response = await axiosInstance.get(`/users/${userId.value}/all-trainings`);
        trainings.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar os treinamentos:', error);
      }
    };

    const testFetchAllTrainings = async () => {
      try {
        const response = await axiosInstance.get(`/users/${userId.value}/all-trainings`);
        console.log('Response:', response.data);
        alert('Requisição bem-sucedida! Verifique o console para ver a resposta.');
      } catch (error) {
        console.error('Erro ao testar a rota:', error);
        alert('Erro ao testar a rota. Verifique o console para mais detalhes.');
      }
    };

    const enrollTraining = async (trainingId) => {
      try {
        await axiosInstance.post(`/trainings/${trainingId}/enroll`);
        fetchAllTrainings(); // Refresh the list after enrollment
        alert('Inscrição realizada com sucesso!');
      } catch (error) {
        console.error('Erro ao inscrever no treinamento:', error);
        alert('Erro ao inscrever no treinamento.');
      }
    };

    const cancelEnrollment = async (trainingId) => {
      try {
        await axiosInstance.post(`/trainings/${trainingId}/cancel-enrollment`);
        fetchAllTrainings(); // Refresh the list after canceling enrollment
        alert('Inscrição cancelada com sucesso!');
      } catch (error) {
        console.error('Erro ao cancelar inscrição no treinamento:', error);
        alert('Erro ao cancelar inscrição no treinamento.');
      }
    };

    const updateTrainingStatus = async (trainingId, status) => {
      try {
        await axiosInstance.post(`/trainings/${trainingId}/update-status`, {status});
        alert('Status atualizado com sucesso!');
      } catch (error) {
        console.error('Erro ao atualizar o status do treinamento:', error);
        alert('Erro ao atualizar o status do treinamento.');
      }
    };

    onMounted(() => {
      fetchAllTrainings();
    });

    return {
      trainings,
      testFetchAllTrainings,
      enrollTraining,
      cancelEnrollment,
      updateTrainingStatus,
    };
  }
};
</script>
