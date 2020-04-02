<template>
    <table class="flex table table-auto w-full text-xs" v-if="video">
        <tr v-if="displayTitle">
            <td>Filename</td>
            <td>
                <strong>{{ video.original_name }}</strong>
            </td>
        </tr>
        <tr>
            <td>Duration</td>
            <td>{{ video.duration }}</td>
        </tr>
        <tr>
            <td>Framerate</td>
            <td>
                {{ Math.round(video.framerate) }}
            </td>
        </tr>
        <tr>
            <td>Dimensions</td>
            <td>{{ video.width }}x{{ video.height }}</td>
        </tr>
        <tr>
            <td>Codec</td>
            <td>
                {{ video.codec }}
            </td>
        </tr>
        <tr>
            <td>Uploaded</td>
            <td>
                {{ video.uploaded_at }}
            </td>
        </tr>
        <tr>
            <td>4K</td>
            <td>
                {{ video["4k"] == 1 ? "Yes" : "No" }}
            </td>
        </tr>
        <tr>
            <td>Size</td>
            <td>{{ video["size"] }} MB</td>
        </tr>
    </table>
</template>

<script>
export default {
    props: {
        video: {
            type: Object,
            default: function() {
                return {};
            }
        },
        displayTitle: {
            type: Boolean,
            default: false
        }
    }
};
</script>

<style></style>
