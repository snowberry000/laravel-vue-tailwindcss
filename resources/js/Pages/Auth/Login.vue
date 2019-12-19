<template>
  <div class="p-6  bg-indigo-darker min-h-screen flex justify-center items-center">
    <div class="p-5 w-full max-w-sm border rounded shadow-xl">
        <Logo class="mb-5 mx-auto h-8" />
        <form @submit.prevent="submit">
          <text-input v-model="form.email" :errors="$page.errors.email" class="mt-5" label="Email" type="email" autofocus autocapitalize="off" />
          <text-input v-model="form.password" class="mt-5" label="Password" type="password" />
          <label class="mt-5 select-none flex items-center" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox">
            <span class="text-sm">Remember Me</span>
          </label>
          <loading-button :loading="sending" class="btn-blue mt-5" type="submit">Login</loading-button>
          </form>
    </div>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/LoadingButton";
import Logo from "@/Shared/Logo";
import TextInput from "@/Shared/TextInput";

export default {
    metaInfo: { title: "Login" },
    components: {
        LoadingButton,
        Logo,
        TextInput
    },
    props: {
        errors: Object
    },
    data() {
        return {
            sending: false,
            form: {
                email: "johndoe@example.com",
                password: "secret",
                remember: null
            }
        };
    },
    methods: {
        submit() {
            this.sending = true;
            this.$inertia
                .post(this.route("login.attempt"), {
                    email: this.form.email,
                    password: this.form.password,
                    remember: this.form.remember
                })
                .then(() => (this.sending = false));
        }
    }
};
</script>
