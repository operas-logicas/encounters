<template>
    <div>
        <header class="modal-card-head">
            <p class="modal-card-title">Add Sighting</p>
            <button @click="$emit('closeModal')" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <!-- Content ... -->
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success">Save changes</button>
            <button @click="$emit('closeModal')" class="button">Cancel</button>
        </footer>
    </div>
</template>
