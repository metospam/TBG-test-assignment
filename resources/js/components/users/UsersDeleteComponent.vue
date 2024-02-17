<script>
import UserService from "../../services/UserService";

export default {
  props: [
    'user',
    'currentPage',
    'search',
  ],

  emits: [
    'getResources'
  ],

  methods: {
    async deleteUser(id, page, search) {
        await UserService.deleteUser(id);
        this.$emit('getResources', page, search);
    },
  },
}
</script>

<template>
  <button @click="deleteUser(user.id, currentPage, search)" class="btn btn-danger">
    Delete
  </button>
</template>

<style scoped>

</style>
