<template>
  <table v-if="subordinateTrainings.length > 0" class="table table-striped">
    <thead>
    <tr>
      <th scope="col" colspan="3">Histórico de Treinamentos Concluídos pelo Subordinado</th>
    </tr>
    <tr>
      <th scope="col">Título</th>
      <th scope="col">Descrição</th>
      <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="training in subordinateTrainings" :key="training.id">
      <td>{{ training.title }}</td>
      <td>{{ training.description }}</td>
      <td :class="statusClass(training.status)">{{ mapStatus(training.status) }}</td>
    </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: 'SubordinateTrainingTable',
  props: {
    subordinateTrainings: {
      type: Array,
      required: true
    }
  },
  methods: {
    mapStatus(status) {
      const statusMap = {
        'not_started': 'Não iniciado',
        'in_progress': 'Em andamento',
        'aproved': 'Aprovado',
        'reproved': 'Reprovado'
      };
      return statusMap[status] || status;
    },
    statusClass(status) {
      return {
        'text-success': status === 'aproved',
        'text-danger': status === 'reproved',
        'text-dark': status !== 'aproved' && status !== 'reproved'
      };
    }
  }
};
</script>
