<template>
  <div>

    <div class="text-right mb-6">
      <button 
      @click="goToCreatePage"
      class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow-md transition-all duration-200 ease-in-out ml-4">
      Add product
    </button>
    </div>

    <h2 class="text-2xl font-semibold mb-4">Produktet në këtë folder</h2>

    <!-- Spinner while loading -->
    <div v-if="showSpinner" class="flex justify-center">
      <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v4m0 0v4m0 0h4m-4 0H8m4 0V4z" />
      </svg>
    </div>

    <!-- Display products -->
    <div v-else>
      <table v-if="products.length > 0" class="w-full bg-white shadow-md rounded-xl overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-3 text-left">Produkti</th>
            <th class="p-3 text-left">Sasia në stok</th>
            <th class="p-3 text-left">Çmimi Shitjes</th>
            <th class="p-3 text-left">pershkrimi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="border-b">
            <td class="p-3">{{ product.emri }}</td>
            <td class="p-3">{{ product.stock_quantity }}</td>
            <td class="p-3">${{ product.cmimi_shitjes }}</td>
            <td class="p-3">{{ product.pershkrimi }}</td>
          </tr>
        </tbody>
      </table>
      <p v-else>{{ noProductsMessage }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { fetchFolderProducts, fetchProducts } from '@/services/folders';
import { useRoute } from 'vue-router';
import router from '@/router';

// Initialize variables
const route = useRoute();
const products = ref([]);
const showSpinner = ref(true);
const noProductsMessage = ref('Për këtë folder nuk ka produkte');


const goToCreatePage = () => {
  // Dynamically get `folderId` and `subfolderId` from the current route's query or params
  const folderId = route.params.folderId || route.query.folderId; // Get from params or query
  const subfolderId = route.params.subfolderId || route.query.subfolderId;

  // Ensure values are available
  if (folderId && subfolderId) {
    // Navigate to the createProduct route with dynamic parameters
    router.push({ name: 'createProduct', params: { folderId, subfolderId } });
  } else {
    console.error("Folder ID or Subfolder ID is missing!");
  }
};
// Function to fetch product data based on folderId
const fetchProductData = async (folderId, subfolderId = null) => {
  if (!folderId) {
    console.error("ID e folderit mungon");
    return;
  }

  showSpinner.value = true; // Aktivizoni spinner për ngarkim
console.log('ska foldere');

  try {
    let response;

    // Nëse ka një subfolderId, kërkojmë për produktet e subfolderit
    if (subfolderId) {
      console.log(`Kërkimi i produkteve për subfolderin me ID: ${subfolderId}`);
      response = await fetchProducts(folderId, subfolderId); // Funksioni që merr produktet për subfolderin
    } else {
      // Nëse nuk ka subfolderId, kërkojmë produktet për folderin kryesor
      console.log(`Kërkimi i produkteve për folderin me ID: ${folderId}`);
      response = await fetchFolderProducts(folderId); // Funksioni që merr produktet për folderin kryesor
    }

    // Verifikoni nëse përgjigjia është e saktë (status 200)
    if (response && response.length > 0) {
      products.value = response;
      noProductsMessage.value = ''; // Nëse ka produkte, fshijmë mesazhin për mungesë produktesh
    } else {
      products.value = [];
      noProductsMessage.value = 'Për këtë folder/subfolder nuk ka produkte';
    }
  } catch (error) {
    console.error("Gabim gjatë marrjes së produkteve:", error);
    noProductsMessage.value = 'Gabim gjatë ngarkimit të produkteve. Ju lutem provoni më vonë.';
  } finally {
    showSpinner.value = false; // Fshijmë spinnerin
  }
};



// Watch for changes in the folderId parameter
watch(() => route.params.folderId, (newFolderId) => {
  fetchProductData(newFolderId);
}, { immediate: true });

// Fetch data for the initial folder when the component is mounted
onMounted(() => {
  fetchProductData(route.params.folderId);
});
</script>
