<template>
  <div :class="[$style.photoBrowser]" @keydown.right.stop="next" @keydown.left.stop="prev" tabindex="1">
    <div :class="[$style.photos]">
      <a role="button" :class="[$style.action, $style.prev]" @click.prevent="prev">
        <icon class="text-white" type="chevron-left"></icon>
      </a>
      <a role="button" :class="[$style.action, $style.next]" @click.prevent="next">
        <icon class="text-white" type="chevron-right"></icon>
      </a>

      <div class="d-flex flex-column align-items-center" v-for="(photo, index) in photos" :key="photo"
        :class="{
          [$style.photoContainer]: true,
          [$style.full]: full,
          [$style.before]: index < cursor,
          [$style.after]: index > cursor,
          [$style.active]: index === cursor
        }"><img :class="[$style.photo]" :src="photo.src" :alt="photo.alt"></div>


      <div :class="[$style.ticker]">
        <div v-for="(photo, index) in photos" :key="photo" :class="{ [$style.tick]: true, [$style.active]: index === cursor }" @click="cursor = index"></div>
      </div>
    </div>
  </div>
</template>

<script lang="babel">
export default {
  name: 'PhotoBrowser',

  props: {
    photos: {
      type: Array,
      required: true
    }
  },

  data () {
    return { cursor: 0, full: false }
  },

  computed: {
    photo () {
      const photos = this.photos
      const cursor = this.cursor

      return photos[cursor]
    },

    count () {
      return this.photos.length
    }
  },

  methods: {
    next () {
      if (this.cursor + 1 === this.count) {
        this.$emit('end')

        return
      }

      this.cursor += 1
    },

    prev () {
      if (this.cursor === 0) {
        this.$emit('start')

        return
      }

      this.cursor -= 1
    }
  },

  mounted () {
    this.$el.focus()
  },


  watch: {
    photos () {
      this.cursor = 0
      this.full = false

      this.$el.focus()
    }
  }
}
</script>

<style lang="scss" module>
.photo-browser {
  .photos {
    overflow: hidden;
    position: relative;

    padding-bottom: 56.25%;
  }

  &:global(.fullscreen) {
    .photos {
      height: 100vh;
      padding-bottom: 0;
    }
  }

  .photo-container {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 100%;

    transition: transform 300ms;
    &.before {
      transform: translateX(-100%);
    }
    &.after {
      transform: translateX(100%);
    }

    &:before, &:after {
      flex: 1 1 0.0001%;
      height: 1px;
      content: '';
      display: block;
    }

    img {
      max-width: 100%;
      max-height: 100%;
      width: auto;
      height: auto;
    }
  }

  .ticker {
    position: absolute;
    bottom: 20px;
    width: 100%;
    text-align: center;

    .tick {
      display: inline-block;

      cursor: pointer;

      width: 6px;
      height: 6px;
      margin: 6px;

      border-radius: 3px;
      background: white;
      box-shadow: 0 1px 3px 0 #000;

      transition: all 300ms;

      z-index: 2;

      &.active {
        width: 28px;
      }
    }
  }

  .action {
    background: none;

    border: none;
    position: absolute;
    top: 0;
    bottom: 0;

    cursor: pointer;

    opacity: 0.3;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 2rem;
    font-size: 2rem;
    transition: all 300ms;

    z-index: 2;
  }

  .prev {
    left: 0;

    &:hover {
      background: linear-gradient(90deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0));
      opacity: 1;
    }
  }

  .next {
    right: 0;
    left: auto;

    &:hover {
      background: linear-gradient(-90deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0));
      opacity: 1;
    }
  }
}
</style>
