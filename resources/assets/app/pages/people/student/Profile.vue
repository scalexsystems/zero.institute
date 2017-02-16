<template>
<container title="Student Profile" subtitle="Everything & anything you need to know about a student is here."
           @back="$router.go(-1)" back>

  <div class="container my-3">
    <div class="row" v-if="student">
      <div class="col-12 col-lg-4">
        <profile-card class="mb-3" :source="student"/>
      </div>
      <div class="col-12 col-lg-8">
        <alert type="info" v-if="sourceChanged">
          {{ student.first_name }}'s profile have been updated.
          <a href="#" role="button" @click.prevent="fetch">Click here</a> to load latest information.
        </alert>

        <personal-information class="mb-3" :source="student" :submit="update" @editing="editing += 1"
                              @edited="editing -= 1"/>
        <school-related-information class="mb-3" :source="student" :submit="update" @editing="editing += 1"
                                    @edited="editing -= 1"/>
        <contact-information class="mb-3" :source="student" :submit="updateAddress" @editing="editing += 1"
                             @edited="editing -= 1"/>
        <guardian-information class="mb-3" :source="student" :submit="updateFather" type="father"
                              title="Father's Information" @editing="editing += 1" @edited="editing -= 1"/>
        <guardian-information class="mb-3" :source="student" :submit="updateMother" type="mother"
                              title="Mother's Information" @editing="editing += 1" @edited="editing -= 1"/>
        <medical-information class="mb-3" :source="student" :submit="update" @editing="editing += 1"
                             @edited="editing -= 1"/>
      </div>
    </div>
    <div class="row" v-else-if="error">
      <div class="col-12">
        <div class="card card-block text-center card-outline-danger text-danger">
          You cannot access this profile.
        </div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-12">
        <loading/>
      </div>
    </div>
  </div>
</container>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import mixin from '../profile'

export default {
  name: 'Student',

  computed: {
    student () {
      return this.source
    }
  },

  methods: {
    async callAPI () {
      const { student } = await this.$store.dispatch('students/find', this.uid)

      return student
    },
    ...mapActions('students', ['update', 'updateAddress', 'updateFather', 'updateMother'])
  },

  channel: 'school',
  echo: {
    namespace: 'Student',

    PhotoUpdated ({ id, photo }) {
      if (id === this.student.id) {
        this.sourcePhotoUpdated(photo)
      }
    },

    Updated ({ id, uid }) {
      if (id === this.student.id) {
        this.sourceUpdated(uid)
      }
    }
  },

  mixins: [mixin]
}
</script>
