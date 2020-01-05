<template>
    <div class="relative">
        <yay-header :routes="routes" />
        <span
            v-if="$page.flash.success"
            class="flex rounded shadow-xlw-100 p-5 m-5 bg-blue-500  text-white font-bold"
            >{{ $page.flash.success }}</span
        >
        <slot />
    </div>
</template>

<script>
import YayHeader from "@/Shared/Header";
export default {
    components: {
        YayHeader
    },
    data: function() {},
    props: {
        payouts: Array
    }
};
</script>
