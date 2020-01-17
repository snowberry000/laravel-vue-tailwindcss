<template>
    <div class="flex items-start">
        <card title="Select Reporting Period" class="w-full md:w-1/3 lg:w-1/4">
            <datepicker
                minimum-view="month"
                maximum-view="month"
                format="MMMM yyyy"
                inline
                v-model="currentDate"
                @input="salesForDate()"
            />
        </card>
        <card
            :title="'Image Sales ' + formattedDate"
            class="w-full md:w-2/3 lg:w-3/4"
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
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import Datepicker from "vuejs-datepicker";

export default {
    data: function() {
        return {
            currentDate: this.date,
            sending: false
        };
    },
    layout: Layout,
    computed: {
        formattedDate: function() {
            return this.moment(this.currentDate).format("MMMM YYYY");
        },
        formattedDateSlug: function() {
            return this.moment(this.currentDate).format("YYYY-MM");
        }
    },
    metaInfo: function() {
        return { title: "Image Sales " + this.formattedDate };
    },
    components: {
        Card,
        Datepicker
    },
    props: {
        downloads: Array,
        date: String
    },
    methods: {
        salesForDate: function() {
            this.sending = true;
            this.$inertia
                .visit(
                    this.route("downloads.show", {
                        date: this.formattedDateSlug
                    })
                )
                .then(() => {
                    this.sending = false;
                });
        }
    }
};
</script>
