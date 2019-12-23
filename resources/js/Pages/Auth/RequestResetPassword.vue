<template>
    <div
        class="p-6  bg-indigo-darker min-h-screen flex justify-center items-center"
    >
        <div class="p-5 w-full max-w-sm border rounded shadow-xl">
            <Logo class="mb-5 mx-auto h-8" />
            <div
                class="my-5 p-4 rounded bg-blue-200 text-center"
                v-if="flash.status"
            >
                {{ flash.status }}
            </div>
            <form @submit.prevent="submit">
                <text-input
                    v-model="form.email"
                    :errors="$page.errors.email"
                    class="mt-5"
                    label="Email"
                    type="email"
                    autofocus
                    autocapitalize="off"
                />
                <loading-button
                    :loading="sending"
                    class="btn-blue mt-5"
                    type="submit"
                    >Reset Password</loading-button
                >
            </form>
        </div>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/LoadingButton";
import Logo from "@/Shared/Logo";
import TextInput from "@/Shared/TextInput";

export default {
    metaInfo: { title: "Reset Password" },
    components: {
        LoadingButton,
        Logo,
        TextInput
    },
    props: {
        errors: Object,
        flash: Object
    },
    data() {
        return {
            sending: false,
            form: {
                email: null
                //password: "secret",
                //remember: null
            }
        };
    },
    methods: {
        submit() {
            this.sending = true;
            this.$inertia
                .post(this.route("password.email"), {
                    email: this.form.email
                    //password: this.form.password,
                    //remember: this.form.remember
                })
                .then(() => (this.sending = false));
        }
    }
};
</script>
