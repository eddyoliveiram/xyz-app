<template>
  <div class="table-responsive">
  <table class="table table-striped">
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
    <tr v-if="subordinates.length === 0">
      <td colspan="5" class="text-center">Nenhum subordinado cadastrado.</td>
    </tr>
    <tr v-for="(subordinate, index) in subordinates" :key="subordinate.id">
      <th scope="row">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</th>
      <td>{{ subordinate.name }}</td>
      <td>{{ subordinate.email }}</td>
      <td>{{ subordinate.login }}</td>
      <td>
        <EditButton @click="editSubordinate(subordinate)" />
        <DeleteButton :disabled="isProcessing" @click="emitDelete(subordinate.id)" />
      </td>
    </tr>
    </tbody>
  </table>
  </div>
</template>

<script>
import EditButton from '@/components/base/EditButton.vue';
import DeleteButton from '@/components/base/DeleteButton.vue';

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
    }
  },
  components: {
    EditButton,
    DeleteButton
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
    emitDelete(id) {
      if (!this.isProcessing) {
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
