<template>
    <div class="flex items-start">
        <card title="Unpaid Payouts" class="w-full">
            <div v-if="payouts.data.length">
                <table class="w-full text-sm table-auto">
                    <thead>
                        <tr>
                            <th>Request Date</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>E-mail</th>
                            <th>Payment Details</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="payout in payouts.data"
                            :key="payout.id"
                            class="border-t border-blue-500  py-2"
                        >
                            <td class="py-2 px-1">{{ payout.created_at }}</td>
                            <td class="py-2 px-1">{{ payout.uid }}</td>
                            <td class="py-2 px-1">
                                <span v-if="payout.user">
                                    {{ payout.user.name }}
                                </span>
                            </td>
                            <td class="py-2 px-1">
                                <span v-if="payout.user">
                                    <a
                                        target="_blank"
                                        :href="
                                            'https://yayimages.com/search?type=-1&phrase=username%3A' +
                                                payout.user.username
                                        "
                                        >{{ payout.user.username }}</a
                                    >
                                </span>
                            </td>
                            <td class="py-2 px-1">
                                <span v-if="payout.user">
                                    <a :href="'mailto' + payout.user.email">{{
                                        payout.user.email
                                    }}</a>
                                </span>
                            </td>
                            <td class="py-2 px-1">{{ payout.memo }}</td>
                            <td class="py-2 px-1">$ {{ payout.amount }}</td>
                            <td class="py-2 px-1">
                                <inertia-link
                                    :href="
                                        route('admin.payouts.markpaid', {
                                            payout: payout.id
                                        })
                                    "
                                    method="post"
                                    class="btn btn-primary text-sm"
                                    preserve-scroll
                                    v-if="!payout.paid_at"
                                >
                                    Mark Paid
                                </inertia-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="payouts.links" />
            </div>
            <div v-else class="text-center text-lg">
                You have no unpaid payouts. You can seee past payouts in
                <inertia-link
                    :href="route('admin.payouts')"
                    class="text-blue-500"
                    >here</inertia-link
                >
            </div>
        </card>
        <card title="Top Contributors" class="w-full md:w-1/3"></card>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import Pagination from "@/Shared/Pagination";

export default {
    layout: Layout,
    metaInfo: { title: "Index" },
    components: {
        Card,
        Pagination
    },
    props: {
        payouts: {
            type: Object
            //deep: true
        }
    },
    data: function() {
        return {
            payout: false
        };
    }
};
</script>

<style></style>
