<template>
  <NavbarGestor/>
  <FormLogin/>
</template>

<script>
import NavbarGestor from './components/gestor/NavbarGestor.vue'
import FormLogin from "@/components/login/FormLogin.vue";
import './assets/styles/styles.css';

export default {
  name: 'App',
  components: {
    NavbarGestor,
    FormLogin
  }
}
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
