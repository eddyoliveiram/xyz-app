<template>
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="text-center mt-2">Resumo por Subordinado</h5>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label for="subordinateSelect" class="form-label">Selecione um Subordinado</label>
        <select id="subordinateSelect" class="form-select" v-model="selectedSubordinateId" @change="fetchSubordinateTrainings">
          <option value=""> - Selecione - </option>
          <option v-for="subordinate in subordinates" :key="subordinate.id" :value="subordinate.id">
            {{ subordinate.name }}
          </option>
        </select>
      </div>
      <div id="resultado">
        <SubordinateTrainingTable v-if="selectedSubordinateId" :subordinateTrainings="subordinateTrainings" />
        <p v-if="selectedSubordinateId && subordinateTrainings.length === 0">O subordinado selecionado não está inscrito em nenhum treinamento até o momento.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import SubordinateTrainingTable from './SubordinateTrainingTable.vue';

export default {
  name: 'SubordinateSummary',
  components: {
    SubordinateTrainingTable
  },
  data() {
    return {
      subordinates: [],
      selectedSubordinateId: '',
      subordinateTrainings: [],
    };
  },
  created() {
    this.fetchSubordinates();
  },
  methods: {
    fetchSubordinates() {
      axiosInstance.get('/subordinates')
          .then(response => {
            this.subordinates = response.data;
          })
          .catch(error => {
            console.error('Erro ao buscar a lista de subordinados:', error);
          });
    },
    fetchSubordinateTrainings() {
      if (this.selectedSubordinateId) {
        axiosInstance.get(`/subordinate-trainings/${this.selectedSubordinateId}`)
            .then(response => {
              this.subordinateTrainings = response.data;
            })
            .catch(error => {
              console.error('Erro ao buscar os treinamentos do subordinado:', error);
            });
      }
    }
  }
};
</script>
