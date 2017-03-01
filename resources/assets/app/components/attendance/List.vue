<template>
    <div>
        <div class="list-group">
            <a role="button" class="list-group-item list-group-item-action" v-for="item in items" @click.native="itemClicked(item)">
                {{ item.name }}
            </a>
            </div>
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
