<script setup>
import { ref, onMounted } from 'vue';
import { getProducts } from '@/services/products.js'; // Sigurohuni që importoni 'getProducts'
import DeleteModal from "@/views/produktet/DeleteProductModal.vue";

const products = ref([]); 
const showSpinner = ref(false); 
const showDeleteModal = ref(false); 
const selectedProductId = ref(null); 

const openDeleteModal = (productId) => {
  selectedProductId.value = productId;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
};
onMounted(() => {
  showSpinner.value = true;
  getProducts()
    .then((data) => {
      console.log(data.result.data);
      products.value = data.result.data;
    })
    .catch((error) => {
      console.error('Error fetching doctors:', error);
    })
    .finally(() => {
      showSpinner.value = false;
    });
});
</script>

<template>
  <Spinner v-if="showSpinner"/>
  <DeleteModal v-if="showDeleteModal" :productId="selectedProductId" @closeDeleteModal="closeDeleteModal" />


  <div className="p-6 bg-gradient-to-b from-blue-50 to-blue-100 shadow-lg min-h-screen">
    <h1 class="text-4xl font-bold text-center text-black-600 mb-8">Doctor Dashboard</h1>
<!-- 
    <div class="text-right mb-6">
      <button 
        @click="navigateToCreateDoctor"
        class="px-6 py-3 bg-gray-700 text-white rounded-lg shadow-md hover:bg-blue-700 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-300">
        Add Doctor
      </button>
    </div> -->

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
      <table class="min-w-full table-auto">
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="px-6 py-4 text-left border-b font-medium">name</th>
            <th class="px-6 py-4 text-left border-b font-medium">barcode</th>
            <th class="px-6 py-4 text-left border-b font-medium">price_of_product</th>
            <th class="px-6 py-4 text-left border-b font-medium">stok</th>
            <th class="px-6 py-4 text-left border-b font-medium">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">{{ product.emri }}</td>
            <td class="px-6 py-4">{{ product.barkodi }}</td>
            <td class="px-6 py-4">{{ product.cmimi_shitjes }}</td>
            <td class="px-6 py-4">{{ product.sasia_ne_stok }}</td>
       
            <td class="px-6 py-4 flex space-x-2">
              <RouterLink :to="{ name: 'editProduct', params: { id: product.id } }">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                  Edit
                </button>
              </RouterLink>

              <button
                @click="openDeleteModal(product.id)" 
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

