<template>
<container-window title="Edit Group" subtitle="Update group details and add/remove members."
                  :back="true" @back="$router.go(-1)">
  <template slot="buttons">
  <input-button type="submit" @click.prevent="onSubmit">Save</input-button>
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
        <infinite-loader class="row" @infinite="fetchMembers" ref="is">
          <label class="col-12">
            Members
          </label>
          <div class="col-12 col-lg-6 mb-3" v-for="member in groupMembers">
            <user-card :user="member"></user-card>
          </div>
        </infinite-loader>
      </div>
    </div>
  </form>
</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import { clone } from '../../util'
import GroupRoute from './mixins/route'
import GroupMembers from './mixins/members'
import GroupForm from './GroupCreate.vue'

export default {
  name: 'GroupEdit',

  extends: GroupForm,

  methods: {
    async onSubmit () {
      const { errors, group } = await this.update({ id: this.group.id, attrs: this.attributes })

      if (errors) {
        this.setErrors(errors)
      }

      if (group) {
        this.clearErrors()
        this.attributes = this.$options.data().attributes

        this.$router.go(-1)
      }
    },
    setAttributes () {
      if (this.group) {
        this.attributes = clone({
          name: this.group.name,
          description: this.group.description,
          private: this.group.private,
          members: []
        })
      }
    },
    ...mapActions('groups', { update: 'update' })
  },

  created () {
    this.setAttributes()
  },

  watch: {
    group () {
      this.setAttributes()
    }
  },

  mixins: [GroupRoute, GroupMembers]
}
</script>
