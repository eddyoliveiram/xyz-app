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
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" v-model="login" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" v-model="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-sign-in-alt"></i> Acessar
          </button>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosInstance';
import { inject } from 'vue';

export default {
  name: 'FormLogin',
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
          this.$router.push('/home');
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

.form-control {
  border-radius: 0.25rem;
}

.btn-primary {
  border-radius: 0.25rem;
}

.logo {
  max-width: 70px;
  height: auto;
}
</style>
