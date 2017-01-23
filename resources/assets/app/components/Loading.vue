<template>
<div class="loading-container">
  <div>
    <div class="state-loading">
      <div class="cord leftMove">
        <div class="ball"></div>
      </div>
      <div class="cord">
        <div class="ball"></div>
      </div>
      <div class="cord">
        <div class="ball"></div>
      </div>
      <div class="cord">
        <div class="ball"></div>
      </div>
      <div class="cord">
        <div class="ball"></div>
      </div>
      <div class="cord">
        <div class="ball"></div>
      </div>
      <div class="cord rightMove">
        <div class="ball" id="first"></div>
      </div>

      <div class="shadows">
        <div class="leftShadow"></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div class="rightShadow"></div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
export default {};
</script>

<style lang="scss">
@import '../styles/variables';

$state-loading-width: 106px !default;
$state-loading-height: 150px !default;

.loading-container {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%;
}

.state-loading {
  height: $state-loading-height;
  width: $state-loading-width;
  text-align: center;

  .cord {
    padding-top: $state-loading-height - 50px;
    width: 15px;
    transform: rotate(0deg);
    transform-origin: 50% 50%;
    float: left;
  }

  .ball {
    background: #222;
    width: 15px;
    height: 15px;
    float: left;
    border-radius: 50%;
  }

  .shadows {
    clear: left;
    padding-top: 20px;
    margin-left: -2px;
  }

  .shadows div {
    float: left;
    margin-left: 2px;
    width: 13px;
    height: 3px;
    border-radius: 50%;
    box-shadow: 0 0 3px rgba(204, 204, 204, 0.3);
    background: rgba(204, 204, 204, 0.3);
  }
  .leftMove { animation: leftBall .5s ease-in-out 0s infinite alternate; }
  .rightMove { animation: rightBall .5s ease-in-out 0s infinite alternate; }
  .leftShadow { animation: leftShadowN .5s ease-in-out 0s infinite alternate; }
  .rightShadow { animation: rightShadowN .5s ease-in-out 0s infinite alternate; }
}
@keyframes leftBall {
  0% { transform: rotate(0deg) translateY(0px); }
  50% { transform: rotate(0deg) translateY(0px); }
  100% { transform: rotate(50deg) translateY(-20px); }
}
@keyframes rightBall {
  0% { transform: rotate(-50deg) translateY(-20px); }
  50% { transform: rotate(0deg) translateY(0px); }
  100% { transform: rotate(0deg) translateY(0px) translateX(0px); }
}
@keyframes leftShadowN {
  0% { transform: translateX(0px); }
  50% { transform: translateX(0px); }
  100% { transform: translateX(-25px); }
}
@keyframes rightShadowN {
  0% { transform: translateX(25px); }
  50% { transform: translateY(0px); }
  100% { transform: translateY(0px); }
}
</style>
