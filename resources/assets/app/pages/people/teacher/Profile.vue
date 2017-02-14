<template>
<container title="Teacher Profile" subtitle="Everything & anything you need to know about a teacher is here."
           @back="$router.go(-1)" back>

  <div class="container my-3">
    <div class="row" v-if="teacher">
      <div class="col-12 col-lg-4">
        <profile-card class="mb-3" :source="teacher"/>
      </div>
      <div class="col-12 col-lg-8">
        <alert type="info" v-if="sourceChanged">
          {{ teacher.first_name }}'s profile have been updated.
          <a href="#" role="button" @click.prevent="fetch">Click here</a> to load latest information.
        </alert>
        <personal-information class="mb-3" :source="teacher" :submit="update" @editing="editing += 1"
                              @edited="editing -= 1"/>
        <school-related-information class="mb-3" :source="teacher" :submit="update" @editing="editing += 1"
                                    @edited="editing -= 1"/>
        <contact-information class="mb-3" :source="teacher" :submit="updateAddress" @editing="editing += 1"
                             @edited="editing -= 1"/>
        <medical-information class="mb-3" :source="teacher" :submit="update" @editing="editing += 1"
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
  name: 'Teacher',

  computed: {
    teacher () {
      return this.source
    }
  },

  methods: {
    async callAPI () {
      const { teacher } = await this.$store.dispatch('teachers/find', this.uid)

      return teacher
    },

    ...mapActions('teachers', ['update', 'updateAddress'])
  },

  channel: 'school',
  echo: {
    namespace: 'Teacher',
    TeacherPhotoUpdated ({ id, photo }) {
      if (id === this.teacher.id) {
        this.sourcePhotoUpdated(photo)
      }
    },
    TeacherUpdated ({ id, uid }) {
      if (id === this.teacher.id) {
        this.sourceUpdated(uid)
      }
    }
  },

  mixins: [mixin]
}
</script>
