<template lang="html">
<input-typeahead v-bind="$props"
                 @input="any => $emit('input', any)"
                 @search="onSearch"
                 :suggestions="employees"
                 component="SelectOptionUser"
/>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapActions } from 'vuex'

export default {
  name: 'StudentInputTypeahead',

  props: ['title', 'subtitle', 'name', 'inputName', 'errors', 'inputClass', 'placeholder', 'value'],

  data: () => ({ employees: [] }),

  methods: {
    onSearch: throttle(async function (q) {
      const { employees } = await this.search({ q })

      this.employees = employees || []
    }),
    ...mapActions('employees', { search: 'index' })
  },

  created () {
    this.onSearch()
  }

}
</script>


<style lang="scss">

</style>
