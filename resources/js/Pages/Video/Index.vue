<template>
    <div class="flex items-start">
        <card title="Videos" :class="selected ? 'w-2/4' : 'w-full'">
            <table-list
                :videos="videos"
                :status="status"
                :currentStatus="currentStatus"
            ></table-list>
            <Pagination :links="videos.links" />
        </card>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import Pagination from "@/Shared/Pagination";
import TableList from "@/Shared/Videos/TableList";
//import PayoutForm from "@/Shared/PayoutForm";
export default {
    layout: Layout,
    metaInfo: { title: "Index" },
    components: {
        Card,
        Pagination,
        TableList
    },
    props: {
        videos: Object,
        status: Object,
        currentStatus: String
    },
    data: function() {
        return {
            sending: false,
            form: {
                documents: []
            },
            selected: null
        };
    },
    methods: {
        submit: function() {
            let formData = new FormData();

            for (var i = 0; i < this.$refs.documents.files.length; i++) {
                let file = this.$refs.documents.files[i];
                formData.append("documents[" + i + "]", file);
            }
            this.sending = true;
            this.$inertia.post("/kyc", formData).then(() => {
                this.sending = false;
                this.$refs.documents.value = null;
            });
        }
    }
};
</script>
