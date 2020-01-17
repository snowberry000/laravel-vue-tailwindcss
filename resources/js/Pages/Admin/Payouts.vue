<template>
    <div class="flex items-start">
        <card title="Payouts" class="w-full">
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
                            <a href="#" class="btn-blue block">Mark Paid</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :links="payouts.links" />
        </card>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import Pagination from "@/Shared/Pagination";

export default {
    metaInfo: { title: "Contributor Payouts" },
    layout: Layout,
    components: {
        Card,
        Pagination
    },
    props: {
        payouts: Object
    }
};
</script>
