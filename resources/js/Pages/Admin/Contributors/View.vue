<template>
    <div class="flex">
        <card :title="cardtitle" class="w-full">
            <div class="flex justify-between mb-2">
                <inertia-link
                    :href="route('admin.contributors')"
                    class="btn btn-primary text-sm"
                    >Back</inertia-link
                >
                <span>
                    <inertia-link
                        :href="
                            route('admin.contributors.video.enable', {
                                contributor: contributor.id
                            })
                        "
                        method="post"
                        v-if="!contributor.video"
                        class="btn btn-primary text-sm uppercase"
                        >enable video</inertia-link
                    >
                </span>
            </div>
            <div class="md:flex items-stretch">
                <div class="md:border-r md:p-2 flex-auto">
                    <h1 class="text-lg mb-5 font-bold">User Information</h1>
                    <table class="w-100 table table-auto">
                        <tbody>
                            <tr>
                                <th class="p-2 text-right">
                                    UID
                                </th>
                                <td class="p-2">
                                    {{ contributor.uid }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    username
                                </th>
                                <td class="p-2">
                                    <a
                                        target="_blank"
                                        :href="
                                            'https://www.yayimages.com/search?phrase=username%3A' +
                                                contributor.username
                                        "
                                    >
                                        {{ contributor.username }}
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            class="h-4 inline-block fill-current"
                                        >
                                            <path
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            />
                                            <path
                                                d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"
                                            />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Name
                                </th>
                                <td class="p-2">
                                    {{ contributor.name }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    E-mail
                                </th>
                                <td class="p-2">
                                    <a :href="'mailto:' + contributor.email">{{
                                        contributor.email
                                    }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Date Joined
                                </th>
                                <td class="p-2">
                                    {{ contributor.created_at }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Last KYC verification
                                </th>
                                <td class="p-2">
                                    {{
                                        contributor.kyc_verified_at
                                            ? contributor.kyc_verified_at
                                            : "Never"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    KYC Status
                                </th>
                                <td class="p-2">
                                    <span
                                        class="text-xs p-1 border rounded block text-center"
                                    >
                                        {{
                                            contributor.kyc_verified_at
                                                ? "Identity Verified"
                                                : "Identity Not-Verified"
                                        }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Video Status
                                </th>
                                <td class="p-2">
                                    <span
                                        class="text-xs p-1 border rounded block text-center"
                                    >
                                        {{
                                            contributor.video
                                                ? "Enabled"
                                                : "Not Enabled"
                                        }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="md:border-r md:p-2 flex-auto">
                    <h1 class="text-lg mb-5 font-bold">Sales information</h1>
                    <table class="w-100 table table-auto">
                        <tbody>
                            <tr>
                                <th class="p-2 text-right">
                                    Total Downloads
                                </th>
                                <td class="p-2">{{ contributor.downloads }}</td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Avg Downloads / Month
                                </th>
                                <td class="p-2">
                                    {{ avgdownloads }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Avg Value / Month
                                </th>
                                <td class="p-2">${{ avgsales }}</td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Total Downloads Value
                                </th>
                                <td class="p-2">${{ contributor.sales }}</td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Avg Download Value
                                </th>
                                <td class="p-2">${{ downloadvalue }}</td>
                            </tr>

                            <tr>
                                <th class="p-2 text-right">
                                    Paid Out
                                </th>
                                <td class="p-2">${{ contributor.paidout }}</td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Available for pay out
                                </th>
                                <td class="p-2">
                                    ${{ contributor.available }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 text-right">
                                    Last Payout
                                </th>
                                <td class="p-2">
                                    {{
                                        contributor.last_payout
                                            ? contributor.last_payout
                                            : "N/A"
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </card>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";

export default {
    layout: Layout,
    metaInfo: function() {
        return {
            title: "Showing " + this.contributor.name
        };
    },
    components: {
        Card
    },
    props: {
        contributor: {
            type: Object
        }
    },
    computed: {
        cardtitle: function() {
            if (this.contributor) {
                return (
                    this.contributor.name + " / " + this.contributor.username
                );
            }
            return "";
        },
        avgdownloads: function() {
            let months = this.contributor.monthsfromcreated
                ? this.contributor.monthsfromcreated
                : 1;
            return Math.round(this.contributor.downloads / months);
        },
        avgsales: function() {
            let months = this.contributor.monthsfromcreated
                ? this.contributor.monthsfromcreated
                : 1;
            return Math.round(this.contributor.sales / months);
        },
        downloadvalue: function() {
            return this.contributor.sales / this.contributor.downloads;
        }
    }
};
</script>
