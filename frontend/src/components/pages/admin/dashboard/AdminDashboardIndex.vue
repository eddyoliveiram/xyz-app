<template>
  <div class="dashboard-container">
    <SubordinateSummary />
    <TrainingSummary />
  </div>
</template>

<script>
import SubordinateSummary from './SubordinateSummary.vue';
import TrainingSummary from './TrainingSummary.vue';

export default {
  name: 'AdminDashboardIndex',
  components: {
    SubordinateSummary,
    TrainingSummary
  }
};
</script>

<style scoped>
.dashboard-container {
  margin: 20px;
}
</style>
