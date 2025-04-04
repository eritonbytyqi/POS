<template>
    <div>
      <!-- Të dhënat e raportit -->
      <h2 class="text-2xl font-semibold mb-4">Raportimet</h2>
  
      <!-- Spinner -->
      <div v-if="showSpinner" class="flex justify-center">
        <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v4m0 0v4m0 0h4m-4 0H8m4 0V4z" />
        </svg>
      </div>
  
      <!-- Shfaq shitjet për një datë specifike -->
      <div v-if="showSalesForDate">
        <h3>Shitjet për Datën: {{ selectedDate }}</h3>
        <pre>{{ salesForDate }}</pre>
      </div>
  
      <!-- Input dhe Buton për datën -->
      <div>
        <input type="date" v-model="selectedDate" />
        <button @click="getShitjetPerDate">Merr shitjet për këtë datë</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { fetchShitjetPerDate } from '@/services/raportimet';
  
  const showSpinner = ref(false);
  const selectedDate = ref('');
  const salesForDate = ref(null);
  const showSalesForDate = ref(false);
  
  // Funksioni për të marrë shitjet për datën e specifikuar
  const getShitjetPerDate = async () => {
    if (!selectedDate.value) {
      console.error("Ju lutem zgjidhni një datë.");
      return;
    }
    showSpinner.value = true;
    
    try {
      salesForDate.value = await fetchShitjetPerDate(selectedDate.value);
      showSalesForDate.value = true;
    } catch (error) {
      console.error("Gabim gjatë marrjes së shitjeve për datën:", error);
    } finally {
      showSpinner.value = false;
    }
  };
  </script>
  