<template>
  <div>
    <button type="button" class="btn btn-primary mt-4" @click="openModal">
      <i class="fas fa-add"></i> Novo Treinamento
    </button>

    <div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="trainingModalLabel">{{ training.id ? 'Editar Treinamento' : 'Novo Treinamento' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="resetForm"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="mt-2 mb-3 row">
                <label for="title" class="col-sm-3 col-form-label">Título</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="title" v-model="training.title" required>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="description" class="col-sm-3 col-form-label">Descrição</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="description" v-model="training.description" rows="3" required></textarea>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="start_date" class="col-sm-3 col-form-label">Data de Início</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" id="start_date" v-model="training.start_date" required>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="end_date" class="col-sm-3 col-form-label">Data de Término</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" id="end_date" v-model="training.end_date" required>
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
  name: 'TrainingModal',
  props: {
    trainingToEdit: {
      type: Object,
      default: null,
    },
  },
  setup(props, { emit }) {
    const training = ref({
      id: null,
      title: '',
      description: '',
      start_date: '',
      end_date: '',
    });

    const openModal = () => {
      const modal = new bootstrap.Modal(document.getElementById('trainingModal'));
      modal.show();
    };

    const submitForm = async () => {
      try {
        if (training.value.id) {
          await axiosInstance.put(`/trainings/${training.value.id}`, training.value);
          alert('Treinamento atualizado com sucesso!');
        } else {
          await axiosInstance.post('/trainings', training.value);
          alert('Treinamento criado com sucesso!');
        }
        emit('training-updated');
        const modal = bootstrap.Modal.getInstance(document.getElementById('trainingModal'));
        modal.hide();
        resetForm();
      } catch (error) {
        console.error('Erro:', error);
        alert(`API ERROR: ${error.response.data.message}`);
      }
    };

    const resetForm = () => {
      training.value = {
        id: null,
        title: '',
        description: '',
        start_date: '',
        end_date: '',
      };
    };

    watch(() => props.trainingToEdit, (newTraining) => {
      if (newTraining) {
        training.value = { ...newTraining };
        openModal();
      } else {
        resetForm();
      }
    });

    onMounted(() => {
      const modalElement = document.getElementById('trainingModal');
      modalElement.addEventListener('hidden.bs.modal', resetForm);
    });

    onBeforeUnmount(() => {
      const modalElement = document.getElementById('trainingModal');
      modalElement.removeEventListener('hidden.bs.modal', resetForm);
    });

    return {
      training,
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
