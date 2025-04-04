<script setup>
import { ref, reactive } from "vue";
import { storeProductInSubfolder } from "@/services/products";
import { useRoute } from "vue-router";
import router from "@/router";

// Formati për produktin
const form = reactive({
  emri: "",
  barkodi: "",
  cmimi_shitjes: "",
  sasia_ne_stok: "",
  subfolderId: null // Shtojmë subfolderId
});

// Merrni `folderId` dhe `subfolderId` nga URL
const route = useRoute();
const folderId = ref(route.params.folderId); // Assuming the folderId is in the route parameters
const subfolderId = ref(route.params.subfolderId); // Assuming the subfolderId is in the route parameters

// Mesazhet për sukses ose gabim
const message = ref("");
const success = ref(false);

// Funksioni për dërgimin e të dhënave për ruajtjen e produktit në subfolder
const submit = async () => {
  try {
    // Dërgoni `folderId` dhe `subfolderId` si pjesë e kërkesës
    const response = await storeProductInSubfolder(form, folderId.value, subfolderId.value);
    
    // Debugging - Shfaqni përgjigjen
    console.log("Store Product Response:", response);

    // Kontrolloni nëse ka të dhëna
    if (response) {
      message.value = "Product created successfully!";
      success.value = true;
      console.log("Product created, response:", response);

      // Prit 2 sekonda për të siguruar që mesazhi është shfaqur
      setTimeout(() => {
        router.push({ name: "products", params: { folderId: folderId.value, subfolderId: subfolderId.value } });
      }, 2000);
    }
  } catch (error) {
    message.value = "Error creating product.";
    success.value = false;

    // Shfaqni detaje për gabimin
    console.error("Error:", error.response?.data || error.message);
  }
};

</script>
<template>
  <div class="py-10 min-h-screen   flex justify-center items-center">
    <div class="bg-gray-200 shadow-lg rounded-lg p-8 w-full max-w-md">
      <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Product</h1>

      <!-- Mesazhi për sukses ose gabim -->
      <div v-if="message" :class="success ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" class="p-3 rounded-md mb-4">
        {{ message }}
      </div>

      <!-- Forma për produktin -->
      <form @submit.prevent="submit" class="space-y-4 ">
        <div>
          <label for="emri" class="block text-sm font-medium text-gray-700">Emri:</label>
          <input type="text" id="emri" v-model="form.emri" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="barkodi" class="block text-sm font-medium text-gray-700">Barkodi (opsional):</label>
          <input type="text" id="barkodi" v-model="form.barkodi" 
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="cmimi_shitjes" class="block text-sm font-medium text-gray-700">Çmimi Shitjes:</label>
          <input type="number" id="cmimi_shitjes" v-model="form.cmimi_shitjes" required step="0.01"
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

     
        <div>
    <label for="pershkrimi" class="block text-sm font-medium text-gray-700">Përshkrimi:</label>
    <textarea id="pershkrimi" v-model="form.pershkrimi" required
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
</div>


        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md">
          Save
        </button>
      </form>
    </div>
  </div>
</template>

<!-- Sidebar i zi, nëse ka një sidebar -->

