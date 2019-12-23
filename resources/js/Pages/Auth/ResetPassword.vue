<template>
    <div
        class="p-6  bg-indigo-darker min-h-screen flex justify-center items-center"
    >
        <div class="p-5 w-full max-w-sm border rounded shadow-xl">
            <Logo class="mb-5 mx-auto h-8" />
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
                <text-input
                    v-model="form.password"
                    class="mt-5"
                    label="Password"
                    type="password"
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
        token: String
    },
    data() {
        return {
            sending: false,
            form: {
                email: null,
                password: null
            }
        };
    },
    methods: {
        submit() {
            this.sending = true;
            this.$inertia
                .post(this.route("password.update"), {
                    email: this.form.email,
                    password: this.form.password,
                    token: this.token
                })
                .then(() => (this.sending = false));
        }
    }
};
</script>
