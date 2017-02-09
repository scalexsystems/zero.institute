<template>
<container-window v-bind="{ title, subtitle, photo }">
  <template slot="buttons">
  <router-link v-if="isAdmin" :to="{ name: 'group.edit', params: { id: group.id } }" class="btn btn-primary"
               role="button">Edit</router-link>
  </template>

  <div class="container" v-if="group">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">
        <div class="row mt-3">

          <div class="col-12 my-3 text-center">
            <photo-uploader v-if="isAdmin"
                            class="p-group-photo round"
                            :dest="`groups/${group.id}/photo`"
                            @uploaded="find(group.id)">
                <img :src="group.photo" class="rounded-circle p-group-photo">
            </photo-uploader>
            <img v-else :src="group.photo" class="rounded-circle p-group-photo">
          </div>

          <div class="col-12 mb-3 text-center">
            <span class="alert alert-info p-group-privacy-tag" v-if="!group.private">Public Group</span>
            <span class="alert alert-danger p-group-privacy-tag" v-else>Private Group</span>
          </div>

          <div class="col-12 mb-3 text-center">
            <h2>{{ group.name }}</h2>

            <p class="text-muted">{{ group.description }}</p>
          </div>


          <div class="col-12 text-center mb-3" v-if="!group.is_member">
            <input-button @click="joinGroup">Join Group</input-button>
          </div>
        </div>

        <infinite-loader class="row" @infinite="fetchMembers" ref="is">
          <div class="col-12 mb-3">
            <search v-model="query" placeholder="Find members..." class="form-control-lg"></search>
          </div>

          <div class="col-12 mb-3 text-center">
            <small>{{ group.member_count_text }}</small>
          </div>

          <div class="col-12 col-lg-6 mb-3" v-for="member in groupMembers">
            <user-card :user="member"></user-card>
          </div>
        </infinite-loader>
      </div>
    </div>
  </div>
</container-window>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import GroupRoute from './mixins/route'
import GroupMembers from './mixins/members'

export default {
  name: 'Group',

  data: () => ({
    query: ''
  }),

  computed: {
    title () {
      return this.group ? this.group.name : '...'
    },
    subtitle () {
      return this.group ? this.group.description : '...'
    },
    photo () {
      return this.group ? this.group.photo : ''
    },
    isAdmin () {
      return this.group ? this.group.is_admin : false
    }
  },

  methods: {
    async joinGroup (e) {
      e.target.classList.add('disabled')
      const { group } = await this.join(this.group.id)
      e.target.classList.remove('disabled')

      if (group) this.$router.push({ name: 'group.messages', params: { id: this.group.id } })
    },
    ...mapActions('groups', ['join'])
  },

  mixins: [GroupRoute, GroupMembers]
}
</script>


<style lang="scss">
@import '../../styles/variables';
@import '../../styles/methods';

.p-group-photo {
  width: to-rem(160px);
  height: to-rem(160px);
}

.p-group-privacy-tag {
  padding: $spacer / 2;
  font-size: 0.875rem;
  padding: 0.3rem;
}
</style>
