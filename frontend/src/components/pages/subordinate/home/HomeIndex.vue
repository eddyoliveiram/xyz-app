<template>
  <div class="">
    <AnnouncementsSection />
    <TrainingsSection />
  </div>
</template>

<script>
import TrainingsSection from "@/components/pages/subordinate/home/TrainingsSection.vue";
import AnnouncementsSection from "@/components/pages/subordinate/home/AnnouncementsSection.vue";

export default {
  name: 'HomeIndex',
  components: {
    TrainingsSection,
    AnnouncementsSection
  }
};
</script>

<style scoped>
</style>
