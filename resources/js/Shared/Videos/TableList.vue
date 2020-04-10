<template>
    <div class="flex">
        <div>
            <ul class="flex flex-wrap text-xs mb-5 mt-2 items-center uppercase">
                <li class="mr-1 text-gray-600">
                    Filter By Status:
                </li>
                <li class="m-1">
                    <inertia-link
                        :href="route('video.show')"
                        class="btn btn-primary-outline"
                        :class="{ active: currentStatus == null }"
                        >All</inertia-link
                    >
                </li>
                <li
                    v-for="(item, key, index) in status"
                    :key="key"
                    class="mx-1"
                >
                    <inertia-link
                        :href="route('video.show', { status: key })"
                        class="btn btn-primary-outline"
                        :class="{ active: currentStatus == key }"
                        >{{ item }}</inertia-link
                    >
                </li>
            </ul>
            <table class="table table-fixed flex w-full">
                <thead>
                    <th class="w-1/12">Media</th>
                    <th>Title</th>
                    <th>Releases</th>
                    <th>Metadata</th>
                    <th>Status</th>
                    <th></th>
                </thead>
                <tbody>
                    <tr
                        v-for="video in videos.data"
                        :key="video.id"
                        class="border-b"
                    >
                        <td class="p-2"><img :src="video.thumbnail" /></td>
                        <td class="p-2">
                            {{
                                video.title ? video.title : video.original_name
                            }}
                            <small
                                class="text-xs block"
                                v-if="video.description"
                                >{{ video.description }}</small
                            >
                        </td>
                        <td class="p-2">
                            <ul v-if="video.releases" class="list-none">
                                <li
                                    v-for="release in video.releases"
                                    :key="release.id"
                                >
                                    {{ release.name }}
                                </li>
                            </ul>
                        </td>
                        <td class="p-2"><video-metainfo :video="video" /></td>
                        <td class="p-2">
                            <span
                                class="rounded text-xs text-gray-700 border-gray-700 border py-1 px-2"
                                >{{ status[video.status] }}</span
                            >
                        </td>
                        <td class="p-2">
                            <button
                                class="btn btn-primary"
                                @click="setCurrent(video)"
                            >
                                View / Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <edit-form v-if="current" :selected="current" @close="current = null" />
    </div>
</template>

<script>
import VideoMetainfo from "@/Shared/Videos/MetaInfo";
import EditForm from "@/Shared/Videos/Edit";
export default {
    components: {
        VideoMetainfo,
        EditForm
    },
    data: function() {
        return {
            current: null
        };
    },
    props: {
        videos: {
            type: Object
        },
        status: {
            type: Object
        },
        currentStatus: {
            default: null
        }
    },
    methods: {
        setCurrent: function(video) {
            this.current = video;
        }
    }
};
</script>
