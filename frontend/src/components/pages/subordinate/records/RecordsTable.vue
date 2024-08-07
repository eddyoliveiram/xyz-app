<template>
  <div class="card mt-4">
    <div class="card-body">
      <h5 class="card-title mb-4">Histórico de Treinamentos Concluídos</h5>
      <table class="table table-striped">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Título</th>
          <th scope="col">Descrição</th>
          <th scope="col">Resultado</th>
          <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="trainings.length === 0">
          <td colspan="5" class="text-center">Nenhum treinamento concluído até o momento.</td>
        </tr>
        <tr v-else v-for="(training, index) in trainings" :key="training.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ training.title }}</td>
          <td>{{ training.description }}</td>
          <td :class="getStatusClass(training.pivot.status)">
            {{ getStatusText(training.pivot.status) }}
          </td>
          <td>
            <button @click="viewDetails(training)" class="btn btn-primary btn-sm">
              <i class="fa fa-search" aria-hidden="true"></i> Ver Detalhes
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailsModalLabel">Detalhes do Treinamento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h5>{{ selectedTraining.title }}</h5>
            <p>{{ selectedTraining.description }}</p>
            <p><strong>Data de Início:</strong> {{ selectedTraining.start_date }}</p>
            <p><strong>Data de Término:</strong> {{ selectedTraining.end_date }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import { ref, onMounted } from 'vue';
import * as bootstrap from 'bootstrap';

export default {
  name: 'MyTrainingsTable',
  setup() {
    const trainings = ref([]);
    const userId = ref(localStorage.getItem('user_id'));
    const selectedTraining = ref({});

    const fetchCompletedTrainings = async () => {
      try {
        const response = await axiosInstance.get(`/users/${userId.value}/completed-trainings`);
        trainings.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar os treinamentos concluídos:', error);
      }
    };

    const viewDetails = (training) => {
      selectedTraining.value = training;
      const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
      modal.show();
    };

    const getStatusClass = (status) => {
      return {
        'text-success': status === 'aproved',
        'text-danger': status === 'reproved'
      };
    };

    const getStatusText = (status) => {
      return status === 'aproved' ? 'Aprovado' : 'Reprovado';
    };

    onMounted(() => {
      fetchCompletedTrainings();
    });

    return {
      trainings,
      selectedTraining,
      viewDetails,
      getStatusClass,
      getStatusText
    };
  }
};
</script>

<style scoped>
.card {
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.table {
  width: 100%;
  margin-top: 20px;
}

.btn-primary {
  border-radius: 0.25rem;
}

.text-success {
  color: #28a745 !important;
}

.text-danger {
  color: #dc3545 !important;
}
</style>
