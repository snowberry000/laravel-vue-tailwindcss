<template>
    <div class="w-full flex">
        <card title="Please verify your identity" class="w-full">
            <p class="mb-5">
                Before getting your payout processed and any other data
                modification we would like to verify you identity.
            </p>
            <h3 class="font-bold mb-2">
                We will require following documents<sup
                    class="font-bold text-red-500"
                    >1</sup
                >
                to be submitted:
            </h3>
            <ul class="list-inside list-disc mb-5">
                <li>
                    Proof of identity, only valid passport or id card is
                    acceptable as proof of identity.
                </li>
                <li>Filled up w8-ben form</li>
            </ul>
            <form @submit.prevent="submit">
                <div>
                    <label class="form-label" for="documents">Documents:</label>
                    <input
                        id="documents"
                        ref="documents"
                        class="form-input"
                        :class="{
                            error: Object.keys($page.errors).length
                        }"
                        type="file"
                        multiple="multiple"
                    />
                    <div
                        v-if="Object.keys($page.errors).length"
                        class="form-error"
                    >
                        {{ $page.errors[Object.keys($page.errors)][0] }}
                    </div>
                </div>
                <div class="px-10 py-5 flex justify-between items-center">
                    <loading-button
                        :loading="sending"
                        class="btn-blue"
                        type="submit"
                        >Upload</loading-button
                    >
                </div>
            </form>
            <p class="text-xs">
                <sup class="font-bold text-red-500">1</sup> - We may ask you to
                submit additional documents.
            </p>
        </card>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Card from "@/Shared/Card";
import TextInput from "@/Shared/TextInput";
import LoadingButton from "@/Shared/LoadingButton";
//import PayoutForm from "@/Shared/PayoutForm";
export default {
    layout: Layout,
    metaInfo: { title: "Index" },
    components: {
        Card,
        TextInput,
        LoadingButton
    },
    data: function() {
        return {
            sending: false,
            form: {
                documents: []
            }
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
