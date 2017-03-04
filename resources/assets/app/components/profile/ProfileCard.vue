<template>
<div class="card c-profile-profile-card text-center">
  <div class="photo-wrapper d-flex">
    <photo-uploader v-if="$can('update-photo', source)"
                    :dest="`people/${source._type}s/${source.uid}/photo`"
                    class="profile-card-photo">
      <img class="card-img-top" :src="source.photo">
    </photo-uploader>
    <img v-else class="card-img-top profile-card-photo" :src="source.photo">
  </div>

  <div class="card-block">
    <h3 class="profile-card-name">{{ name }}</h3>

    <div class="row">
      <div class="col-12">
        <div class="profile-field mb-2">
          <div class="label">{{ uidLabel }}</div>
          <div class="value">{{ source.uid }}</div>
        </div>
      </div>
      <div class="col-12">
        <div class="profile-field mb-0">
          <div class="label">Email</div>
          <div class="value">{{ source.email}}</div>
        </div>
      </div>
    </div>
  </div>

  <hr class="m-0">

  <div class="card-block">
    <router-link class="card-link" :to="{ name: 'user.messages', params: { id: source.user_id } }">
      Send Message
    </router-link>

  </div>

  <hr class="m-0">

  <div class="card-block">
    <attendance-panel :source="source"></attendance-panel>
  </div>
</div>
</template>

<script lang="babel">
import SourceType from './view/type'
import AttendancePanel from '../attendance/View.vue'

export default {
  name: 'ProfileCard',

  props: {
    source: {
      type: Object,
      required: true
    }
  },
  components: { AttendancePanel },

  computed: {
    name () {
      if (!this.source.name) {
        return ''
      }

      return this.source.name.trim()
    },

    uidLabel () {
      const s = this.isStudent
      const t = this.isTeacher

      if (s) return 'Unique ID (Roll Number)'
      if (t) return 'Unique ID (Teacher ID Number)'
      return 'Unique ID (Employee ID Number)'
    }
  },

  mixins: [SourceType]
}
</script>


<style lang="scss">
@import '../../styles/variables';

.c-profile-profile-card {
  .photo-wrapper {
    position: relative;
    &:after {
      content: '';
      display: block;
      margin-bottom: 100%;
    }

    img {
      object-fit: cover;
    }

    .profile-card-photo {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
  }

  .profile-card-name:empty:before {
    color: $text-muted;
    content: 'Name not set!';
  }
}
</style>
