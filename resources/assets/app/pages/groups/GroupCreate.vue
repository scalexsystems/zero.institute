<template>
<container-window title="Create Group" subtitle="Create a group, add members & start your own community."
                  :back="true" @back="$router.push({ name: 'group.index' })">
  <template slot="buttons">
  <input-button type="submit" @click.prevent="onSubmit">Create</input-button>
  </template>


  <form @submit.prevent="onSubmit" class="container my-3">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">
        <input-text v-model="attributes.name" title="Name of the group" autofocus required></input-text>
        <checkbox-wrapper title="Group Type" required>
          <input-box v-model="attributes.private" title="Public" :radio="false" class="form-check-inline"></input-box>
          <input-box v-model="attributes.private" title="Private" :radio="true" class="form-check-inline"></input-box>
        </checkbox-wrapper>
        <input-text v-model="attributes.description" title="Description"></input-text>
        <input-typeahead v-model="attributes.members" title="Members" :suggestions="[]"></input-typeahead>
      </div>
    </div>
  </form>
</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'GroupCreate',

  data: () => ({
    attributes: {
      name: '',
      private: false,
      description: '',
      members: []
    }
  }),

  methods: {
    onSubmit () {
      console.log('SUBMIT')
    }
  }
}
</script>


<style lang="scss">
</style>
