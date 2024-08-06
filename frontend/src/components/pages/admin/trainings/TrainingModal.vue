<template>
  <div>
    <div align="left">
      <button type="button" class="btn btn-success mb-2 mt-2" @click="openModal">
        <i class="fas fa-plus-circle"></i> Novo Treinamento
      </button>
    </div>
    <div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="trainingModalLabel">{{ training.id ? 'Editar Treinamento' : 'Novo Treinamento' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="resetForm"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <FormInput id="title" label="Título" v-model="training.title" required />
              <FormTextarea id="description" label="Descrição" v-model="training.description" required />
              <FormInput id="start_date" label="Data de Início" type="date" v-model="training.start_date" required />
              <FormInput id="end_date" label="Data de Término" type="date" v-model="training.end_date" required />
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
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import FormInput from '@/components/base/FormInput.vue';
import FormTextarea from '@/components/base/FormTextarea.vue';
import FormButton from '@/components/base/FormButton.vue';

export default {
  name: 'TrainingModal',
  components: {
    FormInput,
    FormTextarea,
    FormButton,
  },
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
