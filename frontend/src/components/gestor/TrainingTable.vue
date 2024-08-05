<script setup>
import { ref, onMounted } from 'vue';
import axiosInstance from '@/axiosInstance';

const trainings = ref([]);

const fetchTrainings = async () => {
  try {
    const response = await axiosInstance.get('/trainings');
    trainings.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar treinamentos:', error);
  }
};

onMounted(() => {
  fetchTrainings();
});

const editTraining = (id) => {
  console.log(`Edit training with id: ${id}`);
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
</script>

<template>
  <table class="table table-striped table-hover mt-2">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Título</th>
      <th scope="col">Descrição</th>
      <th scope="col">Data Início</th>
      <th scope="col">Data Fim</th>
      <th scope="col">Ações</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(training, index) in trainings" :key="training.id">
      <th scope="row">{{ index + 1 }}</th>
      <td>{{ training.title }}</td>
      <td>{{ training.description }}</td>
      <td>{{ training.start_date }}</td>
      <td>{{ training.end_date }}</td>
      <td>
        <button type="button" class="btn btn-primary" @click="editTraining(training.id)">
          <i class="fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-danger ms-1" @click="deleteTraining(training.id)">
          <i class="fas fa-trash"></i>
        </button>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<style scoped>
.table {
  background-color: white;
}

.btn-primary {
  margin-right: 5px;
}
</style>
