<template>
<div>
  <h6 class="split-header text-uppercase text-muted">Invite {{ type }}s</h6>

  <div class="container-zero my-3 py-3">
    <input-textarea title="Send email invites" :errors="errors" :placeholder="placeholder" v-model="emails"
                    subtitle="yes">

      <template slot="subtitle">
      <div class="d-flex flex-row">
        <div class="flex-auto">An invite will be sent to all {{ type }}s using this list.</div>
        <div class="ml-auto text-muted">{{ invited }} Invited</div>
      </div>
      </template>

    </input-textarea>

    <div class="text-right mt-3">
      <div class="btn btn-default" role="button" @click="cancel" v-if="emails && emails.trim().length > 0">Reset</div>
      <div class="btn btn-primary" role="button" @click="sendInvite">Send Invite</div>
    </div>

  </div>
</div>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import { formHelper } from 'bootstrap-for-vue'

export default {
  name: 'InvitePanel',
  props: {
    type: {
      type: String,
      required: true
    }
  },
  data: () => ({
    invited: 0,
    emails: '',
  }),
  computed: {
    placeholder () {
      return `Enter alias address e.g. ${this.type}@domain.com`
    }
  },

  methods: {
    cancel () {
      this.emails = ''
    },
    async sendInvite () {
      const emails = this.getArrayFromString(this.emails)
      if (emails) {
        const entries = this.validateEmails(emails)
        if (entries.length) {
          const { errors } = await this.store({ emails: entries, type: this.type })
          if (errors) {
            this.setErrors(errors)
          } else {
            this.invited += entries.length
            this.emails = ''
          }
        }
      }
    },
    getArrayFromString (string) {
      return string.split(/[;,\s\r\n\t]+/g)
    },
    validateEmails (emails) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return emails.filter(email => re.test(email))
    },

    ...mapActions('invitations', ['store'])
  },

  mixins: [formHelper]
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

.btn-default {
  border: solid 1px $gray;
}

.btn {
  margin: 0 rem(2px);
  width: rem(100px);
}

</style>
