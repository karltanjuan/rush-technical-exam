<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    address: '',
    postcode: '',
    contact_phone: '',
    username: '',
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('users.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800">Add New User</h2>
        </template>

        <div class="p-4">
            <form @submit.prevent="submit" class="max-w-xl space-y-4">

                <div>
                    <InputLabel for="first_name" value="First Name" />
                    <TextInput id="first_name" v-model="form.first_name" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.first_name" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="last_name" value="Last Name" />
                    <TextInput id="last_name" v-model="form.last_name" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.last_name" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="address" value="Address" />
                    <TextInput id="address" v-model="form.address" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.address" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="postcode" value="Postcode" />
                    <TextInput id="postcode" v-model="form.postcode" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.postcode" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="contact_phone" value="Contact Phone Number" />
                    <TextInput id="contact_phone" v-model="form.contact_phone" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.contact_phone" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="username" value="Username" />
                    <TextInput id="username" v-model="form.username" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.username" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="email" v-model="form.email" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.email" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="password" value="Password" />
                    <TextInput id="password" type="password" v-model="form.password" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.password" class="mt-1" />
                </div>

                <PrimaryButton :disabled="form.processing">Create User</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
