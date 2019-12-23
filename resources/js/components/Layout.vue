<template>
    <div>
        <yay-header />
        <slot />
    </div>
</template>

<script>
import YayHeader from "@/Shared/Header";
export default {
    components: {
        YayHeader
    }
};
</script>

<style></style>
