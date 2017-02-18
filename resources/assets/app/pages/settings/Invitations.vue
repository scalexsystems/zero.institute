<template>
   <container-window title="Invites" subtitle="Invite students,teachers and employees of the institute">

    <template slot="sidebar">
        <sidebar/>
    </template>

    <div class="container py-2">
        <div class="my-2 py-3 mt-3">
            <invite-panel type="student"></invite-panel>
        </div>
        <div class="my-2 py-3 mt-3">
            <invite-panel type="teacher"></invite-panel>
        </div>
        <div class="my-2 py-3 mt-3">
            <invite-panel type="employee"></invite-panel>
        </div>
    </div>
</container-window>

</template>
<script lang="babel">
import InvitePanel from '../../components/invites/invitePanel.vue'
import Sidebar from '../../components/settings/Sidebar.vue'

export default{
  name: 'InstituteInvite',
  data () {
    return {
    }
  },
  components: { InvitePanel, Sidebar }
}
</script>
<style>
</style>
