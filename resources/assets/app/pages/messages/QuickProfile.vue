<template>
<container-window v-bind="{ title, subtitle }" @back="$router.go(-1)" back>

  <div v-if="user" class="container py-2">
    <div class="text-center">

      <img class="user-preview-photo my-2" :src="user.photo">

      <h2>{{ user.name }}</h2>
      <p>
        <span class="text-muted" v-if="user.type === 'student'">Roll Number:</span>
        <span class="text-muted" v-else>Employee ID:</span> {{ user.person.uid }}
      </p>
      <p v-if="user.type === 'student'">
        Student &centerdot; {{ department.name }}
      </p>
      <p v-else-if="user.type === 'teacher'">
        {{ user.person.designation || 'Teacher' }} &centerdot; {{ department.name }}
      </p>
      <p v-else-if="user.type === 'employee'">
        {{ user.person.designation || 'Employee' }} &centerdot; {{ department.name }}
      </p>

      <div class="my-3">
        <router-link :to="{name: 'user.messages', params: { id: user.id } }" class="btn btn-primary">Send Message</router-link>
        <router-link :to="{name:`${user.type}.show`, params: { uid: user.person.uid } }" class="btn btn-secondary">View Profile</router-link>
      </div>



    </div>

    <div class="my-5" v-id="user.type == 'student'">
      <attendance-display :source="user"></attendance-display>
    </div>
  </div>

  <loading v-else/>
</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import UserRoute from './mixins/route'
import AttendanceDisplay from '../../components/attendance/AttendanceDisplay.vue'

export default {
  name: 'User',

  computed: {
    title () {
      const user = this.user || {}

      return user.name || '...'
    },
    subtitle () {
      const user = this.user || {}

      return user.bio || 'View information'
    },
    department () {
      const user = this.user || { person: {} }

      return this.departmentById(user.person.department_id) || {}
    },
    ...mapGetters('departments', ['departmentById'])
  },

  mixins: [UserRoute],
  components: { AttendanceDisplay }
}
</script>

<style lang="scss">
@import "../../styles/variables";
@import "../../styles/methods";

.user-preview {
  &-photo {
    width: to-rem(160px);
    height: to-rem(160px);
    border-radius: $border-radius-sm;
  }
  &-tag {
    padding: $spacer / 2;
  }
}
</style>
