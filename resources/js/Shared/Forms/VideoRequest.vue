<template>
    <card title="Get Pre-Approved For Video Submission">
        <div v-if="!submitted">
            <p class="text-sm">
                Have a collection of videos, contact us to get more information.
            </p>
            <form @submit.prevent="submit">
                <text-input
                    v-model="form.portfolio"
                    :errors="$page.errors.portfolio"
                    class="mt-5"
                    label="Portfolio link"
                    type="text"
                    autofocus
                    autocapitalize="off"
                    placeholder="Submit a link to your video portfolio"
                />
                <text-input
                    v-model="form.portfolio"
                    :errors="$page.errors.portfolio"
                    class="mt-5"
                    label="Number of Videos"
                    type="text"
                    autofocus
                    autocapitalize="off"
                    placeholder="Number of videos one can provide."
                />
                <div class="form-control mt-5">
                    <label for="notes" class="form-label">Notes:</label>
                    <textarea
                        v-model="form.information"
                        id="notes"
                        class="form-input"
                        placeholder="Notes"
                    ></textarea>
                    <div v-if="$page.errors.information" class="form-error">
                        {{ $page.errors.information[0] }}
                    </div>
                </div>
                <loading-button
                    :loading="sending"
                    class="btn btn-primary mt-5"
                    type="submit"
                    :disabled="sending"
                >
                    Send Request
                </loading-button>
            </form>
        </div>
        <div v-else>
            <p class="text-center">
                Thank you for submitting.
            </p>
        </div>
    </card>
</template>

<script>
import Card from "@/Shared/Card";
import LoadingButton from "@/Shared/LoadingButton";
import TextInput from "@/Shared/TextInput";

export default {
    components: { Card, TextInput, LoadingButton },
    data: function() {
        return {
            sending: false,
            submitted: false,
            form: {
                portfolio: null,
                number_of_videos: null,
                information: null
            }
        };
    },
    methods: {
        submit: function() {
            this.sending = true;
            this.$inertia
                .submit(route("submit.request"), this.form)
                .then(res => {
                    this.sending = false;
                })
                .catch(err => {
                    this.sending = false;
                });
        }
    }
};
</script>
