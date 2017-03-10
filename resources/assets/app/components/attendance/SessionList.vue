<template>
    <div class="list-group">
            <input-button class="list-group-item list-group-item-action session-item" v-for="(item, index) in items" @click.native="itemClicked(item)">
                <div @click.native="itemClicked(index)"> {{ item.name }} </div>
            </input-button>
        </div>
</template>

<script lang="babel">

    export default {
        name: 'List',
        props: {
            items: {
                type: Array,
                required: true
            }
        },
        methods: {
            itemClicked(event, item){
                this.$emit('listClicked', item);
            }
        }
    }
</script>

<style lang="scss" scoped>
  .session-item {
    color: black;
  }

</style>
