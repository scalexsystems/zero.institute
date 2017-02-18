import SettingsCard  from '../../components/settings/SettingsCard.vue'
import SettingsHeader  from '../../components/settings/SettingsHeader.vue'

export default {
  props: {},

  data: () => ({
    source: null,
    error: false,
    sourceChanged: true,
    editing: 0,
    trigger: false,
  }),

  methods: {
    async fetch() {
      this.sourceChanged = false
      const result = await this.callAPI()

      if (result) {
        this.source = result
        this.error = false
      } else {
        this.error = true
      }
    },
    sourceUpdated() {
      if (this.editing > 0) {
        this.sourceChanged = true
      } else {
        this.fetch();
      }
    },
    onAdd(){
      this.trigger = true
    },
    onCancel () {
      this.trigger = false
      this.source = null
    },

    sourceClicked(index, source){

    }
  },
  created() {
    this.fetch();
  },

  components: {
    SettingsHeader,
    SettingsCard,
  },

}

