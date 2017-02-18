import throttle from 'lodash.throttle'

export default {
  data () {
    return {
      query: '',
      suggestions: []
    }
  },

  methods: {
    onSearchInput: throttle(function onSearchInput() {
      this.fetch()
    }, 400),

    onInput (value) {
      this.query = value

      this.onSearchInput()
    },

    async fetch () {
      const { items } = await this.callAPI(this.query)

      if (items) {
        this.suggestions = items
      }
    },

    onSearch () {
      this.$router.push({ name: `${this.type}.index`, query: { q: this.query } })
    },

    onSelect ({ uid }) {
      this.$router.push({ name: `${this.type}.show`, params: { uid } })
    }
  },

  created () {
    this.fetch()
  }
}