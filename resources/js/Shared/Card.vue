<template>
    <div class="rounded border shadow-lg m-5 p-5 bg-white">
        <h2 class="text-lg mb-5 font-bold text-lg text-gray-700" v-if="title">
            {{ title }}
        </h2>
        <slot />
    </div>
</template>
<script>
export default {
    props: {
        title: {
            type: String
        }
    }
};
</script>
