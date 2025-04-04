<script setup>
import { ref, reactive, watch } from "vue";
import { storeStoku } from "@/services/stoku";
import { post } from "@/composable/useApi";

// Formati për stokun
const form = reactive({
  produkt_id: "",
  sasia_ne_stok: "",
  cmimi_blerjes: "",
});

// Mesazhet për sukses ose gabim
const message = ref("");
const success = ref(false);

// Lista për produktet që do të shfaqen
const produktet = ref([]);
const searchQuery = ref("");  // Termi i kërkimit

// Funksioni për kërkimin e produkteve
const fetchProduktet = async () => {
  if (!searchQuery.value) {
    produktet.value = [];  // Nëse nuk ka kërkim, pastro listën
    return;
  }
  try {
    // Sigurohuni që përdorni endpoint-in e duhur
    const response = await post('/api/produktet/veqmas', { search: searchQuery.value });
    if (response.status === 200 && Array.isArray(response.data) && response.data.length > 0) {
      produktet.value = response.data;  // Ruaj produktet që kthehen
    } else {
      produktet.value = [];  // Pastro listën nëse nuk ka rezultate
    }
  } catch (error) {
    console.error('Gabim gjatë marrjes së produktit:', error);
    produktet.value = [];
  }
};

// Dëgjo për ndryshimin e `searchQuery` dhe kërko produktet
watch(searchQuery, () => {
  if (searchQuery.value.length > 2) {  // Kërko kur të ketë më shumë se 2 karaktere
    fetchProduktet();
  }
});

// Funksioni për dërgimin e të dhënave për ruajtjen e stokut
const submit = async () => {
  try {
    const response = await storeStoku(form);

    if (response) {
      message.value = "Stoku u shtua me sukses!";
      success.value = true;
    }
  } catch (error) {
    message.value = "Gabim gjatë shtimit të stokut.";
    success.value = false;
  }
};

// Funksioni për të zgjedhur produktin dhe pastruar listën e produkteve, por të ruajtur inputin
const selectProduct = (product) => {
  form.produkt_id = product.id;
  form.sasia = 1;  // Mund të vendosësh një vlerë të paracaktuar për sasinë
  form.cmimi_blerjes = product.cmimi_blerjes;  // Vendos çmimin e blerjes nga produkti
  produktet.value = [];  // Pastro listën e produkteve pas zgjedhjes
  searchQuery.value = product.emri;  // Vendos emrin e produktit në inputin e kërkimit
};
</script>

<template>
  <div class="py-10 min-h-screen flex justify-center items-center">
    <div class="bg-gray-200 shadow-lg rounded-lg p-8 w-full max-w-md">
      <h1 class="text-2xl font-semibold text-gray-800 mb-6">Shto Stok</h1>

      <!-- Mesazhi për sukses ose gabim -->
      <div v-if="message" :class="success ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" class="p-3 rounded-md mb-4">
        {{ message }}
      </div>

      <!-- Forma për stokun -->
      <form @submit.prevent="submit" class="space-y-4">
        <!-- Kërkoni Produktin -->
        <div>
          <label for="produkt_name" class="block text-sm font-medium text-gray-700">Kërko Produktin</label>
          <input 
            type="text" 
            v-model="searchQuery" 
            placeholder="Shkruaj emrin e produktit..." 
            class="p-2 border rounded w-full" 
          />
          
          <!-- Shfaq produktet që përputhen me kërkimin -->
          <ul v-if="produktet.length > 0" class="mt-2 bg-white border border-gray-300 max-h-60 overflow-auto">
            <li v-for="product in produktet" :key="product.id" @click="selectProduct(product)" class="cursor-pointer p-2 hover:bg-gray-100">
              <div class="font-semibold">{{ product.emri }}</div>
              <div class="text-sm text-gray-600">Çmimi: {{ product.cmimi_shitjes }} $</div>
              <div class="text-xs text-gray-500">{{ product.pershkrimi }}</div>
            </li>
          </ul>
        </div>

        <!-- Sasia -->
        <div>
          <label for="sasia" class="block text-sm font-medium text-gray-700">Sasia</label>
          <input type="number" id="sasia" v-model="form.sasia_ne_stok" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Fut Sasinë" />
        </div>

        <!-- Çmimi i Blerjes -->
        <div>
          <label for="cmimi_blerjes" class="block text-sm font-medium text-gray-700">Çmimi i Blerjes</label>
          <div class="relative">
  <input type="text" id="cmimi_blerjes" v-model="form.cmimi_blerjes" required 
         class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-8" 
         placeholder="Fut Çmimin e Blerjes" />
  <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">€</span>
</div>

        </div>

        <!-- Butoni për ruajtjen -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md">
          Ruaj Stokun
        </button>
      </form>
    </div>
  </div>
</template>
