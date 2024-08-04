<template>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card" style="width: 100%; max-width: 400px;">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Login</h5>
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" v-model="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" v-model="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-sign-in-alt"></i> Login
          </button>
        </form>
        <div class="text-center mt-3">
          <a href="#" class="text-muted">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormLogin',
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    handleSubmit() {
      // Handle the login logic here
      console.log('Username:', this.username);
      console.log('Password:', this.password);
    }
  }
}
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
</style>
