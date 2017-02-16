<template>
<container title="Employee Profile" subtitle="Everything & anything you need to know about a employee is here."
           @back="$router.go(-1)" back>

  <div class="container my-3">
    <div class="row" v-if="employee">
      <div class="col-12 col-lg-4">
        <profile-card class="mb-3" :source="employee"/>
      </div>
      <div class="col-12 col-lg-8">
        <alert type="info" v-if="sourceChanged">
          {{ employee.first_name }}'s profile have been updated.
          <a href="#" role="button" @click.prevent="fetch">Click here</a> to load latest information.
        </alert>
        <personal-information class="mb-3" :source="employee" :submit="update" @editing="editing += 1"
                              @edited="editing -= 1"/>
        <school-related-information class="mb-3" :source="employee" :submit="update" @editing="editing += 1"
                                    @edited="editing -= 1"/>
        <contact-information class="mb-3" :source="employee" :submit="updateAddress" @editing="editing += 1"
                             @edited="editing -= 1"/>
        <medical-information class="mb-3" :source="employee" :submit="update" @editing="editing += 1"
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
  name: 'Employee',

  computed: {
    employee() {
      return this.source
    }
  },

  methods: {
    async callAPI () {
      const { employee } = await this.$store.dispatch('employees/find', this.uid)

      return employee;
    },

    ...mapActions('employees', ['update', 'updateAddress'])
  },

  channel: 'school',
  echo: {
    namespace: 'Employee',
    PhotoUpdated ({ id, photo }) {
      if (id === this.employee.id) {
        this.sourcePhotoUpdated(photo)
      }
    },
    Updated ({ id, uid }) {
      if (id === this.employee.id) {
        this.sourceUpdated(uid)
      }
    }
  },

  mixins: [mixin]
}
</script>

<style lang="scss" scoped>
.card-header {
  padding: 1.25rem;
}

.employee-photo {
  width: 100%;
}

.employee-field {
  margin-bottom: 2rem;
  .label {
    font-size: .75rem;
    color: #b3b3b3;
  }
}

.value:empty:before {
  content: "xxx x xxxx";
  opacity: 0.1;
}
</style>
