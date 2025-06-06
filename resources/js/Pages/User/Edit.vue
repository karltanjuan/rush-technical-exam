<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useRouter } from 'vue-router';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { defineProps } from 'vue';

const props = defineProps({
    user: Object,
});

const router = useRouter();

const form = useForm({
    first_name: props.user.first_name,
    last_name: props.user.last_name,
    address: props.user.address,
    postcode: props.user.postcode,
    contact_phone: props.user.contact_phone,
    username: props.user.username,
    email: props.user.email,
    password: '',
});

const submit = () => {
  form.put(route('users.update', props.user.id));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
        </template>

        <div class="p-4 max-w-xl">
            <form @submit.prevent="submit" class="space-y-4">

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
                    <InputLabel for="password" value="Password (leave blank to keep current)" />
                    <TextInput id="password" type="password" v-model="form.password" class="mt-1 block w-full" />
                    <InputError :message="form.errors.password" class="mt-1" />
                </div>

                <PrimaryButton :disabled="form.processing">Update User</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
