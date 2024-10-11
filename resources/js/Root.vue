<script setup>
import AppHeader from "./components/AppHeader.vue";
</script>

<template>
    <AppHeader />
    <div class="bg-white px-2 sm:px-4 py-2.5 dark:bg-gray-900">
        <div
            class="container flex flex-wrap justify-between items-center mx-auto"
        >
            <RouterView />
        </div>
    </div>
</template>
