<template>
  <div class="card">
    <div class="card-header">
      <h5 class="text-center mt-2">Resumo por Treinamento</h5>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label for="trainingSelect" class="form-label">Selecione um Treinamento</label>
        <select id="trainingSelect" class="form-select" v-model="selectedTrainingId" @change="fetchTrainingSummary">
          <option value=""> - Selecione - </option>
          <option v-for="training in trainings" :key="training.id" :value="training.id">
            {{ training.title }}
          </option>
        </select>
      </div>
      <div id="trainingSummary">
        <TrainingResultTable v-if="selectedTrainingId" :trainingSummary="trainingSummary" />
        <p v-if="selectedTrainingId && trainingSummary && trainingSummary.subordinates_count === 0">Nenhum subordinado se inscreveu ou completou este treinamento até o momento.</p>
        <p v-if="selectedTrainingId && !trainingSummary">Nenhum resumo encontrado para o treinamento selecionado.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import TrainingResultTable from './TrainingResultTable.vue';

export default {
  name: 'TrainingSummary',
  components: {
    TrainingResultTable
  },
  data() {
    return {
      trainings: [],
      selectedTrainingId: '',
      trainingSummary: null,
    };
  },
  created() {
    this.fetchDashboardData();
  },
  methods: {
    fetchDashboardData() {
      axiosInstance.get('/trainings')
          .then(response => {
            this.trainings = response.data;
          })
          .catch(error => {
            console.error('Erro ao buscar dados dos treinamentos:', error);
          });
    },
    fetchTrainingSummary() {
      if (this.selectedTrainingId) {
        axiosInstance.get(`/training-summary/${this.selectedTrainingId}`)
            .then(response => {
              this.trainingSummary = response.data;
            })
            .catch(error => {
              console.error('Erro ao buscar o resumo do treinamento:', error);
            });
      }
    }
  }
};
</script>
