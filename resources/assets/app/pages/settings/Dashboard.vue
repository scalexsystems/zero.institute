<template>
<container title="Settings" subtitle="Configure institute preferences">
  <template slot="sidebar">
  <sidebar/>
  </template>


  <div class="container-zero">
    <div class="row">

      <div class="col-12 my-3 py-3 text-center">
        <img src="../../assets/settings/icon-settings.svg" class="rounded-circle" height="154" width="154">
      </div>

      <h2 class="col-12 my-3 pb-3 text-center">Institute Administrative Settings</h2>

      <div class="col-12 col-lg-6 mb-3" v-for="item in sidebarItems">
        <router-link tag="div" class="card card-block" :to="{ name: item.id }" role="button">
          <strong class="d-block">{{ item.title }}</strong>
          <small class="d-block">{{ item.subtitle }}</small>
        </router-link>
      </div>

    </div>
  </div>
</container>
</template>

<script lang="babel">
import Sidebar from './mixins/sidebar'

export default {
  name: 'SettingsDashboard',

  mixins: [Sidebar]
}
</script>


<style lang="scss"></style>
