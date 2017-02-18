<template>
<container-window v-bind="{ title, subtitle }">
  <template slot="sidebar">
  <sidebar/>
  </template>

  <template slot="buttons">
  <input-button value="Add New" @click.native="create"/>
  </template>

  <modal :open="editing" @close="editing = false" :dismissable="false">
    <create-session v-if="current === null" @done="editing = false"/>
    <edit-session v-else v-bind="{ session: current }" @done="editing = false"/>
  </modal>

  <div class="container-zero py-3">
    <div class="row">

      <h2 class="col-12 text-center">{{ title }}</h2>

      <div class="col-12 col-lg-6 mt-3" v-for="session in sessions">
        <session-card v-bind="{ session, footer: true }" role="button" @click.native="edit(session)"/>
      </div>

    </div>
  </div>

</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import Sidebar from './mixins/sidebar'
import SessionCard from '../../components/session/Card.vue'
import CreateSession from '../../components/session/Create.vue'
import EditSession from '../../components/session/Edit.vue'

export default {
  name: 'InstituteSessions',

  data: () => ({
    current: null
  }),

  computed: {
    sidebarId: () => 'settings.sessions',
    ...mapGetters('sessions', ['sessions'])
  },

  methods: {
    edit (session) {
      this.current = session

      this.onEdit()
    },

    create () {
      this.current = null

      this.onEdit()
    }
  },

  components: { CreateSession, SessionCard, EditSession },

  mixins: [Sidebar]
}
</script>


<style lang="scss">
</style>
