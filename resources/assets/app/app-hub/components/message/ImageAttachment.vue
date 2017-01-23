<template>
  <div>
    <div class="card card-inverse image-attachment" role="button" @click="show = true">
      <div class="embed-responsive embed-responsive-16by9 card-img">
        <img class="embed-responsive-item" :src="preview">
      </div>

      <div class="card-img-overlay fl fl-in" v-if="images.length > 1">
        <div class="text-xs-center">
          <div class="label">{{ labelText }}</div>
          <div class="text-muted">Click to Preview</div>
        </div>
      </div>
    </div>

    <modal class="inverse" :show="show" @hide="show = false">
      <div class="carousel slide" ref="carousel" @click="show = false">
        <ol class="carousel-indicators">
          <li v-for="(image, key) of images" :data-slide-to="key" @click="go(key)"></li>
        </ol>
        <div class="carousel-inner" :class="{ full: !full }" role="listbox">
          <div class="carousel-item" v-for="image of images">
            <img :src="image.path" @click.stop="full = !full">
          </div>
        </div>

        <a class="control left" role="button" @click.stop="go('prev')">
          <i class="fa fa-fw fa-arrow-circle-left"></i>
          <span class="sr-only">Previous</span>
        </a>

        <a class="control right" role="button" @click.stop="go('next')">
          <i class="fa fa-fw fa-arrow-circle-right"></i>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </modal>
  </div>
</template>
<script lang="babel">
import $ from 'jquery';
import Modal from '../../../components/Modal.vue';

export default{
  data() {
    return { show: false, full: false };
  },
  props: {
    images: {
      type: Array,
      required: true,
    },
  },
  computed: {
    labelText() {
      const images = this.images;

      return `${images.length} Images`;
    },
    preview() {
      const images = this.images;

      return images[0].links.preview || images[0].links.original;
    },
  },
  components: { Modal },
  methods: {
    go(where) {
      this.full = false;
      $(this.$refs.carousel).carousel(where);
    },
  },
  watch: {
    show(state) {
      if (state) {
        this.$nextTick(() => {
          this.$refs.carousel.querySelector('.carousel-indicators li').classList.add('active');
          this.$refs.carousel.querySelector('.carousel-item').classList.add('active');
          this.$refs.carousel.focus();
          $(this.$refs.carousel).carousel({ interval: false });
        });
      }
    },
  },
};
</script>
<style lang="scss" scoped>
@import '../../../styles/variables';
@import '../../../styles/mixins';

.image-attachment {
  width: 100%;
  margin: .5rem .5rem .5rem 0;

  @include media-breakpoint-up(md) {
    width: 450px;
    height: 253px;
  }

  img {
    object-fit: cover;
  }

  .label {
    font-size: 1.714rem;
    color: white;
  }

  .card-img-overlay {
    z-index: 2;
    &:before {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      content: '';
      z-index: -1;
      background: rgba(0, 0, 0, .6);
    }
  }
}

.control {
  position: fixed;
  top: 50%;
  transform: translateY(-50%);
  padding: .5rem;

  font-size: 1.8rem;
  color: #e7e7e7;

  transition: all 0.3s;

  &:hover {
    transform: scale(1.2) translateY(-50%);
  }

  &.left {
    left: 0;
  }

  &.right {
    right: 0;
  }
}

.carousel {
  width: 100%;
  padding: 1rem 2rem;
}

.carousel-inner {
  text-align: center;
  img {
    cursor: zoom-out;
  }

  &.full {
    img {
      max-width: 100%;
      max-height: calc(100vh - 4rem);
      cursor: zoom-in;
    }
  }
}

.carousel-indicators {
  position: absolute;
  left: 50%;
  z-index: 15;
  text-align: center;
  list-style: none;
  position: fixed;

  margin-left: 0;
  left: 50%;
  margin-bottom: 2rem;
  width: 100vw;
  transform: translateX(-50%);
}

.card-img {
  position: static;
}
</style>
