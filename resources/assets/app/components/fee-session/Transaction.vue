<template lang="html">
<div class="card c-fee-session-transaction">
  <div class="card-block">
    <div class="row">

      <div class="col-12 col-lg-5">
        image & name
      </div>

      <div class="col-4 col-lg-2">
        mode
      </div>

      <div class="col-4 col-lg-2">
        reference
      </div>

      <div class="col-3 col-lg-2">
        amount
      </div>

      <div class="col-1">
        view/edit
      </div>

    </div>
  </div>
</div>
</template>

<script lang="babel">
export default {
  name: 'Transaction',

  props: {
    transaction: {
      type: Object,
      required: true
    }
  }
}
</script>


<style lang="scss">
.c-fee-session-transaction {
  + .c-fee-session-transaction {
    border-radius: 0;
    border-top: 0;
  }

  &:first-child {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  &:last-child {
    border-bottom-right-radius: inherit;
    border-bottom-left-radius: inherit;
  }
}
</style>
