<template>
<container-window v-bind="{ title, subtitle }">
  <template slot="sidebar">
  <sidebar/>
  </template>

  <div class="container-zero my-3 py-3 text-center">
    <img src="../../assets/settings/roles.svg">
  </div>

  <div class="container-zero py-3">
    <div class="row">

      <h2 class="col-12 text-center">{{ title }}</h2>

      <p class="col-12 text-center">Assign roles to teachers & employees.</p>

    </div>
  </div>

  <div v-for="role in roles">

    <h6 class="split-header text-uppercase my-3 py-3">{{ role.name }}</h6>

    <div class="container-zero py-3">
      <div class="row">

        <p class="col-12 pb-3 text-center">{{ role.description }}</p>

        <div class="col-12">
          <typeahead v-bind="{ suggestions: people, value: [] }"
                     component="SelectOptionUser" placeholder="Start typing..."
                     @search="onSearch" @select="user => add(role, user)"/>
        </div>

        <div class="col-12 mt-3" v-if="role.$error">
          <alert type="danger" v-html="role.$error"/>
        </div>

        <div class="col-12 col-lg-6 mt-3" v-for="person in role.$users">
          <person-card :person="person" remove @remove="remove(role, person)" :class="{ disabled: person.$wait }"/>
        </div>

        <div v-if="role.$users.length === 0" class="col-12 py-3 my-3 text-center text-muted">
          Choose a teacher or employee
        </div>

      </div>
    </div>

  </div>

  <div style="margin-bottom: 160px"></div>

</container-window>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapActions, mapGetters } from 'vuex'
import { clone } from '../../util'
import PersonCard from '../../components/user/person-card'
import Sidebar from './mixins/sidebar'

export default {
  name: 'Roles',

  data: () => ({
    roles: [],
    people: []
  }),

  computed: {
    sidebarId: () => 'settings.roles'
  },

  methods: {
    async remove (role, user) {
      if (user.$wait === true) return false

      user.$wait = true
      role.$error = null
      const result = await this.revoke({ role: role.id, user: user.user_id })
      user.$wait = false

      if (result === true) {
        const index = role.$users.findIndex(u => user.id === u.id)

        if (index > -1) role.$users.splice(index, 1)
      } else if ('errors' in result) {
        role.$error = result.errors.$message
      }
    },

    async add (role, user) {
      if (role.$users.findIndex(u => user.id === u.id) > -1) return false

      user = clone(user)

      role.$users.push(user)
      user.$wait = true
      role.$error = null
      const result = await this.assign({ role: role.id, user: user.user_id })

      if (result === true) {
        user.$wait = false
      } else {
        role.$error = result.errors.$message

        const index = role.$users.findIndex(u => user.id === u.id)

        if (index > -1) role.$users.splice(index, 1)
      }
    },

    async getAllRoles () {
      const { roles } = await this.index()

      this.roles = (roles || []).map(role => ({ $users: [], ...role }))

      for (let i = 0; i < this.roles.length; i += 1) {
        const { users } = await this.users(this.roles[i].id)

        this.roles[i].$users = (users || []).map(user => ({ $wait: false, ...user }))
      }
    },

    onSearch: throttle(async function (q = '') {
      const { items } = await this.search({ q, personType: ['teacher', 'employee'] })

      this.people = items || []
    }, 400),

    ...mapActions('roles', ['index', 'users', 'assign', 'revoke']),

    ...mapActions('people', { search: 'index' })
  },

  created () {
    this.getAllRoles()
    this.onSearch()
  },

  components: { PersonCard },

  mixins: [Sidebar]
}
</script>
