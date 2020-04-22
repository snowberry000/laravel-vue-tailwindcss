<template>
    <div
        class="fixed right-0 bottom-0 w-full md:w-2/4 md:m-16 shadow-2xl"
        v-if="video"
        @keydown.esc="close"
    >
        <button
            @click="close"
            aria-label="close"
            class="rounded-full w-12 h-12 -ml-6 -mt-6 bg-blue-500 text-white absolute left-0 top-0 z-20"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-12 h-12 fill-current"
                viewBox="0 0 24 24"
            >
                <path d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M14.59 8L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8zM12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"
                />
            </svg>
        </button>
        <video-player
            v-if="video.preview"
            :poster="video.thumbnail"
            :src="src"
        />
    </div>
</template>

<script>
import VideoPlayer from "@/Shared/VideoPlayer";
export default {
    components: {
        VideoPlayer
    },
    props: ["video"],
    // watch: {
    //     video: function(n, o) {
    //         if (!n) return;
    //         this.getVideo();
    //     }
    // },
    data: function() {
        return {
            src: null
        };
    },
    methods: {
        getVideo: function() {
            this.$http
                .get("/api/video/full/" + this.video.file_uuid)
                .then(res => {
                    this.src = res.data.src;
                });
        },
        close: function() {
            this.src = null;
            this.$emit("preview-close");
        },
        closeOnEscape: e => {
            if (e.code == "Escape" || e.keyCode == 27) {
                this.close();
            }
        }
    },
    created: function() {
        var self = this;
        window.addEventListener("keyup", this.closeOnEscape);
    },
    beforeDestroy: function() {
        window.removeEventListener("keyup", this.closeOnEscape);
    }
};
</script>
