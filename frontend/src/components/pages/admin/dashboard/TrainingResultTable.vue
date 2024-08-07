<template>
  <table v-if="trainingSummary && trainingSummary.subordinates_count > 0" class="table table-striped">
    <thead>
    <tr>
      <th scope="col" colspan="5">Quantitativo de Resultados do Treinamento Selecionado</th>
    </tr>
    <tr>
      <th scope="col">Subordinados Inscritos</th>
      <th scope="col">Não Iniciados</th>
      <th scope="col">Em Andamento</th>
      <th scope="col">Aprovados</th>
      <th scope="col">Reprovados</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>{{ trainingSummary.subordinates_count }}</td>
      <td>{{ trainingSummary.statuses.not_started }}</td>
      <td>{{ trainingSummary.statuses.in_progress }}</td>
      <td>{{ trainingSummary.statuses.aproved }}</td>
      <td>{{ trainingSummary.statuses.reproved }}</td>
    </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: 'TrainingResultTable',
  props: {
    trainingSummary: {
      type: Object,
      required: true
    }
  }
};
</script>
