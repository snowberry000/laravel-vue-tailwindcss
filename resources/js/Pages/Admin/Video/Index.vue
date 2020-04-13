<template>
    <div class="flex">
        <card title="Videos" class="w-full">
            <table class="table table-auto flex w-full">
                <thead>
                    <tr class="border-b text-xs">
                        <th>select</th>
                        <th>Thumb/Preview</th>
                        <th>Title/Description</th>
                        <th>Keywords</th>
                        <th>Media Releases</th>
                        <th>Meta Information</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="video in videos.data"
                        :key="video.id"
                        class="border-b"
                    >
                        <td></td>
                        <td class="w-56 p-1">
                            <button @click="previewVideo(video)">
                                <img :src="video.thumbnail" />
                            </button>
                        </td>
                        <td>
                            <ul class="list-none text-sm p-2">
                                <li class="mb">
                                    <strong>title:</strong> {{ video.title }}
                                </li>
                                <li class="mb">
                                    <strong>description:</strong
                                    >{{ video.description }}
                                </li>
                                <li class="mb">
                                    <strong>by:</strong
                                    >{{ video.user.username }}
                                </li>
                            </ul>
                        </td>
                        <td class="text-xs">
                            <ul
                                class="list-none flex flex-wrap p-1"
                                v-if="video.keywords.length > 0"
                            >
                                <li
                                    class="p-1 m-1 block border rounded text-blue-500 border-blue-500"
                                    v-for="keyword in video.keywords"
                                    :key="keyword"
                                >
                                    {{ keyword }}
                                </li>
                            </ul>
                            <strong class="p-1" v-else>No Keywords.</strong>
                        </td>
                        <td>
                            <ul v-if="video.releases.length">
                                <li v-for="release in video.releases">
                                    <a
                                        class="text-blue-500 flex text-sm items-center"
                                        :href="
                                            route('release.download', {
                                                id: release.file_uuid
                                            })
                                        "
                                        ><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            class="fill-current w-4 inline-block mr-1"
                                        >
                                            <path
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            />
                                            <path
                                                d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z"
                                            />
                                        </svg>
                                        <span> {{ release.filename }}</span></a
                                    >
                                </li>
                            </ul>
                        </td>
                        <td class="md:w-1/4 p-1">
                            <video-metainfo
                                :video="video"
                                display-title
                            ></video-metainfo>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </card>
        <preview :video="preview" @preview-close="preview = null" />
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import VideoMetainfo from "@/Shared/Videos/MetaInfo";
import Preview from "./Partial/Preview";
export default {
    layout: Layout,
    metaInfo: { title: "Approve some videos" },
    components: {
        Card,
        VideoMetainfo,
        Preview
    },
    props: {
        videos: {
            type: Object
        }
    },
    data: function() {
        return {
            preview: null
        };
    },
    methods: {
        previewVideo: function(video) {
            this.preview = video;
        }
    }
};
</script>
