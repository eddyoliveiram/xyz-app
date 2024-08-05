<template>
  <div>
    <SubordinateModal :subordinateToEdit="subordinateToEdit" @subordinate-updated="fetchSubordinates" />

    <table class="table mt-4">
      <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Login</th>
        <th>Ações</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(subordinate, index) in subordinates" :key="subordinate.id">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ subordinate.name }}</td>
        <td>{{ subordinate.email }}</td>
        <td>{{ subordinate.login }}</td>
        <td>
          <button class="btn btn-warning btn-sm me-2" @click="editSubordinate(subordinate)">
            <i class="fas fa-edit"></i> Editar
          </button>
          <button class="btn btn-danger btn-sm" @click="deleteSubordinate(subordinate.id)">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import SubordinateModal from './SubordinateModal.vue';
import axiosInstance from '@/axiosInstance';
import { ref, onMounted } from 'vue';

export default {
  components: {
    SubordinateModal,
  },
  setup() {
    const subordinates = ref([]);
    const subordinateToEdit = ref(null);

    const fetchSubordinates = async () => {
      try {
        const response = await axiosInstance.get('/subordinates');
        subordinates.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar os subordinados:', error);
        alert('Erro ao buscar os subordinados.');
      }
    };

    const openModal = () => {
      subordinateToEdit.value = null;
    };

    const editSubordinate = (subordinate) => {
      subordinateToEdit.value = subordinate;
    };

    const deleteSubordinate = async (id) => {
      if (confirm('Tem certeza que deseja excluir este subordinado?')) {
        try {
          await axiosInstance.delete(`/subordinates/${id}`);
          fetchSubordinates();
          alert('Subordinado excluído com sucesso!');
        } catch (error) {
          console.error('Erro ao excluir o subordinado:', error);
          alert('Erro ao excluir o subordinado.');
        }
      }
    };

    onMounted(() => {
      fetchSubordinates();
    });

    return {
      subordinates,
      subordinateToEdit,
      fetchSubordinates,
      openModal,
      editSubordinate,
      deleteSubordinate,
    };
  },
};
</script>

<style scoped>
.table {
  width: 100%;
  margin-top: 1rem;
}
</style>
