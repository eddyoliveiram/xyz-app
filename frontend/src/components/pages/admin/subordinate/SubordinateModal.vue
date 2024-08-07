<template>
  <div>
    <div align="left">
      <button type="button" class="btn btn-success mb-2 mt-2" @click="openModal">
        <i class="fas fa-plus-circle"></i> Novo Subordinado
      </button>
    </div>
    <div class="modal fade" id="subordinateModal" tabindex="-1" aria-labelledby="subordinateModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="subordinateModalLabel">{{ subordinate.id ? 'Editar Subordinado' : 'Novo Subordinado' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="resetForm"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <FormInput id="name" label="Nome" v-model="subordinate.name" required />
              <FormInput id="email" label="Email" type="email" v-model="subordinate.email" required />
              <FormInput id="login" label="Login" v-model="subordinate.login" required />
              <FormButton type="submit" label="Salvar" icon="fas fa-save" variant="success" />
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
import {ref, watch, onMounted, onBeforeUnmount} from 'vue';
import Swal from 'sweetalert2';
import FormInput from '@/components/base/FormInput.vue';
import FormButton from '@/components/base/FormButton.vue';

export default {
  name: 'SubordinateModal',
  components: {
    FormInput,
    FormButton,
  },
  props: {
    subordinateToEdit: {
      type: Object,
      default: null,
    },
  },
  setup(props, {emit}) {
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
          Swal.fire('Sucesso', 'Subordinado atualizado com sucesso!', 'success');
        } else {
          await axiosInstance.post('/subordinates', subordinate.value);
          Swal.fire('Sucesso', 'Subordinado criado com sucesso!', 'success');
        }
        emit('subordinate-updated');
        const modal = bootstrap.Modal.getInstance(document.getElementById('subordinateModal'));
        modal.hide();
        resetForm();
      } catch (error) {
        console.error('Erro:', error);
        Swal.fire('Erro', `API ERROR: ${error.response.data.message}`, 'error');
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
        subordinate.value = {...newSubordinate};
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
