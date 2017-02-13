import scrollbar from 'perfect-scrollbar'

export default {

  data () {
    return {
      bars: false
    }
  },

  methods: {
    /**
     * Add scrollbar if required.
     */
    addBars () {
      if (this.scroll === false || this.bars) return

      const el = this.scrollSelector === true ? this.$el : this.$el.querySelector(this.scrollSelector)

      if (el) {
        scrollbar.initialize(el, { suppressScrollX: true })
        this.bars = true
      } else {
        setTimeout(() => this.addBars(), 200)
      }
    },
    /**
     * Remove scrollbar if exists.
     *
     * @return void
     */
    removeBars () {
      if (this.scroll === false) return

      const el = this.scrollSelector === true ? this.$el : this.$el.querySelector(this.scrollSelector)

      if (el) {
        scrollbar.destroy(el)
        this.bars = false
      }
    }
  },

  mounted () {
    this.addBars()
  },

  beforeDestroy () {
    this.removeBars()
  }
}
