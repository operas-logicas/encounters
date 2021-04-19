<template>
    <article class="content is-small box">
        <div>
            <p class="subtitle is-flex is-justify-content-space-between mb-0">
                <span class="truncate horiz">{{ sighting.title }}</span>
                <span @click="">
                    <span v-if="hasLikes" class="is-clickable">💚</span>
                    <span v-else class="is-clickable">🤍</span> {{ sighting.likes }}
                </span>
            </p>
        </div>
        <p><span class="is-size-6 mb-1">👽</span> {{ sighting.user_handle }} &bull; {{ sighting.date }}</p>
        <p class="truncate">{{ sighting.description }}</p>
    </article>
</template>

<script>
import { computed } from 'vue'

export default {
    props: {
        sighting: Object
    },

    setup(props) {
        const hasLikes = computed(() => props.sighting.likes > 0)

        return {
            hasLikes
        }
    }
}
</script>

<style scoped>
.truncate {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
}
.horiz {
    width: 80%;
    -webkit-line-clamp: 1 !important;
}
</style>
