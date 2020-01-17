<template>
    <div class="md:flex w-full">
        <card :title="'Verify identity of ' + user.name" class="flex-auto">
            <h1 class="text-lg mb-5 font-bold">User Information</h1>
            <table class="w-100 table table-auto">
                <tr>
                    <th class="p-2 text-right">
                        Status
                    </th>
                    <td class="p-2">
                        {{
                            user.kyc_verified_at
                                ? "Identity Verified"
                                : "Identity Not-Verified"
                        }}
                    </td>
                </tr>
                <tr>
                    <th class="p-2 text-right">
                        UID
                    </th>
                    <td class="p-2">{{ user.uid }}</td>
                </tr>
                <tr>
                    <th class="p-2 text-right">
                        Created at
                    </th>
                    <td class="p-2">{{ user.created_at }}</td>
                </tr>
                <tr>
                    <th class="p-2 text-right">
                        Name
                    </th>
                    <td class="p-2">{{ user.name }}</td>
                </tr>
                <tr>
                    <th class="p-2 text-right">
                        Username
                    </th>
                    <td class="p-2">
                        <a
                            target="_blank"
                            :href="
                                'https://www.yayimages.com/search?phrase=username%3' +
                                    user.username
                            "
                            >{{ user.username }}</a
                        >
                    </td>
                </tr>
                <tr>
                    <th class="p-2 text-right">
                        E-Mail
                    </th>
                    <td class="p-2">
                        <a target="_blank" :href="'mailto:' + user.email">{{
                            user.email
                        }}</a>
                    </td>
                </tr>
                <tr>
                    <th class="p-2 text-right">
                        Last KYC verification
                    </th>
                    <td class="p-2">
                        {{
                            user.kyc_verified_at
                                ? user.kyc_verified_at
                                : "Never"
                        }}
                    </td>
                </tr>
            </table>
        </card>
        <div class="flex-auto">
            <card title="Sales and Payment information" class="w-100">
                <h1 class="text-lg mb-5 font-bold"></h1>
                <table class="w-100 table table-auto">
                    <tr>
                        <th class="p-2 text-right">
                            Total Sales:
                        </th>
                        <td class="p-2">$ {{ user.sales }}</td>
                    </tr>
                    <tr>
                        <th class="p-2 text-right">
                            Paid Out:
                        </th>
                        <td class="p-2">$ {{ user.paidout }}</td>
                    </tr>
                    <tr class="text-red-500">
                        <th class="p-2 text-right">
                            Available:
                        </th>
                        <td class="p-2">$ {{ user.available }}</td>
                    </tr>
                </table>
            </card>
            <card title="Submitted Documents" class="w-100">
                <table class="w-100 table table-auto">
                    <thead>
                        <tr>
                            <th>Original Name</th>
                            <th>Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="kyc in user.kycs">
                            <th class="p-2 text-right">
                                {{ kyc.original_name }}
                            </th>
                            <td class="p-2">{{ kyc.created_at }}</td>
                            <td class="p-2">
                                <a
                                    :href="route('kyc.view', { file: kyc.id })"
                                    class="btn-blue block"
                                    target="_blank"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button
                    @click="submit()"
                    class="btn-blue block"
                    v-if="!user.kyc_verified_at"
                >
                    Approve
                </button>
            </card>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";

export default {
    layout: Layout,
    metaInfo: { title: "KYC confirm user" },
    components: {
        Card
    },
    data: function() {
        return {
            sending: false
        };
    },
    props: {
        user: Object
    },
    methods: {
        submit() {
            console.log("woop");
            this.sending = true;
            this.$inertia
                .post(route("kyc.confirm", { user: this.user.id }))
                .then(() => {
                    this.sending = false;
                });
        }
    }
};
</script>

<style></style>
