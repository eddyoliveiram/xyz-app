<template>
  <li class="nav-item">
    <router-link class="nav-link text-start" :to="to" active-class="active-link">
      <i :class="icon"></i> {{ text }}
    </router-link>
  </li>
</template>

<script>
export default {
  name: 'NavItem',
  props: {
    to: {
      type: String,
      required: true
    },
    icon: {
      type: String,
      required: true
    },
    text: {
      type: String,
      required: true
    }
  }
};
</script>

<style scoped>
.nav-link {
  color: #fff;
}

.nav-link:hover {
  background-color: #495057;
}

.active-link {
  //background-color: #28a745;
}
</style>
