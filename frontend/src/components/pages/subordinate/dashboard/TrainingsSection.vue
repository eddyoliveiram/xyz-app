<template>
  <div>
    <TrainingsTable :trainings="trainings" />
  </div>
</template>

<script>
import TrainingsTable from './TrainingsTable.vue';

export default {
  name: 'TrainingsSection',
  components: {
    TrainingsTable
  },
  data() {
    return {
      trainings: [
        { id: 1, title: 'Treinamento 1', description: 'Descrição do treinamento 1' },
        { id: 2, title: 'Treinamento 2', description: 'Descrição do treinamento 2' },
        { id: 3, title: 'Treinamento 3', description: 'Descrição do treinamento 3' }
      ]
    };
  }
};
</script>
