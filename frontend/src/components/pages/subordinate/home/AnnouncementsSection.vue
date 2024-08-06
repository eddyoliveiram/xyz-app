<template>
      <div class="col-md-12 mb-4" v-for="announcement in announcements" :key="announcement.id">
        <CardElement
            :title="announcement.title"
            :description="announcement.description"
            :date="announcement.date"
        />
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
        { id: 1, title: 'Aviso (Exemplo)', description: 'Descrição do aviso 1', date: '01/08/2024' }
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
