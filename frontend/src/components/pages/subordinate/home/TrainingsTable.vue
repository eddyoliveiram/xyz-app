<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title mb-4">Treinamentos Disponíveis</h5>
      <table class="table table-striped">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Título</th>
          <th scope="col">Descrição</th>
          <th scope="col">Simulação de Status</th>
          <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="filteredTrainings.length === 0">
          <td colspan="5" class="text-center">Nenhum treinamento disponível até o momento.</td>
        </tr>
        <tr v-else v-for="(training, index) in filteredTrainings" :key="training.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ training.title }}</td>
          <td>{{ training.description }}</td>
          <td>
            <div v-if="training.is_enrolled">
              <select
                  v-model="training.status"
                  @change="onStatusChange(training.id, training.status)"
                  class="form-select form-select-sm"
              >
                <option value="not_started">Não iniciado</option>
                <option value="in_progress">Em andamento</option>
                <option value="aproved">Aprovado</option>
                <option value="reproved">Reprovado</option>
              </select>
            </div>
            <div v-else>
              N/A
            </div>
          </td>
          <td>
            <button v-if="!training.is_enrolled" @click="$emit('enroll-training', training.id)" class="btn btn-success btn-sm">Inscrever-se</button>
            <div v-else>
              <button @click="$emit('cancel-enrollment', training.id)" class="btn btn-danger btn-sm ms-2">Cancelar Inscrição</button>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TrainingsTable',
  props: {
    trainings: {
      type: Array,
      required: true
    }
  },
  methods: {
    onStatusChange(trainingId, status) {
      this.$emit('update-status', trainingId, status);
    }
  },
  computed: {
    filteredTrainings() {
      return this.trainings.filter(training => training.status !== 'aproved' && training.status !== 'reproved');
    }
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
</style>
