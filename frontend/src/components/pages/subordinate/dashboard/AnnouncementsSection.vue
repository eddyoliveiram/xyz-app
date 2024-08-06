<template>
  <div class="container">
    <h5 class="mb-4">Avisos</h5>
    <div class="row">
      <div class="col-md-4 mb-4" v-for="announcement in announcements" :key="announcement.id">
        <CardElement
            :title="announcement.title"
            :description="announcement.description"
            :date="announcement.date"
        />
      </div>
    </div>
  </div>
</template>

<script>
import CardElement from '@/components/base/CardElement.vue';

export default {
  name: 'AnnouncementsSection',
  components: {
    CardElement,
  },
  data() {
    return {
      announcements: [
        { id: 1, title: 'Aviso 1', description: 'Descrição do aviso 1', date: '2023-08-01' },
        { id: 2, title: 'Aviso 2', description: 'Descrição do aviso 2', date: '2023-08-05' },
        { id: 3, title: 'Aviso 3', description: 'Descrição do aviso 3', date: '2023-08-10' }
      ]
    };
  }
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}
</style>
