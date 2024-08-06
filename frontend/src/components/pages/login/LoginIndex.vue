<template>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card" style="width: 100%; max-width: 400px;">
      <div class="card-body">
        <div class="text-center mb-2">
          <img src="@/assets/logo.png" alt="Logo" class="logo">
        </div>
        <h5 class="card-title text-center mb-4">XYZ Treinamentos</h5>
        <form @submit.prevent="attempt">
          <div class="mb-3">
            <FormLabel forId="login" label="Login" />
            <FormField type="text" id="login" v-model="login" required />
          </div>
          <div class="mb-3">
            <FormLabel forId="password" label="Senha" />
            <FormField type="password" id="password" v-model="password" required />
          </div>
          <FormButton type="submit" label="Acessar" icon="fas fa-sign-in-alt" variant="primary" />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import { inject } from 'vue';
import FormButton from '@/components/base/FormButton.vue';
import FormField from '@/components/base/FormField.vue';
import FormLabel from '@/components/base/FormLabel.vue';

export default {
  name: 'FormLogin',
  components: {
    FormButton,
    FormField,
    FormLabel
  },
  data() {
    return {
      login: '',
      password: ''
    };
  },
  setup() {
    const updateState = inject('updateState');

    return {
      updateState
    };
  },
  methods: {
    async attempt() {
      localStorage.removeItem('is_admin');
      localStorage.removeItem('user_name');
      localStorage.removeItem('token');
      try {
        const response = await axiosInstance.post('/login', {
          login: this.login,
          password: this.password,
        });

        if (response.data && response.data.token) {
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('is_admin', response.data.is_admin);
          localStorage.setItem('user_name', response.data.user.name);
          axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
          this.updateState();
          if (response.data.is_admin) {
            this.$router.push('/admin/dashboard');
          } else {
            this.$router.push('/subordinate/dashboard');
          }
        } else {
          console.log('Token not received');
        }
      } catch (error) {
        console.log('Login failed.');
      }
    }
  }
};
</script>

<style scoped>
.card {
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.logo {
  max-width: 70px;
  height: auto;
}
</style>
