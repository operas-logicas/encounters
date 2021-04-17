<template>
    <div>
        <header class="modal-card-head">
            <p class="modal-card-title">Sighting Detail</p>
            <button @click="$emit('closeModal')" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <!-- Content ... -->
        </section>
        <footer class="modal-card-foot">
            <button @click="$emit('closeModal')" class="button">Close</button>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        id: String
    }
}
</script>
