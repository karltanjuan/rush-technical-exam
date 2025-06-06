<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    address: '',
    postcode: '',
    contact_phone: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="first_name" value="First Name" />
                    <TextInput id="first_name" type="text" v-model="form.first_name" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.first_name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="last_name" value="Last Name" />
                    <TextInput id="last_name" type="text" v-model="form.last_name" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.last_name" class="mt-2" />
                </div>
            </div>

            <div>
                <InputLabel for="address" value="Address" />
                <TextInput id="address" type="text" v-model="form.address" class="mt-1 block w-full" required />
                <InputError :message="form.errors.address" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="postcode" value="Postcode" />
                    <TextInput id="postcode" type="text" v-model="form.postcode" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.postcode" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="contact_phone" value="Phone" />
                    <TextInput id="contact_phone" type="text" v-model="form.contact_phone" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.contact_phone" class="mt-2" />
                </div>
            </div>

            <div>
                <InputLabel for="username" value="Username" />
                <TextInput id="username" type="text" v-model="form.username" class="mt-1 block w-full" required />
                <InputError :message="form.errors.username" class="mt-2" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" class="mt-1 block w-full" required />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" v-model="form.password" class="mt-1 block w-full" required />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" class="mt-1 block w-full" required />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
