<template>
    <settings-box title="Invites" subtitle="Invite students, teachers and employees of the institiute">

        <template slot="header-image">
            <img src="../assets/settings/invites.svg">
        </template>

        <template slot="name">
            Send Invites
        </template>

        <template slot="description">
            Invite students, teachers and employees of the institute
        </template>

        <template slot="settings-body">
            <div class="container py-2">
                <div class="row my-2">
                    <div class="col-xs-12 col-lg-12">
                        <div class="fl fl-middle">
                            <hr class="fl-auto">
                            <small class="px-1 text-uppercase">
                                Invite Students
                            </small>
                            <hr class="fl-auto">
                        </div>


                        <div class="invite-input input-group input-group-lg">
                        <input class="form-control" type="text" placeholder="enter alias address e.g. students@domain.com"
                               v-model="students">
                    </div>

                <div class="row">
                  <div class="col-xs-12 col-lg-8 text-muted">
                     An invite will be sent to all students via this list

                  </div>
                  <div class="col-xs-12 col-lg-4 text-muted text-lg-right">
                  {{ invited.students }} invited
                  </div>
                </div>
                    <div class="invite-actions">
                        <div class="btn btn-default" role="button" @click="cancel('students')"> Cancel </div>
                        <div class="btn btn-primary" role="button" @click="sendStudentsInvite"> Send Invite  </div>
                    </div>
                  </div>
                </div>
                <div class="row my-2">
                    <div class="col-xs-12 col-lg-12">
                        <div class="fl fl-middle">
                            <hr class="fl-auto">
                            <small class="px-1 text-uppercase">
                                Invite Teachers
                            </small>
                            <hr class="fl-auto">
                        </div>

                        <div class="invite-input input-group input-group-lg">
                        <input class="form-control" type="text" v-model="teachers"
                               placeholder="enter alias address e.g. teachers@domain.com">
                    </div>

                <div class="row">
                  <div class="col-xs-12 col-lg-8 text-muted">
                     An invite will be sent to all teachers via this list

                  </div>
                  <div class="col-xs-12 col-lg-4 text-muted text-lg-right">
                  {{ invited.teachers }} invited
                  </div>
                </div>
                    <div class="invite-actions">
                        <div class="btn btn-default" role="button" @click="cancel('teachers')"> Cancel </div>
                        <div class="btn btn-primary" role="button" @click="sendTeachersInvite"> Send Invite  </div>
                    </div>
                  </div>
                </div>
                <div class="row my-2">
                    <div class="col-xs-12 col-lg-12">
                        <div class="fl fl-middle">
                            <hr class="fl-auto">
                            <small class="px-1 text-uppercase">
                                Invite Non-Teaching Employees
                            </small>
                            <hr class="fl-auto">
                        </div>

                        <div class="invite-input input-group input-group-lg">
                        <input class="form-control" type="text" v-model="employees"
                               placeholder="enter alias address e.g. employees@domain.com">
                    </div>

                <div class="row">
                  <div class="col-xs-12 col-lg-8 text-muted">
                     An invite will be sent to all employees via this list

                  </div>
                  <div class="col-xs-12 col-lg-4 text-muted text-lg-right">
                  {{ invited.employees }} invited
                  </div>
                </div>
                    <div class="invite-actions">
                        <div class="btn btn-default" role="button" @click="cancel('employees')"> Cancel </div>
                        <div class="btn btn-primary" role="button" @click="sendEmployeesInvite"> Send Invite  </div>
                    </div>
                  </div>
                </div>
            </div>
        </template>
    </settings-box>

</template>
<script lang="babel">
import SettingsBox from './SettingsBox.vue';

export default{
  created() {
  },
  data() {
    return {
      onAdd: false,
      loaded: false,
      students: '',
      teachers: '',
      employees: '',
      invited: {
        students: 0,
        teachers: 0,
        employees: 0,
      },
      errors: {},
    };
  },
  computed: {
  },
  methods: {
    sendStudentsInvite() {
      this.sendInvite('students');
    },

    sendTeachersInvite() {
      this.sendInvite('teachers');
    },

    sendEmployeesInvite() {
      this.sendInvite('employees');
    },

    sendInvite(type) {
      const emails = this.getArrayFromString(this[type]);
      if (emails) {
        const entries = this.validateEmails(emails);
        if (entries.length) {
          this.$http.post(`people/${type}/invite`, { [type]: entries })
           .then(() => {
             this.invited[type] += entries.length;
             this[type] = emails.filter(email => entries.indexOf(email) < 0).join(', ');
           });
        }
      }
    },

    getArrayFromString(string) {
      return string.split(/[;,\s\r\n\t]+/g);
    },
    cancel(type) {
      this[type] = '';
    },
    validateEmails(emails) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return emails.filter(email => re.test(email));
    },
  },
  components: { SettingsBox },
};
</script>
<style lang="scss" scoped>
@import '../styles/methods';
@import '../styles/variables';
.invite {
  &-input {
   padding: rem(20px) 0 rem(10px);
 }

  &-actions {
   padding: rem(20px) 0;
  }

}
.btn-default{
  border: solid 1px $gray;
}
.btn {
  margin: 0 rem(2px);
  width: rem(100px);
}

</style>
