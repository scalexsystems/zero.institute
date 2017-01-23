<template>
  <div class="global-search fl">
    <div class="search-box fl-auto form-control g-search">
      <div class="search-shadow">
        <span class="placeholder" v-if="isQueryEmpty">
          <i class="fa fa-fw fa-search"></i> Search for anything...
        </span>
        <span class="suggest" v-if="hasSuggestionText">
          {{ suggestionText }}
        </span>
      </div>
      <input type="search" v-model="query" class="search-field">
    </div>
  </div>
</template>

<script lang="babel">
export default {
  computed: {
    suggestions: () => [
      'Rahul Kadyan',
      'Suwardhan Ahirrao',
    ],
    isQueryEmpty() {
      const query = this.query;

      return query.trim().length === 0;
    },
    suggestionText() {
      const query = this.query;
      const isQueryEmpty = this.isQueryEmpty;
      const suggestions = this.suggestions;

      if (isQueryEmpty) return '';

      const filtered = suggestions.filter(item => item.startsWith(query));

      if (filtered.length) return filtered[0];

      return '';
    },
    hasSuggestionText() {
      const suggestionText = this.suggestionText;

      return suggestionText.trim().length > 0;
    },
  },
  data() {
    return {
      query: '',
    };
  },
};
</script>

<style lang="scss" scoped>
@import "../styles/variables";

.global-search {
  align-items: center;
}

.g-search {
  max-width: 400px;
  margin: 0;
  padding: 0;
  background: darken($brand-accent, 10%);
  border-color: lighten($brand-accent, 0.5%);
}

.search-box {
  position: relative;
  z-index: $zindex-dropdown;
}

.search-field {
  padding: $input-padding-y $input-padding-x;
  background: transparent;
  border: none;
  color: white;
  &, &:focus, &:hover {
    outline: none;
  }

  width: 100%;
}

.search-shadow {
  cursor: text;
  position: absolute;
  left: 0;
  right: 0;
  top: 0;

  z-index: -1;

  padding: $input-padding-y $input-padding-x;

  .placeholder, .suggestion {
    color: darken(white, 50%);
  }
}
</style>
