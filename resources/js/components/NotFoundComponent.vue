<script>
export default {

  emits: [
    'getResources',
    'setSearch',
  ],

  methods:{
    resetSearch() {
      this.$emit('getResources', 1, '');
      this.$emit('setSearch', '');
    },
  },
}
</script>

<template>
  <div class="not-found">
    <span class="not-found__message">No Data</span>
    <button class="not-found__btn btn btn-danger" @click="resetSearch">Reset</button>
  </div>
</template>