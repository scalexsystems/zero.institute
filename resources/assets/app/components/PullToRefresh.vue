<template>
<div class="pull-to-refresh-container" v-show="isLoading">
  <slot name="spinner">
    <i :class="spinnerType"></i>
  </slot>
  <div class="pull-to-refresh-status-prompt" v-show="!isLoading && isComplete && isFirstLoad">
    <slot name="no-results">No results :(</slot>
  </div>
  <div class="pull-to-refresh-status-prompt" v-show="!isLoading && isComplete && !isFirstLoad">
    <slot name="no-more">No more data :)</slot>
  </div>
</div>
</template>
<script lang="babel">
const spinnerMapping = {
  bubbles: 'loading-bubbles',
  circles: 'loading-circles',
  default: 'loading-default',
  spiral: 'loading-spiral',
  waveDots: 'loading-wave-dots',
};

/**
 * get the first scroll parent of an element
 * @param  {DOM} elm    the element which find scroll parent
 * @return {DOM}        the first scroll parent
 */
function getScrollParent(elm) {
  if (elm.tagName === 'BODY') {
    return window;
  } else if (['scroll', 'auto'].indexOf(window.getComputedStyle(elm).overflowY) > -1) {
    return elm;
  }
  return getScrollParent(elm.parentNode);
}

/**
 * get current distance from footer
 * @param  {DOM} elm    scroll element
 * @return {Number}     distance
 */
function getCurrentDistance(elm) {
  /*
   const styles = getComputedStyle(elm === window ? document.body : elm);
   const innerHeight = elm === window
   ? window.innerHeight
   : parseInt(styles.height, 10);
   const scrollHeight = elm === window
   ? document.body.scrollHeight
   : elm.scrollHeight;
   */
  const scrollTop = isNaN(elm.scrollTop) ? elm.pageYOffset : elm.scrollTop;
  // const paddingTop = parseInt(styles.paddingTop, 10);
  // const paddingBottom = parseInt(styles.paddingBottom, 10);

  return scrollTop;
}

export default {
  data() {
    return {
      scrollParent: null,
      scrollHandler: null,
      isLoading: false,
      isComplete: false,
      isFirstLoad: true, // save the current loading whether it is the first loading
    };
  },
  computed: {
    spinnerType() {
      return spinnerMapping[this.spinner] || spinnerMapping.default;
    },
  },
  props: {
    distance: {
      type: Number,
      default: 0,
    },
    onInfinite: Function,
    spinner: String,
  },
  mounted() {
    this.scrollParent = getScrollParent(this.$el);

    this.scrollHandler = () => {
      const currentDistance = getCurrentDistance(this.scrollParent);
      if (!this.isLoading && currentDistance <= this.distance) {
        this.isLoading = true;
        if (this.onInfinite) {
          this.onInfinite.call();
        }
      }
    };

    setTimeout(this.scrollHandler, 1);
    this.scrollParent.addEventListener('scroll', this.scrollHandler);

    this.$on('$InfiniteLoading:loaded', () => {
      this.isLoading = false;
      this.isFirstLoad = false;
    });
    this.$on('$InfiniteLoading:complete', () => {
      this.isLoading = false;
      this.isComplete = true;
      this.scrollParent.removeEventListener('scroll', this.scrollHandler);
    });
    this.$on('$InfiniteLoading:reset', () => {
      this.isLoading = false;
      this.isComplete = false;
      this.isFirstLoad = true;
      this.scrollParent.addEventListener('scroll', this.scrollHandler);
      setTimeout(this.scrollHandler, 1);
    });
  },
  destroyed() {
    if (!this.isComplete) {
      this.scrollParent.removeEventListener('scroll', this.scrollHandler);
    }
  },
};

</script>

