<template>
  <div class="dashboard-page">
    <MyTrainingsSection />
  </div>
</template>

<script>
import MyTrainingsSection from "@/components/pages/subordinate/mytrainings/MyTrainingsSection.vue";

export default {
  name: 'MyTrainingsPage',
  components: {
    MyTrainingsSection
  }
};
</script>

<style scoped>
.dashboard-page {
  margin-top: 20px;
  padding: 20px;
}
</style>
