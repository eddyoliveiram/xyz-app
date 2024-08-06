<template>
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
    <tr v-for="(subordinate, index) in subordinates" :key="subordinate.id">
      <th scope="row">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</th>
      <td>{{ subordinate.name }}</td>
      <td>{{ subordinate.email }}</td>
      <td>{{ subordinate.login }}</td>
      <td>
        <EditButton @click="editSubordinate(subordinate)" />
        <DeleteButton :disabled="isProcessing" @click="handleDelete(subordinate.id)" />
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
import EditButton from '../../../base/EditButton.vue';
import DeleteButton from '../../../base/DeleteButton.vue';

export default {
  name: 'SubordinateTable',
  props: {
    subordinates: {
      type: Array,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    itemsPerPage: {
      type: Number,
      required: true
    },
  },
  components: {
    EditButton,
    DeleteButton,
  },
  data() {
    return {
      isProcessing: false
    };
  },
  methods: {
    editSubordinate(subordinate) {
      this.$emit('edit-subordinate', subordinate);
    },
    async handleDelete(id) {
      if (this.isProcessing) return;
      this.isProcessing = true;
      try {
        await this.deleteSubordinate(id);
      } finally {
        this.isProcessing = false;
      }
    },
    deleteSubordinate(id) {
      // Confirm delete
      if (confirm('Tem certeza que deseja excluir este subordinado?')) {
        this.$emit('delete-subordinate', id);
      }
    }
  }
};
</script>

<style scoped>
.table {
  width: 100%;
}
</style>
