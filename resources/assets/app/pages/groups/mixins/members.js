import { mapActions, mapGetters } from 'vuex'

export default {
  data: () => ({
    membersRequestSent: false
  }),

  computed: {
    groupMembers () {
      const members = this.membersByGroupId(this.id)

      if (!members) return []

      return [...members].sort((a, b) => a.name.localeCompare(b.name))
    },
    ...mapGetters('groups', ['membersByGroupId'])
  },

  methods: {
    async fetchMembers ({ loaded = () => 0, complete = () => 0 } = {}) {
      if (this.membersRequestSent === true) {
        loaded()

        return true
      }

      if (!this.group)  {
        complete()

        return false
      }

      this.membersRequestSent = true
      const { meta } = await this.fetchMembersAPI({ group: this.group })
      this.membersRequestSent = false

      if (meta && meta.pagination.current_page < meta.pagination.total_pages) {
        loaded()

        return true
      }

      complete()
    },
    ...mapActions('groups', { fetchMembersAPI: 'members' })
  },

  created () {
    this.fetchMembers()
  },

  watch: {
    group (group, oldGroup) {
      if (oldGroup && group.id !== oldGroup.id) {
        this.membersRequestSent = false
        this.$refs && this.$refs.is && this.$refs.is.$emit('reset')
      }

      this.$nextTick(() => this.fetchMembers())
    }
  }
}