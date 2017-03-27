import scrollbar from 'perfect-scrollbar'

const isMobile = 'ontouchstart' in window || window.DocumentTouch && document instanceof window.DocumentTouch
const isMac = false // navigator.userAgent.indexOf('Mac OS X') !== -1

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
      if (isMac || isMobile) return

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
