<script setup>
import { ref, onMounted } from 'vue';
import { getProducts } from '@/services/products.js'; // Sigurohuni që importoni 'getProducts'
import DeleteModal from "@/views/Klientet/DeleteKlientModal.vue";
import { getKlientet } from '@/services/klientet';
import router from '@/router';

const klientet = ref([]); 
const showSpinner = ref(false); 
const showDeleteModal = ref(false); 
const selectedKlientId = ref(null); 

const openDeleteModal = (klientId) => {
  selectedKlientId.value = klientId;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
};
onMounted(() => {
  showSpinner.value = true;
  getKlientet()
    .then((data) => {
      console.log("Full Response:", data);  
      // console.log(data.result.data);
      klientet.value = data.result.data;
    })
    .catch((error) => {
      console.error('Error fetching doctors:', error);
    })
    .finally(() => {
      showSpinner.value = false;
    });
});

const goToCreateKlientPage = () => {
  router.push('/create/klient');
};

</script>

<template>
  <Spinner v-if="showSpinner"/>
  <DeleteModal v-if="showDeleteModal" :klientId="selectedKlientId" @closeDeleteModal="closeDeleteModal" />


  <div className="p-6 bg-gradient-to-b from-blue-50 to-blue-100 shadow-lg min-h-screen">
    <h1 class="text-4xl font-bold text-center text-black-600 mb-8">Klient Dashboard</h1>

    <div class="text-right mb-6">
      <button 
    @click="goToCreateKlientPage"
    class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow-md transition-all duration-200 ease-in-out">
    Add Klient
  </button>
    </div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
      <table class="min-w-full table-auto">
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="px-6 py-4 text-left border-b font-medium">emri</th>
            <th class="px-6 py-4 text-left border-b font-medium">mbiemri</th>
            <th class="px-6 py-4 text-left border-b font-medium">telefoni</th>
            <th class="px-6 py-4 text-left border-b font-medium">email</th>
            <th class="px-6 py-4 text-left border-b font-medium">adresa</th>
            <th class="px-6 py-4 text-left border-b font-medium">qyteti</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="klient in klientet" :key="klient.id" class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">{{ klient.emri }}</td>
            <td class="px-6 py-4">{{ klient.mbiemri }}</td>
            <td class="px-6 py-4">{{ klient.telefoni }}</td>
            <td class="px-6 py-4">{{ klient.adresa }}</td>
            <td class="px-6 py-4">{{ klient.qyteti}}</td>
       
            <td class="px-6 py-4 flex space-x-2">
              <RouterLink :to="{ name: 'editKlient', params: { id: klient.id } }">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                  Edit
                </button>
              </RouterLink>

              <button
                @click="openDeleteModal(klient.id)" 
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition-all duration-200">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

