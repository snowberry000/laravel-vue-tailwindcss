<template>
    <nav
        class="flex items-center justify-between flex-wrap bg-gray-100 px-6 py-2 border-b border-blue-100 shadow-lg mb-4"
    >
        <div class="flex items-center flex-no-shrink text-white mr-6">
            <logo class="h-8" />
        </div>
        <div class="block lg:hidden">
            <button
                @click="open = !open"
                class="flex items-center px-3 py-2 border rounded text-teal-lighter border-teal-light hover:text-white hover:border-white"
            >
                <svg
                    class="h-3 w-3"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
        <div
            @focusout="handleFocusOut"
            tabindex="0"
            class="block w-full flex-grow lg:flex lg:items-center lg:w-auto"
            :class="open ? 'block' : 'hidden'"
        >
            <div class="text-sm lg:flex-grow">
                <inertia-link
                    href="/"
                    class="block mt-4 lg:inline-block lg:mt-0 mr-4"
                >
                    Dashboard
                </inertia-link>
                <inertia-link
                    href="/downloads"
                    class="block mt-4 lg:inline-block lg:mt-0 mr-4"
                >
                    Downloads
                </inertia-link>
            </div>
            <div>
                <inertia-link
                    :href="route('logout')"
                    method="post"
                    class="inline-block text-sm px-4 py-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0"
                    >Logout</inertia-link
                >
            </div>
        </div>
    </nav>
</template>

<script>
import Logo from "@/Shared/Logo";
export default {
    components: {
        Logo
    },
    data: function() {
        return {
            open: false
        };
    },
    methods: {
        handleFocusOut: function() {
            this.open = false;
        }
    }
};
</script>