<style lang="scss" scoped>
$size: 6px;
.pull-to-refresh {
  &-container {
    clear: both;
    text-align: center;
    *[class^=loading-] {

    }

    .loading-default {
      position: relative;
      border: 1px solid #999;
      animation: ease loading-rotating 1.5s infinite;
      &:before {
        content: '';
        position: absolute;
        display: block;
        top: 0;
        left: 50%;
        margin-top: -$size/2;
        margin-left: -$size/2;
        width: $size;
        height: $size;
        background-color: #999;
        border-radius: 50%;
      }
    }
    .loading-spiral {
      border: 2px solid #777;
      border-right-color: transparent;
      animation: linear loading-rotating .85s infinite;
    }
    .loading-bubbles {
      $bubblesSize: 1px;
      $bubblesRadius: 12px;
      $bubblesShallow: .4px;
      $bubblesColor: #666;
      position: relative;
      &:before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        margin-top: -$bubblesSize/2;
        margin-left: -$bubblesSize/2;
        width: $bubblesSize;
        height: $bubblesSize;
        border-radius: 50%;
        animation: linear loading-bubbles .85s infinite;
      }
      @keyframes loading-bubbles {
        0% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 1) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 2) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 3) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 4) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 5) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 6) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 7) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 8) $bubblesColor;
        }
        12.5% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 8) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 1) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 2) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 3) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 4) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 5) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 6) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 7) $bubblesColor;
        }
        25% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 7) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 8) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 1) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 2) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 3) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 4) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 5) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 6) $bubblesColor;
        }
        37.5% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 6) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 7) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 8) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 1) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 2) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 3) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 4) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 5) $bubblesColor;
        }
        50% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 5) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 6) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 7) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 8) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 1) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 2) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 3) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 4) $bubblesColor;
        }
        62.5% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 4) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 5) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 6) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 7) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 8) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 1) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 2) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 3) $bubblesColor;
        }
        75% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 3) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 4) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 5) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 6) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 7) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 8) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 1) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 2) $bubblesColor;
        }
        87.5% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 2) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 3) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 4) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 5) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 6) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 7) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 8) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 1) $bubblesColor;
        }
        100% {
          box-shadow: 0 -$bubblesRadius 0 ($bubblesShallow * 1) $bubblesColor,
          $bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 2) $bubblesColor,
          $bubblesRadius 0 0 ($bubblesShallow * 3) $bubblesColor,
          $bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 4) $bubblesColor,
          0 $bubblesRadius 0 ($bubblesShallow * 5) $bubblesColor,
          -$bubblesRadius * 0.71 $bubblesRadius * 0.71 0 ($bubblesShallow * 6) $bubblesColor,
          -$bubblesRadius 0 0 ($bubblesShallow * 7) $bubblesColor,
          -$bubblesRadius * 0.71 -$bubblesRadius * 0.71 0 ($bubblesShallow * 8) $bubblesColor;
        }
      }
    }
    .loading-circles {
      $circlesSize: 5px;
      $circlesRadius: 12px;
      $circlesShallow: 8%;
      $circlesColor: #505050;
      position: relative;
      &:before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        margin-top: -$circlesSize/2;
        margin-left: -$circlesSize/2;
        width: $circlesSize;
        height: $circlesSize;
        border-radius: 50%;
        animation: linear loading-circles .75s infinite;
      }
      @keyframes loading-circles {
        0% {
          box-shadow: 0 -$circlesRadius 0 $circlesColor,
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 2),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 3),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 4),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 5),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 6),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 7);
        }
        12.5% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 7),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 $circlesColor,
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 1),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 2),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 3),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 4),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 5),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 6);
        }
        25% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 6),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 7),
          $circlesRadius 0 0 $circlesColor,
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 1),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 2),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 3),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 4),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 5);
        }
        37.5% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 5),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 6),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 7),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 $circlesColor,
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 1),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 2),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 3),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 4);
        }
        50% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 4),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 5),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 6),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 7),
          0 $circlesRadius 0 $circlesColor,
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 1),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 2),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 3);
        }
        62.5% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 3),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 4),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 5),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 6),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 7),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 $circlesColor,
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 1),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 2);
        }
        75% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 2),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 3),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 4),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 5),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 6),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 7),
          -$circlesRadius 0 0 $circlesColor,
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 1);
        }
        87.5% {
          box-shadow: 0 -$circlesRadius 0 lighten($circlesColor, $circlesShallow * 1),
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 2),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 3),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 4),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 5),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 6),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 7),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 $circlesColor;
        }
        100% {
          box-shadow: 0 -$circlesRadius 0 $circlesColor,
          $circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow),
          $circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 2),
          $circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 3),
          0 $circlesRadius 0 lighten($circlesColor, $circlesShallow * 4),
          -$circlesRadius * 0.71 $circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 5),
          -$circlesRadius 0 0 lighten($circlesColor, $circlesShallow * 6),
          -$circlesRadius * 0.71 -$circlesRadius * 0.71 0 lighten($circlesColor, $circlesShallow * 7);
        }
      }
    }
    .loading-wave-dots {
      $waveSize: 8px;
      $waveWave: -6px;
      $waveNear: -4px;
      $waveAfter: 2px;
      $waveColor: #999;
      $waveNearColor: #bbb;
      position: relative;
      &:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -$waveSize/2;
        margin-top: -$waveSize/2;
        width: $waveSize;
        height: $waveSize;
        background-color: $waveNearColor;
        border-radius: 50%;
        animation: linear loading-wave-dots 2.8s infinite;
      }
      @keyframes loading-wave-dots {
        0% {
          box-shadow: -$waveSize * 4 0 0 $waveNearColor,
          -$waveSize * 2 0 0 $waveNearColor,
          $waveSize * 2 0 0 $waveNearColor,
          $waveSize * 4 0 0 $waveNearColor;
        }
        5% {
          box-shadow: -$waveSize * 4 $waveNear 0 $waveNearColor,
          -$waveSize * 2 0 0 $waveNearColor,
          $waveSize * 2 0 0 $waveNearColor,
          $waveSize * 4 0 0 $waveNearColor;
          transform: translateY(0);
        }
        10% {
          box-shadow:
          -$waveSize * 4 $waveWave 0 $waveColor,
          -$waveSize * 2 $waveNear 0 $waveNearColor,
          $waveSize * 2  0         0 $waveNearColor,
          $waveSize * 4  0         0 $waveNearColor;
          transform: translateY(0);
        }
        15% {
          box-shadow:
          -$waveSize * 4  $waveAfter - $waveNear 0 $waveNearColor,
          -$waveSize * 2  $waveWave - $waveNear  0 $waveColor,
          $waveSize * 2   0 - $waveNear          0 $waveNearColor,
          $waveSize * 4   0 - $waveNear          0 $waveNearColor;
          transform: translateY($waveNear);
          background-color: $waveNearColor;
        }
        20% {
          box-shadow:
          -$waveSize * 4  0 - $waveWave                       0 $waveNearColor,
          -$waveSize * 2  $waveAfter - $waveWave              0 $waveNearColor,
          $waveSize * 2   $waveNear - $waveWave               0 $waveNearColor,
          $waveSize * 4   0 - $waveWave                       0 $waveNearColor;
          transform: translateY($waveWave);
          background-color: $waveColor;
        }
        25% {
          $waveOffset: $waveNear + $waveAfter;
          box-shadow:
          -$waveSize * 4  0 - $waveOffset         0 $waveNearColor,
          -$waveSize * 2  0 - $waveOffset         0 $waveNearColor,
          $waveSize * 2   $waveWave - $waveOffset 0 $waveColor,
          $waveSize * 4   $waveNear - $waveOffset 0 $waveNearColor;
          transform: translateY($waveOffset);
          background-color: $waveNearColor;
        }
        30% {
          box-shadow:
          -$waveSize * 4  0                       0 $waveNearColor,
          -$waveSize * 2  0                       0 $waveNearColor,
          $waveSize * 2   $waveNear + $waveAfter  0 $waveNearColor,
          $waveSize * 4   $waveWave               0 $waveColor;
          transform: translateY(0);
        }
        35% {
          box-shadow: -$waveSize * 4 0 0 $waveNearColor,
          -$waveSize * 2 0 0 $waveNearColor,
          $waveSize * 2 0 0 $waveNearColor,
          $waveSize * 4 $waveNear + $waveAfter 0 $waveNearColor;
        }
        40% {
          box-shadow:
          -$waveSize * 4 0 0 $waveNearColor,
          -$waveSize * 2 0 0 $waveNearColor,
          $waveSize * 2  0 0 $waveNearColor,
          $waveSize * 4  0 0 $waveNearColor;
        }
        100% {
          box-shadow:
          -$waveSize * 4 0 0 $waveNearColor,
          -$waveSize * 2 0 0 $waveNearColor,
          $waveSize * 2  0 0 $waveNearColor,
          $waveSize * 4  0 0 $waveNearColor;
        }
      }
    }

    @keyframes loading-rotating {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

  }

  &-status-prompt {
    color: #666;
    font-size: 14px;
    text-align: center;
    padding: 10px 0;
  }
}
</style>
