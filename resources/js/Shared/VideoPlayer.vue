<template>
    <video ref="videoPlayer" class="video-js"></video>
</template>

<script>
import videojs from "video.js";

export default {
    name: "VideoPlayer",
    props: {
        poster: {
            type: String,
            required: true
        },
        src: {
            type: String,
            required: true
        },
        autoplay: {
            type: Boolean,
            default: true
        },
        controls: {
            type: Boolean,
            default: true
        }
    },
    watch: {
        src: function(fresh, old) {
            if (fresh != old && this.player) {
                this.player.src({ type: "video/mp4", src: fresh });
                this.player.poster(this.poster);
            }
        }
    },
    data: function() {
        return {
            options: {
                poster: this.poster,
                autoplay: true,
                muted: true,
                controls: this.controls,
                loop: true,
                fluid: true,
                sources: [
                    {
                        src: this.src,
                        type: "video/mp4"
                    }
                ]
            },
            player: null,
            preload: "metadata"
        };
    },
    mounted: function() {
        this.player = videojs(
            this.$refs.videoPlayer,
            this.options,
            function onPlayerReady() {}
        );
    },
    beforeDestroy() {
        if (this.player) {
            this.player.dispose();
        }
    }
};
</script>

<style></style>
