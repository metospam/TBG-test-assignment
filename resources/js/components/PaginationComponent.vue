<script>
export default {
  props: [
    'totalPages',
    'currentPage',
    'search'
  ],

  emits: [
    'getResources'
  ],

  methods: {
    isActive(index) {
      return this.currentPage === index ? 'active' : '';
    },
  },

  computed: {
    displayedPages() {
        const startPage = Math.max(1, this.currentPage - Math.floor(4 / 2));
        const endPage = Math.min(this.totalPages, startPage + 4 - 1);

        let pages = [];
        if (startPage > 1) {
            pages.push(1);

            if (startPage > 2) {
                pages.push('...');
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            pages.push(i);
        }

        if (endPage < this.totalPages) {
            if (endPage < this.totalPages - 1) {
                pages.push('...');
            }

            pages.push(this.totalPages);
        }

        return pages;
    },
  },
};
</script>

<template>
  <template v-if="this.totalPages > 1">
    <nav class="pagination">
      <ul class="pagination-links">
        <template v-for="page in displayedPages" :key="page">
          <li>
            <span v-if="page === '...'">{{ page }}</span>
            <span v-else
                  @click.prevent="page !== '...' ? this.$emit('getResources', page, search) : null"
                  :class="isActive(page)">
                {{ page }}
            </span>
          </li>
        </template>
      </ul>
    </nav>
  </template>
</template>

<style scoped>

</style>
