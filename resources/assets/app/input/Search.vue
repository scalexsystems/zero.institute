<template>
<div class="form-group" :class="[feedbackState]">
  <label class="form-control-label" :for="id" v-if="title">{{ title }}</label>

  <div :tabindex="isOpen ? -1 : 0"
       :class="{ open: isOpen }"
       @focus.stop="open"
       class="search-container"
       ref="body">

    <div class="search-query" @click.stop="open">
      <input :id="id"
             :name="identifier"
             :placeholder="searchHelpText"
             autocomplete="off"
             type="search"
             ref="input"
             :value="value"
             @input="onInput"
             @focus.stop="open"
             @keydown.esc.stop.prevent="onEsc"
             @keydown.enter.stop.prevent="onEnter"
             @keydown.up.prevent="onUp"
             @keydown.down.prevent="onDown"
             @blur="onBlur">
      <i class="fa fa-fw fa-circle-o-notch fa-spin" v-show="suggesting"></i>
    </div>

    <ul class="search-suggestions" v-show="isOpen" ref="options">
      <li v-if="noResults" class="search-suggestion not-found">
        <slot name="not-found">
          <span>No results for: {{ value }}</span>
        </slot>
      </li>
      <li v-for="(option, $index) of options"
          class="search-suggestion"
          :class="{ active: $index === index }"
          @click.stop="onClick(option)"
          @mouseover="index = null">
        <div :is="component" :option="option" :query="value"></div>
      </li>
    </ul>
  </div>

  <div class="form-control-feedback" v-if="is(feedback)">{{ f(feedback) }}</div>
  <small :id="`${id}-help`" class="form-text text-muted" v-if="is(subtitle)">{{ subtitle }}</small>
</div>
</template>

<script lang="babel">
import Sifter from 'sifter'
import debounce from 'lodash/debounce'

import input from './mixins/input'
import SearchOption from './SearchOption.vue'

export default {
  props: {
    suggestions: {
      required: true,
      type: Array
    },
    sortFields: {
      type: Array,
      default: () => []
    },
    searchFields: {
      type: Array,
      default: () => ['name']
    },
    limit: {
      type: Number,
      default: 15
    },
    component: {
      type: String,
      default: 'search-option'
    }
  },
  data () {
    return {
      index: null,
      isOpen: false,
      skipClose: false,
      selected: [],
      pendingSearches: 0
    }
  },
  components: { SearchOption },
  computed: {
    searchable () {
      const suggestions = this.suggestions

      return new Sifter(suggestions || [])
    },
    options () {
      const value = this.value
      const searchable = this.searchable
      const fields = this.searchFields
      const sort = this.sortFields
      const limit = this.limit
      const selected = this.selected

      const results = searchable.search(value, {
        fields,
        sort,
        limit,
        sort_empty: [{ field: 'name', direction: 'asc' }]
      })

      return results.items
              .map(({ id }) => this.suggestions[id])
              .filter(option => selected.indexOf(option) < 0)
    },
    noResults () {
      const options = this.options
      const value = this.value

      return value.trim().length > 0 && options.length === 0
    },
    searchHelpText () {
      const search = this.search
      const help = this.searchHelp
      const placeholder = this.placeholderText

      if (search) {
        return placeholder
      }

      return help || 'Start typing...'
    },
    suggesting () {
      return this.pendingSearches > 0
    }
  },
  methods: {
    onEnter () {
      if (this.index in this.options) {
        this.select(this.options[this.index])
        return
      }

      this.$emit('search', this.input)
    },
    onClick (option) {
      this.select(option)
    },
    onEsc () {
      if (this.$refs.input) {
        this.$refs.input.blur()
      }
      this.close()
    },
    onUp () {
      if (this.index === null) {
        this.index = this.options.length - 1
      } else if (this.index > 0) {
        this.index = this.index - 1
      }

      this.scrollIntoView()
    },
    onDown () {
      if (this.index === null) {
        this.index = 0
      } else if (this.index < (this.options.length - 1)) {
        this.index = this.index + 1
      }
      this.scrollIntoView()
    },
    onInput (event) {
      this.$emit('input', event.target.value)
      this.$emit('suggest', {
        value: event.target.value,
        start: () => {
          this.pendingSearches += 1
        },
        end: () => {
          if (this.pendingSearches > 0) {
            this.pendingSearches -= 1
          }
        }
      })
    },
    onBlur: debounce(function onBlur () {
      this.close()
    }, 300),
    scrollIntoView () {
      try {
        this.$refs.options
                .children[this.index]
                .scrollIntoViewIfNeeded()
      } catch (e) {
        this.$debug(e)
      }
    },
    clickAway (e) {
      if (!this.$refs.body.contains(e.target)) {
        this.close()
      }
    },
    close () {
      if (this.skipClose) {
        this.skipClose = false
        return
      }

      this.index = null
      this.isOpen = false
    },
    open () {
      if (this.isOpen) return

      this.isOpen = true

      this.$nextTick(() => {
        if (this.$refs.input) {
          this.$refs.input.focus()
        }
      })
    },
    select (option) {
      if (!option) return

      if (this.selected.indexOf(option) < 0) {
        this.selected.push(option)
        this.$emit('select', option)
      }
    },
    unselect (option) {
      const index = this.selected.indexOf(option)
      if (index > -1) this.selected.splice(index, 1)
    }
  },
  mixins: [input],
  created () {
    this.$on('unselect', item => this.unselect(item))
  },
  destroyed () {
    document.body.removeEventListener('click', this.clickAway, false)
  }
}
</script>

<style lang="scss" scoped>
@import "../styles/variables";
@import "../styles/mixins";

.search-container {
  display: block;
  width: 100%;
  position: relative;
  outline: none;

  @import 'node_modules/bootstrap/scss/forms';
  @import 'node_modules/bootstrap/scss/dropdown';

  .search-query {
    @extend .form-control;

    cursor: pointer;
    position: relative;
    padding: $input-padding-y $input-padding-x + 1.5rem $input-padding-y $input-padding-x;
    // &::before {
    //   display: inline-block;
    //   width: 0;
    //   height: 0;
    //   margin-right: .25rem;
    //   margin-left: .25rem;
    //   vertical-align: middle;
    //   content: "";
    //   border-top: $caret-width solid;
    //   border-right: $caret-width solid transparent;
    //   border-left: $caret-width solid transparent;
    //   position: absolute;
    //   right: .25rem;
    //   top: 50%;
    // }

    list-style: none;
    margin-bottom: 0;
    &:empty {
      display: none;
    }

    input {
      display: block;
      border: none;
      outline: none;
      width: 100%;
    }

    i.fa {
      position: fixed;
      right: 1.25rem;
      top: $input-padding-y;
    }
  }

  .search-suggestions {
    @extend .dropdown-menu;

    display: block;
    right: 0;
    padding: 0;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 15rem;
    min-width: 0;
    margin: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-color: $input-border-color;
    border-top-width: 0;
  }

  .search-suggestion {
    @extend .dropdown-item;

    cursor: pointer;
    padding: 0;
    margin: 0;
  }
}
</style>
