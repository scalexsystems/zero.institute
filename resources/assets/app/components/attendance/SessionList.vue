<template>
    <div class="list-group">
            <input-button class="list-group-item list-group-item-action session-item" :class="{ active : isActive(index) }"
                  v-for="(item, index) in items" @click.native="itemClicked(item, index)" >
                <div> {{ item.name }} </div>
            </input-button>
        </div>
</template>

<script lang="babel">

    export default {
        name: 'List',
        data: () => ({
          activeIndex: null,
        }),

        props: {
            items: {
                type: Array,
                required: true
            }
        },
        methods: {
            itemClicked(item, index){
                this.activeIndex = index
                this.$emit('listClicked', item)
            },
            isActive(index) {
              return index === this.activeIndex
            }
        }
    }
</script>

<style lang="scss" scoped>
  .session-item {
    color: black;
    border: 0;
  }

  .session-item.active {
    background-color: black;
    color: white;
    border-color: black;
  }


</style>
