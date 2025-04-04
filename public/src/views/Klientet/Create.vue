<script setup>
import { ref, reactive, onMounted } from "vue";
import { storeKlient } from "@/services/klientet";
import { useRoute, useRouter } from "vue-router";

const form = reactive({
  emri: "",
  mbiemri: "",
  telefoni: "",
  email: "",
  adresa: "",
  qyteti: "",
});

const route = useRoute();
const router = useRouter();

const message = ref("");
const success = ref(false);

const klientId = route.query.id;

console.log("klientId", klientId)


const submit = async () => {
  try {
    console.log("Te dhenat po dergohen", form, "appId", klientId);

    const response = await storeKlient(form);
    console.log("Përgjigja e plotë:", response);  // Logoni përgjigjen për të parë se çfarë po merrni

    if (response && response.result && response.result.id) {
  message.value = "Client created successfully!";
  success.value = true;
  const klientId = response.result.id;  // Nxjerr ID nga `result`
  console.log("ID klienti:", klientId);

  // Redirekto te faqja `createShitje` me ID-n e klientit
  router.push({ name: "CreateShitje", query: { id: klientId } });

} else {
  console.error("ID e klientit është munguar në përgjigje!");
}

  } catch (error) {
    message.value = "Error creating client.";
    success.value = false;
    console.error("Gabim:", error.response?.data || error.message);
  }
};

</script>

<template>
  <div class="py-12 min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-lg p-10 w-full max-w-lg">
      <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Register New Client</h1>
      <div v-if="message" :class="success ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
        class="p-3 rounded-md mb-4 text-center">
        {{ message }}
      </div>
      <form @submit.prevent="submit" class="space-y-5">
        <div v-for="(value, key) in form" :key="key">
          <label :for="key" class="block text-sm font-medium text-gray-700 capitalize">{{ key }}</label>
          <input :type="key === 'email' ? 'email' : 'text'" :id="key" v-model="form[key]" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>
        <button 
  @click="goToCreateShitjePage"
  class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow-md transition-all duration-200 ease-in-out ml-4">
  Add Client
</button>

      </form>
    </div>
  </div>
</template>