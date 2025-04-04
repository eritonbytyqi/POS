<template>
  <div class="flex justify-center items-center min-h-screen bg-gradient-to-b from-blue-50 to-blue-100 p-4">
    <div class="bg-white p-8 shadow-lg rounded-lg w-full max-w-xl">
      
      <div v-if="!selectedProdukt" class="text-center mb-6">
  <h2 class="text-3xl font-semibold text-gray-800">Kërko Produktin</h2>
  <p class="text-lg text-gray-600 mt-2">Kërko produkte sipas emrit ose barkodit</p>
</div>
      <!-- Input për kërkimin e produktit (shfaqet vetëm nëse nuk është zgjedhur një produkt) -->
      <div v-if="showSearchInput" class="flex justify-center mb-4">
        <input 
          type="text" 
          v-model="searchQuery" 
          @input="debouncedSearch"  
          placeholder="Kërko produktin..." 
          class="p-3 w-full max-w-md border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Detajet e produktit pasi është zgjedhur -->
      <div v-if="selectedProdukt" class="mt-6 w-full max-w-2xl text-center">
        <p><strong class="text-2xl">{{ selectedProdukt.emri || 'Emri i produktit nuk u gjet' }}</strong></p>

        <!-- Detajet për produktin -->
        <div class="mt-4">
          <p class="text-xl text-center mb-4">Detajet për produktin:</p>
          <div class="bg-gray-100 p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto">
            <p class="text-lg"><strong>{{ selectedProdukt.emri }}</strong></p>
            <p class="text-lg"><strong>Barkodi:</strong> {{ selectedProdukt.barkodi || 'Nuk ka barkod' }}</p>
            <p class="text-lg"><strong>Çmimi i Shitjes:</strong> €{{ selectedProdukt.cmimi_shitjes }}</p>
            <p class="text-lg"><strong>Sasia në Stok:</strong> {{ selectedProdukt.sasia_ne_stok }}</p>
          </div>

          <!-- Input për sasinë -->
          <label for="sasia" class="block mt-4 text-lg">Sasia</label>
          <input 
            id="sasia"
            type="number" 
            v-model="sasia" 
            min="1"
            class="p-3 border rounded mt-2 w-full max-w-lg"
            :placeholder="'Sasia për ' + selectedProdukt.emri"
          />
          
          <!-- Butoni për të ndryshuar produktin -->
          <button 
            @click="resetProdukt"
            class="mt-4 px-4 py-2 bg-red-500 text-white rounded"
          >
            Ndrysho produktin
          </button>
        </div>
      </div>

      <!-- Zgjedhja e produktit (nëse nuk është zgjedhur ende) -->
      <div v-if="filteredProduktet.length > 0 && showSearchInput" class="mt-4">
        <label for="product-select" class="block text-lg">Zgjidhni një Produkt:</label>
        <select 
  v-model="selectedProduktId" 
  @change="selectProdukt"
  class="p-3 w-full max-w-md border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
>
  <option value="" disabled>-- Zgjidhni një produkt --</option>
  <option 
    v-for="produkt in filteredProduktet" 
    :key="produkt.id" 
    :value="produkt.id"
  >
    {{ produkt.emri }} - {{ produkt.cmimi_shitjes }}€
  </option>
</select>

      </div>

      <!-- Butoni për shtimin e shitjes -->
      <div v-if="selectedProdukt" class="mt-6 text-center">
        <button 
          @click="submitShitje"
          class="p-3 bg-blue-500 text-white rounded w-full"
        >
          Shto në shitje
        </button>
      </div>

      <!-- Mesazhi nëse nuk ka produkte -->
      <div v-else-if="searchQuery && produktet.length === 0 && showSearchInput" class="mt-6 text-center text-red-600">
        <p class="text-xl">Nuk u gjetën produkte për kërkimin tuaj.</p>
      </div>
      
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { post } from '@/composable/useApi';
import axios from 'axios';
import { useRoute } from 'vue-router';
import { debounce } from 'lodash';

const produktet = ref([]);
const searchQuery = ref('');
const sasia = ref(1);
const selectedProduktId = ref(null); // Id e produktit të selektuar
const selectedProdukt = ref(null);
const showSearchInput = ref(true);

// Funksioni për të selektuar një produkt për shitje
const selectProdukt = () => {
  const produkt = produktet.value.find(p => p.id == selectedProduktId.value);
  
  if (produkt) {
    selectedProdukt.value = produkt; 
    showSearchInput.value = false; 
  } else {
    selectedProdukt.value = null;
  }
};


// Funksioni për të rivendosur produktin dhe për të shfaqur inputin e kërkimit
const resetProdukt = () => {
  selectedProdukt.value = null;
  showSearchInput.value = true;
};

// Funksioni për kërkimin e produkteve
const fetchProduktet = async () => {
  if (!searchQuery.value) {
    // alert('Ju lutem shkruani një emër produkti për të kërkruar.');
    return;
  }
  try {
    const response = await post('/api/produktet/veqmas', { search: searchQuery.value });
    produktet.value = response.data.length > 0 ? response.data : [];
  } catch (error) {
    console.error('Gabim gjatë marrjes së produktit:', error);
    // alert('Gabim gjatë kërkimit të produktit.');
  }
};

// Funksioni për të ruajtur shitjen në databazë
const route = useRoute();
const klientId = route.query.id;
const submitShitje = async () => {
  if (!selectedProdukt.value) {
    alert("Zgjidhni një produkt përpara se të vazhdoni.");
    return;
  }

  if (!klientId) {
    alert("Të dhëna të munguara: ID e klientit.");
    return;
  }

  try {
    await axios.post('http://127.0.0.1:8000/api/shitjet', {
      produkt_id: selectedProdukt.value.id,
      sasia: sasia.value,
      klienti_id: klientId
    });

    alert("Shitja u krye me sukses!");
  } catch (error) {
    console.error("Gabim gjatë dërgimit të shitjes:", error);
    alert("Gabim gjatë dërgimit të shitjes.");
  }
};


// Computed për filtrimin e produkteve
const filteredProduktet = computed(() => produktet.value.filter(p =>
  p.emri.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
  p.barkodi.toLowerCase().includes(searchQuery.value.toLowerCase())
));

// Funksioni për kërkimin me debounce
const debouncedSearch = debounce(fetchProduktet, 500);
</script>
