import throttle from 'lodash.throttle'
import { notLastPage, nextPage, toArray, toInt } from '../../util'
import StudentCard from '../../components/student/Card.vue'
import TeacherCard from '../../components/teacher/Card.vue'
import EmployeeCard from '../../components/employee/Card.vue'

export default {
  data: () => ({
    department: [],
    items: [],
    query: '',
    ignoreChanges: false,
    page: 1
  }),

  computed: {
    countText () {
      const items = this.items

      return items.length === 1 ? `1 ${this.type}` : `${items.length} ${this.type}s`
    },
    searchText () {
      return `All ${this.type}s`
    }
  },

  methods: {
    onInput: throttle(function onInput () {
      this.page = 1
      this.fetch()
    }, 400),
    async onInfinite ({ loaded, complete }) {
      notLastPage(await this.fetch()) ? loaded() : complete()
    },
    async fetch () {
      const { items, meta } = await this.callAPI()

      if (items) {
        if (this.page === 1) {
          this.items = items
        } else {
          this.items.push(...items.filter(s => this.items.findIndex(o => o.id === s.id) < 0))
        }
      } else {
        this.items = []
      }

      this.page = nextPage(meta)

      return meta
    },
    go () {
      const query = {}

      if (this.ignoreChanges) return

      if (this.query.trim().length) {
        query.q = this.query
      }

      if (this.discipline && this.discipline.length) {
        query.discipline = this.discipline.slice()
      }

      if (this.department.length) {
        query.department = this.department.slice()
      }

      this.$router.replace({ name: `${this.type}.index`, query })
    },

    getRouteParams () {
      this.ignoreChanges = true
      this.page = 1
      this.query = this.$route.query.q || ''
      if (this.discipline) {
        this.discipline = toArray(this.$route.query.discipline || []).map(toInt)
      }
      this.department = toArray(this.$route.query.department || []).map(toInt)
      this.$nextTick(() => {
        this.ignoreChanges = false
      })
      this.fetch()
    }
  },

  created () {
    this.getRouteParams()
  },

  components: { StudentCard, TeacherCard, EmployeeCard },

  watch: {
    discipline: 'go',
    department: 'go',
    $route: 'getRouteParams'
  }
}
