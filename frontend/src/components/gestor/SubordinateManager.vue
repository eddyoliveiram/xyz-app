<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col d-flex justify-content-start">
          <SubordinateModal :subordinateToEdit="subordinateToEdit" @subordinate-updated="fetchSubordinates" @close-modal="closeModal" />
        </div>
        <div class="col d-flex justify-content-center align-items-center">
          <h5 class="card-title mb-0">Subordinados</h5>
        </div>
        <div class="col d-flex justify-content-end">
        </div>
      </div>
    </div>
    <div class="card-body">
      <table class="table">
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
        <tr v-for="(subordinate, index) in paginatedSubordinates" :key="subordinate.id">
          <th scope="row">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</th>
          <td>{{ subordinate.name }}</td>
          <td>{{ subordinate.email }}</td>
          <td>{{ subordinate.login }}</td>
          <td>
            <button class="btn btn-primary btn-sm me-2" @click="editSubordinate(subordinate)">
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
    <div class="card-footer text-center">
      <PaginationComp class="mt-2"
                      :totalItems="totalSubordinates"
                      :itemsPerPage="itemsPerPage"
                      :currentPage="currentPage"
                      @page-changed="handlePageChange"
      />
    </div>
  </div>
</template>

<script>
import SubordinateModal from './SubordinateModal.vue';
import PaginationComp from '../pagination/PaginationComp.vue';
import axiosInstance from '@/axiosInstance';
import { ref, computed, onMounted } from 'vue';

export default {
  components: {
    SubordinateModal,
    PaginationComp,
  },
  setup() {
    const subordinates = ref([]);
    const subordinateToEdit = ref(null);
    const currentPage = ref(1);
    const itemsPerPage = ref(7);
    const totalSubordinates = ref(0);

    const paginatedSubordinates = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage.value;
      const end = start + itemsPerPage.value;
      return subordinates.value.slice(start, end);
    });

    const fetchSubordinates = async () => {
      try {
        const response = await axiosInstance.get('/subordinates');
        subordinates.value = response.data;
        totalSubordinates.value = response.data.length;
      } catch (error) {
        console.error('Erro ao buscar os subordinados:', error);
        alert('Erro ao buscar os subordinados.');
      }
    };

    const handlePageChange = (page) => {
      currentPage.value = page;
    };

    const editSubordinate = (subordinate) => {
      subordinateToEdit.value = null;
      setTimeout(() => {
        subordinateToEdit.value = subordinate;
      }, 0);
    };

    const closeModal = () => {
      subordinateToEdit.value = null;
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
      currentPage,
      itemsPerPage,
      totalSubordinates,
      paginatedSubordinates,
      fetchSubordinates,
      handlePageChange,
      editSubordinate,
      deleteSubordinate,
      closeModal,
    };
  },
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
