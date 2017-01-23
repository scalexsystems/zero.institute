<template>
<div class="search-option" v-html="name"></div>
</template>

<script lang="babel">
import isString from 'lodash/isString';
import each from 'lodash/each';

import { escapeHtml as e } from '../util';

export default {
  props: {
    option: {
      required: true,
    },
    query: {
      required: true,
    },
  },
  computed: {
    name() {
      const option = this.option;
      const query = this.query;

      return this.highlight(option.name, query);
    },
  },
  methods: {
    highlight(content, query) {
      if (isString(content)) {
        const selected = query.trim().replace(/[\s]+/g, ' ').split(' ');
        let text = e(content);
        each(selected, (s) => {
          text = text.replace(new RegExp(`(${s.replace(/[\\^$*+?.()|[\]{}]/g, '\\$&')})`, 'gi'), '<b>$1</b>');
        });
        return text;
      }

      return '';
    },
  },
};
</script>


<style lang="scss">
.search-option {
  padding: .4rem 1rem;
}
</style>
