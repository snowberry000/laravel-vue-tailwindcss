<template>
    <div class="w-full">
        <div class="w-full md:flex items-start">
            <card title="Earnings" class="w-full md:w-1/3" v-if="!payout">
                <table class="table table-auto w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th></th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2">Lifetime Earnings</td>
                            <td class="py-2">$ {{ total.value }}</td>
                        </tr>
                        <tr class="border-b my-2">
                            <td class="py-2">Last 30 days</td>
                            <td class="py-2">$ {{ last30.value }}</td>
                        </tr>
                        <tr class="border-b my-2">
                            <td class="py-2">Earnings Available</td>
                            <td class="py-2">$ {{ available.value }}</td>
                        </tr>
                    </tbody>
                </table>
                <a
                    @click="requestPayout()"
                    class="block border border-blue-500 text-blue-500 uppercase text-blue-500 rounded text-center p-5 m-5"
                    >Request Payout</a
                >
            </card>
            <card title="Request Payout" class="w-full md:w-1/3" v-else>
                <payout-form @success="payout = false" :available="available" />
            </card>
            <card title="Recent Downloads" class="w-full md:w-2/3">
                <a
                    :href="route('downloads.show')"
                    class="block border border-blue-500 text-blue-500 uppercase text-blue-500 rounded text-center p-2 m-5"
                    >View all &raquo;</a
                >
                <table
                    class="table w-full table-fixed text-left"
                    v-if="downloads.items.length || downloads.promo > 0"
                >
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Purchase Date</th>
                            <th>Your Earnings ($)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            class="border-t border-blue-300"
                            v-if="downloads.promo > 0"
                        >
                            <td class="py-2">Promotion</td>
                            <td class="py-2"></td>
                            <td class="py-2">$ {{ downloads.promo }}</td>
                        </tr>
                        <tr
                            v-for="download in downloads.items"
                            :key="download.id"
                            class="border-t border-blue-300 "
                        >
                            <td class="py-2">
                                <img
                                    class="w-1/3"
                                    :src="download.image_url"
                                    :alt="download.image_id"
                                />
                            </td>
                            <td class="py-2">{{ download.purchased_at }}</td>
                            <td class="py-2">
                                $ {{ download.amount }}
                                <span
                                    v-if="download.amount < 0.02"
                                    class="text-xs p-1 leading-none border border-blue-500 bg-blue-500 text-white rounded"
                                    >PROMO</span
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="py-16">
                    <h2>You have no downloads.</h2>
                </div>
            </card>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import PayoutForm from "@/Shared/PayoutForm";
export default {
    layout: Layout,
    metaInfo: { title: "Index" },
    components: {
        Card,
        PayoutForm
    },
    props: {
        total: Object,
        last30: Object,
        downloads: [Array, Object],
        available: Object
    },
    data: function() {
        return {
            payout: false
        };
    },
    methods: {
        requestPayout: function() {
            if (!this.$page.auth.user.kyc_verified_at) {
                return this.$inertia.visit(route("kyc.create"));
            }
            this.payout = !this.payout;
        }
    }
};
</script>
