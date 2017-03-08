<template lang="html">
<div class="card c-fee-session-transaction-summary">
  <div class="card-block d-flex flex-row flex-wrap">

    <div class="pie-chart m-3"></div>

    <div class="flex-auto p-3">

      <div class="counter d-flex flex-row">
        <div class="flex-auto">
          <h1 class="mb-0">700</h1>
          <strong>Fee Paid</strong>
        </div>

        <div class="flex-auto">
          <h1 class="mb-0">200</h1>
          <strong>Remaining</strong>
        </div>
      </div>
      <hr>
      <div class="collection d-flex flex-row">
        <div class="flex-auto">
          <h2 class="mb-0">$200cr</h2>
          <strong>Collected</strong>
        </div>

        <div class="flex-auto">
          <h2 class="mb-0">$50cr</h2>
          <strong>Remaining</strong>
        </div>

        <div class="flex-auto">
          <h2 class="mb-0">$200cr</h2>
          <strong>Collected</strong>
        </div>
      </div>

    </div>

  </div>
</div>
</template>

<script lang="babel">
export default {
  name: 'FeeSessionTransactionSummary',

  props: {
    session: {
      type: Object,
      required: true,
    }
  }
}
</script>


<style lang="scss">
@import '../../styles/methods';

.c-fee-session-transaction-summary {
  height: 100%;

  .pie-chart {
    width: to-rem(139px);
    height: to-rem(139px);
  }
}
</style>
