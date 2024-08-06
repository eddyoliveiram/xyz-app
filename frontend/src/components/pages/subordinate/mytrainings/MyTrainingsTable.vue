<template>
  <div class="container mt-4">
    <h5 class="mb-4">Meus treinamentos</h5>
    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Título</th>
        <th scope="col">Descrição</th>
        <th scope="col">Ações</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="training in trainings" :key="training.id">
        <th scope="row">{{ training.id }}</th>
        <td>{{ training.title }}</td>
        <td>{{ training.description }}</td>
        <td>
          <a :href="`/trainings/${training.id}`" class="btn btn-primary">Ver Detalhes</a>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'MyTrainingsTable',
  data() {
    return {
      trainings: [
        { id: 1, title: 'Treinamento 1', description: 'Descrição do treinamento 1' },
        { id: 2, title: 'Treinamento 2', description: 'Descrição do treinamento 2' },
        { id: 3, title: 'Treinamento 3', description: 'Descrição do treinamento 3' }
      ]
    };
  }
};
</script>

<style scoped>
.table {
  width: 100%;
  margin-top: 20px;
}

.btn-primary {
  border-radius: 0.25rem;
}
</style>
