<template>
    <article v-for="i in 3" :key="i" class="content is-small box">
        <p class="subtitle">Lorem ipsum dolor</p>
        <p class="truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Enim ut sem viverra aliquet eget sit. Commodo odio aenean sed adipiscing diam donec adipiscing. Euismod in pellentesque massa placerat. Integer enim neque volutpat ac tincidunt. Ultricies lacus sed turpis tincidunt. Nulla aliquet porttitor lacus luctus accumsan tortor. Bibendum ut tristique et egestas quis ipsum. Tortor at auctor urna nunc id cursus metus aliquam eleifend. Morbi tristique senectus et netus et. Id neque aliquam vestibulum morbi. Arcu cursus euismod quis viverra nibh. Cursus vitae congue mauris rhoncus. Integer quis auctor elit sed vulputate mi. Euismod lacinia at quis risus. Id diam maecenas ultricies mi eget mauris pharetra et ultrices.</p>
    </article>
</template>

<style scoped>
.truncate {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
}
</style>
