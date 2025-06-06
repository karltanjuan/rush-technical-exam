<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router, usePage } from '@inertiajs/vue3';

const users = ref([]);
const selected = ref([]);

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
});

const fetchUsers = async (page = 1) => {
  try {
    await axios.get('/sanctum/csrf-cookie');
    const res = await axios.get(`/api/users?page=${page}`);
    users.value = res.data.data ?? res.data;
    pagination.value.current_page = res.data.current_page;
    pagination.value.last_page = res.data.last_page;
    pagination.value.per_page = res.data.per_page;
    pagination.value.total = res.data.total;
  } catch (error) {
    console.error('Error fetching users:', error);
    users.value = [];
  }
};

const page = usePage();
const flashMessage = ref(page.props.flash.success ?? '');

onMounted(() => {
   if (flashMessage.value) {
    setTimeout(() => {
      flashMessage.value = '';
    }, 3000);
  }
  fetchUsers();
});
const toggleSelection = (id) => {
  if (selected.value.includes(id)) {
    selected.value = selected.value.filter(userId => userId !== id);
  } else {
    selected.value.push(id);
  }
};

const toggleAll = (e) => {
  if (e.target.checked) {
    selected.value = users.value.map(u => u.id);
  } else {
    selected.value = [];
  }
};

const deleteUser = async (id) => {
  if (!confirm('Are you sure you want to delete this user?')) return;
  try {
    await axios.get('/sanctum/csrf-cookie');
    await axios.delete(`/api/users/${id}`);
    await fetchUsers(pagination.value.current_page);
    selected.value = selected.value.filter(userId => userId !== id);
  } catch (error) {
    alert('Failed to delete user.');
    console.error(error);
  }
};

const deleteSelected = async () => {
  if (selected.value.length === 0) return;
  if (!confirm('Are you sure you want to delete selected users?')) return;
  try {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/api/users/delete-multiple', { ids: selected.value });
    selected.value = [];
    await fetchUsers(pagination.value.current_page);
  } catch (error) {
    alert('Failed to delete selected users.');
    console.error(error);
  }
};

const goToPage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return;
  fetchUsers(page);
  selected.value = [];
};
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-bold text-gray-800">User Management</h2>
    </template>

    <div class="p-4">

      <!-- Flash message controlled by reactive ref -->
      <div v-if="flashMessage" class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
        {{ flashMessage }}
      </div>

      <div class="flex justify-between mb-4">
        <PrimaryButton @click="() => router.visit('/dashboard/create')">
          Add User
        </PrimaryButton>

        <PrimaryButton
          class="bg-red-600 hover:bg-red-700"
          @click="deleteSelected"
          :disabled="selected.length === 0"
        >
          Delete Selected
        </PrimaryButton>
      </div>

      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="px-4 py-2 border border-gray-300">
              <input
                type="checkbox"
                @change="toggleAll"
                :checked="selected.length === users.length && users.length > 0"
              />
            </th>
            <th class="px-4 py-2 border border-gray-300 text-left">Email</th>
            <th class="px-4 py-2 border border-gray-300 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t border-gray-300">
            <td class="px-4 py-2 border border-gray-300 text-center">
              <input
                type="checkbox"
                :checked="selected.includes(user.id)"
                @change="() => toggleSelection(user.id)"
              />
            </td>
            <td class="px-4 py-2 border border-gray-300">{{ user.email }}</td>
            <td class="px-4 py-2 border border-gray-300 space-x-2">
              <PrimaryButton @click="() => router.visit(`/dashboard/${user.id}/edit`)">
                Edit
              </PrimaryButton>
              <PrimaryButton
                class="bg-red-600 hover:bg-red-700"
                @click="() => deleteUser(user.id)"
              >
                Delete
              </PrimaryButton>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="flex justify-center space-x-2 mt-4">
        <button
          class="px-3 py-1 border rounded disabled:opacity-50"
          :disabled="pagination.current_page === 1"
          @click="goToPage(pagination.current_page - 1)"
        >
          Previous
        </button>

        <button
          v-for="page in pagination.last_page"
          :key="page"
          class="px-3 py-1 border rounded"
          :class="page === pagination.current_page ? 'bg-blue-600 text-white' : ''"
          @click="goToPage(page)"
        >
          {{ page }}
        </button>

        <button
          class="px-3 py-1 border rounded disabled:opacity-50"
          :disabled="pagination.current_page === pagination.last_page"
          @click="goToPage(pagination.current_page + 1)"
        >
          Next
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
