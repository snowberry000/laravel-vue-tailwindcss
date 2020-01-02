<template>
    <div>
        <div class="p-5 bg-blue-500 rounded shadow text-white">
            <p
                class="font-bold text-red-500 text-center mb-2"
                v-if="!aboveTreshold"
            >
                Minimum payout amount is $30.
            </p>
            <p>
                We can payout to your Paypal account and or Skrill (previously
                known as moneybookers) account.
            </p>
        </div>
        <div class="my-5">
            <p class="mb-5">Earnings to be paid out: $ {{ available.value }}</p>

            <form @submit.prevent="submit">
                <div v-if="aboveTreshold">
                    <label lass="form-label" for="memo">Payout Details:</label>
                    <textarea
                        v-model="memo"
                        id="memo"
                        class="form-input"
                        placeholder="Payout method additional details."
                    >
                    </textarea>
                    <div v-if="$page.errors.length" class="form-error">
                        {{ $page.errors.memo[0] }}
                    </div>
                </div>
                <div class="flex  mt-5">
                    <loading-button
                        :loading="sending"
                        class="btn-blue"
                        type="submit"
                        v-if="aboveTreshold"
                        :disabled="!aboveTreshold"
                        >Request</loading-button
                    >
                    <a
                        @click="close()"
                        class="px-6 py-3 ml-5 text-sm  block border border-blue-500 text-blue-500 uppercase rounded text-center "
                        >Cancel</a
                    >
                </div>
            </form>
            <!--  -->
        </div>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/LoadingButton";

export default {
    components: {
        LoadingButton
    },
    props: {
        available: {
            sending: false,
            type: Object,
            required: true,
            memo: null
        }
    },
    computed: {
        aboveTreshold: function() {
            return Number(this.available.value) > 20;
        }
    },
    data: function() {
        return {
            memo: null,
            sending: false
        };
    },
    methods: {
        submit() {
            this.sending = true;
            this.$inertia
                .post(this.route("payout.create"), {
                    memo: this.memo
                })
                .then(() => {
                    this.sending = false;
                    this.$emit("success");
                });
        },
        close: function() {
            this.$emit("success");
        }
    }
};
</script>
