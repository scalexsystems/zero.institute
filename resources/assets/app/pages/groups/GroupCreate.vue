<template>
<container-window title="Create Group" subtitle="Create a group, add members & start your own community."
                  :back="true" @back="$router.push({ name: 'group.index' })">
  <template slot="buttons">
  <input-button type="submit" @click.prevent="onSubmit">Create</input-button>
  </template>


  <form @submit.prevent="onSubmit" class="container my-3">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">
        <input-text v-model="attributes.name" title="Name of the group" :errors="errors" autofocus required></input-text>
        <checkbox-wrapper title="Group Type" required>
          <input-box v-model="attributes.private" title="Public" :radio="false" class="form-check-inline"></input-box>
          <input-box v-model="attributes.private" title="Private" :radio="true" class="form-check-inline"></input-box>
        </checkbox-wrapper>
        <input-textarea v-model="attributes.description" title="Description" :errors="errors"></input-textarea>
        <div class="form-group">
          <label>Add Members</label>
          <typeahead title="Members" @search="onSearch" v-bind="{ suggestions, value: [] }" component="select-option-user" @select="onMemberSelect"></typeahead>
        </div>
      </div>

      <div class="col-12 col-lg-8 offset-lg-2">
        <div class="row">
          <div class="col-12 col-lg-6 mb-3" v-for="member in members">
            <user-card :user="member"></user-card>
          </div>
        </div>
      </div>
    </div>
  </form>
</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import { formHelper } from 'bootstrap-for-vue'
import throttle from 'lodash.throttle'

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

  computed: {
    members () {
      const members = this.suggestions
      const ids = this.attributes.members

      return members.filter(({ user_id }) => ids.indexOf(user_id) > -1)
    },

    ...mapGetters('people', { suggestions: 'people' })
  },

  methods: {
    async onSubmit (e) {
      e.traget.classList.add('disabled')
      const { errors, group } = await this.create(this.attributes)
      e.traget.classList.remove('disabled')

      if (errors) {
        this.setErrors(errors)
      }

      if (group) {
        this.clearErrors()
        this.attributes = this.$options.data().attributes

        this.$router.push({ name: 'group.messages', params: { id: group.id }})
      }
    },
    onSearch: throttle(function onSearch (q) {
      this.query({ q })
    }),
    onMemberSelect (member) {
      const id = member.user_id

      if (this.attributes.members.indexOf(id) < 0) {
        this.attributes.members.push(id)
      }
    },
    ...mapActions('people', { query: 'index' }),
    ...mapActions('groups', { create: 'store' })
  },

  created () {
    this.query()
  },

  mixins: [formHelper]
}
</script>
