<template>
    <div class="flex">
        <card class="w-full" title="Contributors">
            <div class="flex justify-between">
                <div class="search mb-5">
                    <text-input
                        v-model="searchby"
                        class="mt-5"
                        type="text"
                        autofocus
                        placeholder="Search Contributors"
                        autocapitalize="off"
                        @input="querysearch"
                    />
                </div>
            </div>
            <table class="table table-auto w-full flex">
                <thead>
                    <tr class="text-sm border-b pb-1">
                        <th>UID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Approvals</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="contributor in contributors.data"
                        :key="contributor.id"
                        class="border-b"
                    >
                        <td class="py-1">{{ contributor.uid }}</td>
                        <td class="py-1">{{ contributor.username }}</td>
                        <td class="py-1">{{ contributor.name }}</td>
                        <td class="py-1">
                            <a
                                :href="'mailto:' + contributor.email"
                                class="text-blue-500"
                                >{{ contributor.email }}</a
                            >
                        </td>
                        <td>
                            <span
                                v-if="contributor.video"
                                class="rounded border text-green-500 border-green-500 text-xs p-1 mx-1"
                            >
                                VIDEO
                            </span>
                            <span
                                v-if="contributor.kyc_verified_at"
                                class="rounded border  text-green-500 border-green-500 text-xs p-1 mx-1"
                            >
                                KYC
                            </span>
                        </td>
                        <td>{{ contributor.created_at }}</td>
                        <td class="py-1 text-center">
                            <inertia-link
                                class="btn btn-primary text-sm"
                                :href="
                                    route('admin.contributors.show', {
                                        contributor: contributor.id
                                    })
                                "
                            >
                                View
                            </inertia-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :links="contributors.links" />
        </card>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import TextInput from "@/Shared/TextInput";
import Pagination from "@/Shared/Pagination";
import throttle from "lodash/throttle";

export default {
    layout: Layout,
    metaInfo: {
        title: "Contributors"
    },
    props: {
        contributors: {
            type: Object
        },
        search: {
            default: null
        }
    },
    components: {
        Card,
        Pagination,
        TextInput
    },
    data: function() {
        return {
            searchby: null
        };
    },
    created: function() {
        this.searchby = this.search;
    },
    methods: {
        querysearch: throttle(function() {
            this.$inertia.replace(
                this.route("admin.contributors", { s: this.searchby })
            );
        }, 250)
    }
};
</script>
