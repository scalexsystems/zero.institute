<template>
<div class="row">
    <h6 class="split-header text-uppercase col-lg-12">
        Invite {{ type }}s
    </h6>

    <div class="col-12 col-lg-12">
        <div class="invite-input input-group input-group-lg">
            <input class="form-control" type="text" :errors="errors" :placeholder="placeholder"
                   v-model="emails">
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 text-muted">
                An invite will be sent to all {{ type }}s via this list

            </div>
            <div class="col-12 col-lg-4 text-muted text-lg-right">
                {{ invited }} invited
            </div>
        </div>
        <div class="invite-actions py-3">
            <div class="btn btn-default" role="button" @click="cancel"> Cancel </div>
            <div class="btn btn-primary" role="button" @click="sendInvite"> Send Invite  </div>
        </div>
    </div>
    </div>

</template>

<script lang="babel">
import { mapActions } from 'vuex'
export default {
  name: 'InvitePanel',
  props: {
    type: {
      type: String,
      required: true
    },
  },
    data: () => ({
    invited: 0,
    emails: '',
    errors: null,
  }),
  computed: {
    placeholder() {
      return `enter alias address e.g. ${this.type}@domain.com`
    }
  },

  methods: {
    cancel() {
     this.emails = '';
    },
    async sendInvite () {
          const emails = this.getArrayFromString(this.emails)
          if (emails) {
              const entries = this.validateEmails(emails)
              if (entries.length) {
                const { errors } = await this.store({ emails: entries });
                if(errors) {
                    this.errors = errors;
                } else {
                   this.invited += entries.length;
                   this.emails = '';
                }
          }
    },
    cancel (type) {
      this[type] = ''
    },
    getArrayFromString (string) {
          return string.split(/[;,\s\r\n\t]+/g)
    },
    validateEmails (emails) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return emails.filter(email => re.test(email))
    },

    ...mapActions('invitations', ['store']),
  },
}
</script>

<style lang="scss" scoped>
@import '../../styles/methods';
@import '../../styles/variables';
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
