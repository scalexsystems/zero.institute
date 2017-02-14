<template>
    <div class="c-teacher-card card">
        <div class="c-teacher-card-block">
            <div class="d-flex flex-row align-items-center">
                <img :src="teacher.photo" class="rounded-circle c-teacher-card-photo">
                <div>
                    <div class="c-teacher-card-title">{{ teacher.name }}</div>
                    <div class="c-teacher-card-subtitle">
          <span class="text-primary text-uppercase" v-if="teacher.is_member">Joined <span
                  class="text-muted">&centerdot;</span></span>
                        <span class="text-muted">{{ teacher.member_count_text }}</span>
                    </div>
                </div>
            </div>

            <slot></slot>
        </div>
    </div>
</template>

<script lang="babel">
    export default {
        props: {
            teacher: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style lang="scss">
    @import '../../styles/methods';

    .c-teacher-card {
        &-photo {
            width: to-rem(48px);
            height: to-rem(48px);
            margin-right: to-rem(10px);
        }

        &-title {
            font-size: 1.14285rem;
        }

        &-subtitle {
            font-size: .75rem;
        }

        &-block {
            padding: .64286rem .71429rem;
        }
    }
</style>
