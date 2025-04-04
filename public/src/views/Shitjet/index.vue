<script setup>
import { ref, onMounted } from 'vue';
import { getShitjet } from '@/services/shitja';
// import DeleteModal from "@/views/Shitjet/DeleteShitjeModal.vue";
import Spinner from "@/components/Spinner.vue"; // Adjust path accordingly
import router from '@/router';

const shitjet = ref([]); 
const showSpinner = ref(false); 
// const showDeleteModal = ref(false); 

// const openDeleteModal = (shitjeId) => {
//   selectedShitjeId.value = shitjeId;
//   showDeleteModal.value = true;
// };

// const closeDeleteModal = () => {
//   showDeleteModal.value = false;
// };

onMounted(() => {
  showSpinner.value = true;
  console.log('Showing spinner:', showSpinner.value);
  getShitjet()
    .then((data) => {
      console.log("Full Response:", data);
      if (data && data.result && data.result.data) {
        shitjet.value = data.result.data; // Sigurohuni që ka këtë strukturë
      }
    })
    .catch((error) => {
      console.error('Error fetching sales:', error);
    })
    .finally(() => {
      showSpinner.value = false;
      console.log('Hiding spinner:', showSpinner.value);
    });
});

const navigateToCreateShitje = () => {
  router.push('/create-shitje');
};
</script>

<template>
  <Spinner v-if="showSpinner"/>
  <!-- <DeleteModal v-if="showDeleteModal" :shitjeId="selectedShitjeId" @closeDeleteModal="closeDeleteModal" /> -->

  <div class="p-6 bg-gradient-to-b from-blue-50 to-blue-100 shadow-lg min-h-screen">
    <h1 class="text-4xl font-bold text-center text-black-600 mb-8">Sales Dashboard</h1>

    <div class="text-right mb-6">
      <button 
        @click="navigateToCreateShitje"
        class="px-6 py-3 bg-gray-700 text-white rounded-lg shadow-md hover:bg-blue-700 transition-all duration-200">
        Add Sale
      </button>
    </div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
      <table class="min-w-full table-auto">
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="px-6 py-4 text-left border-b font-medium">Client Name</th>
            <th class="px-6 py-4 text-left border-b font-medium">Product Name</th>
            <th class="px-6 py-4 text-left border-b font-medium">Quantity</th>
            <th class="px-6 py-4 text-left border-b font-medium">total</th>
            <th class="px-6 py-4 text-left border-b font-medium">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="shitje in shitjet" :key="shitje.id" class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">{{ shitje.klienti_emri }}</td> <!-- Client name -->
            <td class="px-6 py-4">{{ shitje.produkt_emri }}</td> <!-- Product name -->
            <td class="px-6 py-4">{{ shitje.SASIA }}</td>
            <td class="px-6 py-4">{{ shitje.totali }}</td> <!-- Quantity -->
             <!-- Quantity -->
            
            <td class="px-6 py-4 flex space-x-2">
              <RouterLink :to="{ name: 'editShitja', params: { id: shitje.id } }">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                  Edit
                </button>
              </RouterLink>

              <!-- <button
                @click="openDeleteModal(shitje.id)" 
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition-all duration-200">
                Delete
              </button> -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>