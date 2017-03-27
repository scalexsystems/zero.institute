<template lang="html">
<input-typeahead v-bind="$props"
                 @input="any => $emit('input', any)"
                 @search="onSearch"
                 :suggestions="students"
                 component="SelectOptionUser"
/>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapActions } from 'vuex'

export default {
  name: 'StudentInputTypeahead',

  props: ['title', 'subtitle', 'name', 'inputName', 'errors', 'inputClass', 'placeholder', 'value'],

  data: () => ({ students: [] }),

  methods: {
    onSearch: throttle(async function (q) {
      const { students } = await this.search({ q })

      this.students = students || []
    }),
    ...mapActions('students', { search: 'index' })
  },

  created () {
    this.onSearch()
  }
}
</script>


<style lang="scss">

</style>
