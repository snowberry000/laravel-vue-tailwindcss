<template>
    <div class="w-full">
        <card class="w-100 bg-blue-500 text-white font-bold">
            We are still moving the data so earnings and payout information will
            change.
        </card>
        <div class="w-full md:flex items-start">
            <card title="Earnings" class="w-full md:w-1/3">
                <table class="table table-auto w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th></th>
                            <th>Count</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2">Lifetime Earnings</td>
                            <td>{{ total.count }}</td>
                            <td class="py-2">$ {{ total.value }}</td>
                        </tr>
                        <tr class="border-b my-2">
                            <td class="py-2">Last 30 days</td>
                            <td>{{ last30.count }}</td>
                            <td class="py-2">$ {{ last30.value }}</td>
                        </tr>
                        <tr class="border-b my-2">
                            <td class="py-2">Earnings Available</td>
                            <td>{{ available.count }}</td>
                            <td class="py-2">$ {{ available.value }}</td>
                        </tr>
                    </tbody>
                </table>
                <a
                    href="#"
                    class="block border border-blue-500 text-blue-500 uppercase text-blue-500 rounded text-center p-5 m-5"
                    >Request Payout</a
                >
            </card>
            <card title="Recent Downloads" class="w-full md:w-2/3">
                <a
                    :href="route('downloads.show')"
                    class="block border border-blue-500 text-blue-500 uppercase text-blue-500 rounded text-center p-2 m-5"
                    >View all &raquo;</a
                >
                <table
                    class="table w-full table-fixed text-left"
                    v-if="downloads"
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
                            v-for="download in downloads"
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
import Layout from "@/components/Layout";
import Card from "@/Shared/Card";
export default {
    layout: Layout,
    metaInfo: { title: "Index" },
    components: {
        Card
    },
    props: {
        total: Object,
        last30: Object,
        downloads: Array,
        available: Object
    }
};
</script>
