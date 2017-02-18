<template>
<container-window title="Invites" subtitle="Invite students,teachers and employees of the institute">

  <template slot="sidebar">
  <sidebar/>
  </template>

  <div class="container-fluid text-center">
    <h2 class="text-center my-3 py-3">Invitations</h2>

    <p></p>
  </div>

  <invite-panel type="student"></invite-panel>
  <invite-panel type="teacher"></invite-panel>
  <invite-panel type="employee"></invite-panel>
</container-window>

</template>
<script lang="babel">
import InvitePanel from '../../components/invites/InvitePanel.vue'
import Sidebar from '../../components/settings/Sidebar.vue'

export default{
  name: 'InstituteInvite',
  data () {
    return {}
  },
  components: { InvitePanel, Sidebar }
}
</script>
<style>
</style>
