<script setup>
import { onMounted, reactive, ref } from "vue";
import { useRoute } from "vue-router";
import router from "@/router/index.js";
import Spinner from "@/components/Spinner.vue";
import { showProduct, updateProduct } from "@/services/products";
import { showKlient, updateKlient } from "@/services/klientet";

const route = useRoute();

const form = reactive({
  emri: "",
  mbiemri: "",
  telefoni: "",
  email: "",
  adresa: "",
  qyteti: "",
});

const showSpinner = ref(false);
const message = ref("");
const success = ref(false);

const submit = async () => {
    
  try {
    const response = await updateKlient(route.params.id, form);
    if (response) {
      message.value = "Doctor updated successfully!";
      success.value = true;
      router.push({ name: "klientet" }); 
    }
  } catch (error) {
    message.value = "Error updating doctor.";
    success.value = false;
    console.error("Error:", error);
  }
};

onMounted(() => {

    console.log("Route params onMounted:", route.params); 
  console.log("Doctor ID onMounted:", route.params.id);

  showSpinner.value = true;
  showKlient(route.params.id)
    .then(res => {
      console.log("Response from showDoctor:", res);

      if (res && res.result) {
        Object.assign(form, res.result);
      }
    })
    .finally(() => {
      showSpinner.value = false;
    });
});



</script>

<template>
  <Spinner v-if="showSpinner"/>
  <div class="py-10 min-h-screen bg-gray-100 flex justify-center items-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Doctor</h1>

      <div v-if="message" :class="success ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
           class="p-3 rounded-md mb-4">
        {{ message }}
      </div>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="emri" class="block text-sm font-medium text-gray-700">Emri:</label>
          <input type="text" id="emri" v-model="form.emri" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="mbiemri" class="block text-sm font-medium text-gray-700">Mbiemri:</label>
          <input type="text" id="mbiemri" v-model="form.mbiemri" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="telefoni" class="block text-sm font-medium text-gray-700">Telefoni:</label>
          <input type="text" id="telefoni" v-model="form.telefoni" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
          <input type="email" id="email" v-model="form.email" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="adresa" class="block text-sm font-medium text-gray-700">Adresa:</label>
          <input type="text" id="adresa" v-model="form.adresa" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <div>
          <label for="qyteti" class="block text-sm font-medium text-gray-700">Qyteti:</label>
          <input type="text" id="qyteti" v-model="form.qyteti" required
                 class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"/>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md">
          Save
        </button>
      </form>
    </div>
  </div>
</template>
