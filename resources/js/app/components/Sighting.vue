<template>
    <article class="content is-small box">
        <div>
            <p class="subtitle is-flex is-justify-content-space-between mb-0">
                <span class="truncate horiz">Lorem ipsum dolor sit amet consectetur adipiscing elit</span>
                <span @click="likes++">
                    <span v-if="hasLikes" class="is-clickable">💚</span>
                    <span v-else class="is-clickable">🤍</span> {{ likes }}
                </span>
            </p>
        </div>
        <p><span class="is-size-6 mb-1">👽</span> b788b4 &bull; July 4, 2021</p>
        <p class="truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Enim ut sem viverra aliquet eget sit. Commodo odio aenean sed adipiscing diam donec adipiscing. Euismod in pellentesque massa placerat. Integer enim neque volutpat ac tincidunt. Ultricies lacus sed turpis tincidunt. Nulla aliquet porttitor lacus luctus accumsan tortor. Bibendum ut tristique et egestas quis ipsum. Tortor at auctor urna nunc id cursus metus aliquam eleifend. Morbi tristique senectus et netus et. Id neque aliquam vestibulum morbi. Arcu cursus euismod quis viverra nibh. Cursus vitae congue mauris rhoncus. Integer quis auctor elit sed vulputate mi. Euismod lacinia at quis risus. Id diam maecenas ultricies mi eget mauris pharetra et ultrices.</p>
    </article>
</template>

<script>
import { computed, ref } from 'vue'

export default {
    setup() {
        const likes = ref(0)

        const hasLikes = computed(() => likes.value > 0)

        return {
            likes,
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
