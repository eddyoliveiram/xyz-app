<template>
  <div class="dashboard-page">
    <AnnouncementsSection />
    <TrainingsSection />
  </div>
</template>

<script>
import TrainingsSection from "@/components/pages/subordinate/dashboard/TrainingsSection.vue";
import AnnouncementsSection from "@/components/pages/subordinate/dashboard/AnnouncementsSection.vue";

export default {
  name: 'DashboardPage',
  components: {
    TrainingsSection,
    AnnouncementsSection
  }
};
</script>

<style scoped>
.dashboard-page {
  margin-top: 20px;
  padding: 20px;
}
</style>
