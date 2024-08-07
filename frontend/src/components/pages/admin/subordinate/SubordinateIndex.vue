<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col d-flex justify-content-start">
          <SubordinateModal :subordinateToEdit="subordinateToEdit" @subordinate-updated="handleSubordinateUpdated" @close-modal="closeModal" />
        </div>
        <div class="col d-flex justify-content-center align-items-center">
          <h5 class="card-title mb-0">Subordinados</h5>
        </div>
        <div class="col d-flex justify-content-end">
        </div>
      </div>
    </div>
    <div class="card-body">
      <SubordinateTable
          :subordinates="paginatedSubordinates"
          :currentPage="currentPage"
          :itemsPerPage="itemsPerPage"
          @edit-subordinate="editSubordinate"
          @delete-subordinate="confirmDeleteSubordinate"
      />
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
import SubordinateTable from './SubordinateTable.vue';
import PaginationComp from '@/components/common/PaginationComponent.vue';
import axiosInstance from '@/axiosInstance';
import {ref, computed, onMounted} from 'vue';
import Swal from 'sweetalert2';

export default {
  components: {
    SubordinateModal,
    SubordinateTable,
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
        Swal.fire('Erro', 'Erro ao buscar os subordinados.', 'error');
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

    const confirmDeleteSubordinate = (id) => {
      Swal.fire({
        title: 'Você tem certeza?',
        text: 'Você não poderá reverter isso!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#999',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteSubordinate(id);
        }
      });
    };

    const deleteSubordinate = async (id) => {
      try {
        await axiosInstance.delete(`/subordinates/${id}`);
        fetchSubordinates();
        Swal.fire('Excluído!', 'Subordinado excluído com sucesso!', 'success');
      } catch (error) {
        console.error('Erro ao excluir o subordinado:', error);
        Swal.fire('Erro', 'Erro ao excluir o subordinado.', 'error');
      }
    };

    const handleSubordinateUpdated = () => {
      fetchSubordinates();
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
      closeModal,
      confirmDeleteSubordinate,
      handleSubordinateUpdated,
    };
  },
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
