<template>
  <div>
    <NavbarGestor v-if="showNavbar" />
    <router-view />
  </div>
</template>

<script>
import NavbarGestor from "@/components/gestor/NavbarGestor.vue";
import { computed } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'App',
  components: { NavbarGestor },
  setup() {
    const route = useRoute();
    const showNavbar = computed(() => route.path !== '/');
    return {
      showNavbar,
    };
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
