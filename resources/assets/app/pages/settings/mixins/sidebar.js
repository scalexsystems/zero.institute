import Sidebar from '../../../components/settings/Sidebar.vue'
import items from '../../../components/settings/items'

export default {
  data: () => ({
    editing: false
  }),

  computed: {
    sidebarItems: () => items,

    title () {
      const id = this.sidebarId

      return this.sidebarItems.find(item => id === item.id).title
    },

    subtitle () {
      const id = this.sidebarId

      return this.sidebarItems.find(item => id === item.id).subtitle
    }
  },

  methods: {
    onEdit () {
      this.editing = true
    }
  },

  components: { Sidebar }
}
