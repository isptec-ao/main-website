<template>
<div class="row">
  <div class="col">
    <div class="dataTables_paginate paging_simple_numbers float-right">
      <nav aria-hidden="false" aria-label="Pagination">
   <ul aria-disabled="false" class="pagination pagination-rounded b-pagination justify-content-right">
      <li aria-hidden="true" class="page-item">
        <inertia-link class="page-link" :href="firstpageurl" v-if="!nextpageurl">
          <span>«</span>
      </inertia-link>
      </li>
      <li class="page-item" v-for="(link, key) in links" :key="key" v-bind:class="isActive(link)">
        <inertia-link class="page-link" :href="link.url" v-if="link.url">
          <span v-html="link.label"></span>
        </inertia-link>
        <a class="page-link" href="#" v-else @click.prevent="handleNoLink">
          <span v-html="link.label"></span>
        </a>
      </li>
      <li class="page-item">
        <inertia-link class="page-link" :href="lastpageurl" v-if="nextpageurl">
          <span>»</span>
        </inertia-link>
      </li>
   </ul>
</nav>
    </div>
  </div>
</div>  

</template>

<script>
export default {
  props: {
    links: Array,
    lastpage: Number,
    lastpageurl: String,
    firstpageurl: String,
    nextpageurl: String,
  },
  methods: {
      linkGen(pageNum) {
        return `?page=${pageNum}`
      },
      pageGen(pageNum) {
        return `${pageNum}`
      },
      isActive(link) {
          return (link.active === true) ? 'active' : 'normal'
      },
      handleNoLink() {
          return false
      }
    }
}
</script>