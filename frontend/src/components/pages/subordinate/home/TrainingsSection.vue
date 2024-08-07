<template>
  <div>
    <TrainingsTable
        :trainings="trainings"
        @enroll-training="confirmEnrollTraining"
        @cancel-enrollment="confirmCancelEnrollment"
        @update-status="confirmUpdateStatus"
    />
  </div>
</template>

<script>
import TrainingsTable from './TrainingsTable.vue';
import axiosInstance from '@/axiosInstance';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

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
        Swal.fire('Erro', 'Erro ao buscar os treinamentos.', 'error');
      }
    };

    const confirmEnrollTraining = (trainingId) => {
      Swal.fire({
        title: 'Você tem certeza?',
        text: 'Você será inscrito neste treinamento!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, inscrever!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          enrollTraining(trainingId);
        }
      });
    };

    const enrollTraining = async (trainingId) => {
      try {
        await axiosInstance.post(`/trainings/${trainingId}/enroll`);
        fetchAllTrainings(); // Refresh the list after enrollment
        Swal.fire('Sucesso', 'Inscrição realizada com sucesso!', 'success');
      } catch (error) {
        console.error('Erro ao inscrever no treinamento:', error);
        Swal.fire('Erro', 'Erro ao inscrever no treinamento.', 'error');
      }
    };

    const confirmCancelEnrollment = (trainingId) => {
      Swal.fire({
        title: 'Você tem certeza?',
        text: 'Sua inscrição será cancelada!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#999',
        confirmButtonText: 'Sim, cancelar!',
        cancelButtonText: 'Não'
      }).then((result) => {
        if (result.isConfirmed) {
          cancelEnrollment(trainingId);
        }
      });
    };

    const cancelEnrollment = async (trainingId) => {
      try {
        await axiosInstance.post(`/trainings/${trainingId}/cancel-enrollment`);
        fetchAllTrainings(); // Refresh the list after canceling enrollment
        Swal.fire('Sucesso', 'Inscrição cancelada com sucesso!', 'success');
      } catch (error) {
        console.error('Erro ao cancelar inscrição no treinamento:', error);
        Swal.fire('Erro', 'Erro ao cancelar inscrição no treinamento.', 'error');
      }
    };

    const confirmUpdateStatus = (trainingId, currentStatus) => {
      if (currentStatus === 'aproved' || currentStatus === 'reproved') {
        Swal.fire({
          title: 'Você tem certeza?',
          text: 'Ao marcar o status como "aprovado" ou "reprovado" a ação não poderá ser desfeita, o registro de conclusão do treinamento ainda poderá ser visualizado no item de menu "Meu histórico".',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, concluir!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            updateTrainingStatus(trainingId, currentStatus);
          } else {
            fetchAllTrainings(); // Refresh the list to revert changes
          }
        });
      } else {
        updateTrainingStatus(trainingId, currentStatus);
      }
    };

    const updateTrainingStatus = async (trainingId, status) => {
      try {
        await axiosInstance.post(`/trainings/${trainingId}/update-status`, { status });
        fetchAllTrainings(); // Refresh the list after updating the status
        Swal.fire('Sucesso', 'Status atualizado com sucesso!', 'success');
      } catch (error) {
        console.error('Erro ao atualizar o status do treinamento:', error);
        Swal.fire('Erro', 'Erro ao atualizar o status do treinamento.', 'error');
      }
    };

    onMounted(() => {
      fetchAllTrainings();
    });

    return {
      trainings,
      confirmEnrollTraining,
      confirmCancelEnrollment,
      confirmUpdateStatus,
    };
  }
};
</script>
