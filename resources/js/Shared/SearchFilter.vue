<template>
<!-- Search -->

  <div id="tickets-table_filter" class="dataTables_filter text-md-right">
    <label class="d-inline-flex align-items-center">
      Search:
      <b-form-input
        :value="value" @input="$emit('input', $event.target.value)"
        type="search"
        placeholder="Search..."
        class="form-control form-control-sm ml-2"
        :style="{ maxWidth: `${maxWidth}px` }"
      ></b-form-input>
    </label>
  </div>

<!-- End search -->
</template>

<script>
export default {
  components: {
    
  },
  props: {
    value: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
}
</script>