import {
  ContactInformation,
  GuardianInformation,
  MedicalInformation,
  PersonalInformation,
  ProfileCard,
  SchoolRelatedInformation
} from '../../components/profile'

export default {

  props: {
    uid: {
      type: String,
      required: true
    }
  },

  data: () => ({
    source: null,
    error: false,
    sourceChanged: false,
    editing: 0
  }),

  methods: {
    async fetch () {
      this.sourceChanged = false
      const result = await this.callAPI()

      if (result) {
        this.source = result
        this.error = false
      } else {
        this.error = true
      }
    },

    sourceUpdated (uid) {
      if (uid !== this.source.uid) {
        this.$router.replace({ params: { uid }})

        return
      }

      if (this.editing > 0) {
        this.sourceChanged = true
      } else {
        this.fetch()
      }
    },

    sourcePhotoUpdated (photo) {
      this.source.photo = photo
    }
  },

  created () {
    this.fetch()
  },

  components: {
    ContactInformation,
    GuardianInformation,
    MedicalInformation,
    PersonalInformation,
    ProfileCard,
    SchoolRelatedInformation
  },

  watch: {
    uid (uid, oldUID) {
      if (uid === oldUID) return

      this.source = null
      this.error = false

      this.fetch()
    }
  }
}
