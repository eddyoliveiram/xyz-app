<template>
  <div>
    <button type="button" class="btn btn-primary mt-4" @click="openModal">
      <i class="fas fa-add"></i> Novo Subordinado
    </button>

    <div class="modal fade" id="subordinateModal" tabindex="-1" aria-labelledby="subordinateModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="subordinateModalLabel">{{ subordinate.id ? 'Editar Subordinado' : 'Novo Subordinado' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="resetForm"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="mt-2 mb-3 row">
                <label for="name" class="col-sm-3 col-form-label">Nome</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="name" v-model="subordinate.name" required>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" v-model="subordinate.email" required>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="login" class="col-sm-3 col-form-label">Login</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="login" v-model="subordinate.login" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save"></i> Salvar
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import * as bootstrap from 'bootstrap';
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';

export default {
  name: 'SubordinateModal',
  props: {
    subordinateToEdit: {
      type: Object,
      default: null,
    },
  },
  setup(props, { emit }) {
    const subordinate = ref({
      id: null,
      name: '',
      email: '',
      login: '',
    });

    const openModal = () => {
      const modal = new bootstrap.Modal(document.getElementById('subordinateModal'));
      modal.show();
    };

    const submitForm = async () => {
      try {
        if (subordinate.value.id) {
          await axiosInstance.put(`/subordinates/${subordinate.value.id}`, subordinate.value);
          alert('Subordinado atualizado com sucesso!');
        } else {
          await axiosInstance.post('/subordinates', subordinate.value);
          alert('Subordinado criado com sucesso!');
        }
        emit('subordinate-updated');
        const modal = bootstrap.Modal.getInstance(document.getElementById('subordinateModal'));
        modal.hide();
        resetForm();
      } catch (error) {
        console.error('Erro:', error);
        alert(`API ERROR: ${error.response.data.message}`);
      }
    };

    const resetForm = () => {
      subordinate.value = {
        id: null,
        name: '',
        email: '',
        login: '',
      };
    };

    watch(() => props.subordinateToEdit, (newSubordinate) => {
      if (newSubordinate) {
        subordinate.value = { ...newSubordinate };
        openModal();
      } else {
        resetForm();
      }
    });

    onMounted(() => {
      const modalElement = document.getElementById('subordinateModal');
      modalElement.addEventListener('hidden.bs.modal', resetForm);
    });

    onBeforeUnmount(() => {
      const modalElement = document.getElementById('subordinateModal');
      modalElement.removeEventListener('hidden.bs.modal', resetForm);
    });

    return {
      subordinate,
      openModal,
      submitForm,
      resetForm,
    };
  },
};
</script>

<style scoped>
.modal-dialog {
  max-width: 500px;
}

.modal-header {
  border-bottom: 1px solid #dee2e6;
}

.modal-footer {
  border-top: 1px solid #dee2e6;
}

.modal-body {
  padding-top: 0;
}
</style>
