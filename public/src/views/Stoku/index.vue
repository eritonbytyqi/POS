<script setup>
import { ref, onMounted } from 'vue';
import { getStock, updateStock } from '@/services/stoku.js'; 
import Spinner from "@/components/Spinner.vue";
import router from '@/router';

const stok = ref([]);
const showSpinner = ref(false);

const isEditing = ref(null);
const editedItem = ref({});

onMounted(() => {
  showSpinner.value = true;
  getStock()
    .then((data) => {
      stok.value = data.result.data || [];
    })
    .catch((error) => {
      console.error('Error fetching stock:', error);
    })
    .finally(() => {
      showSpinner.value = false;
    });
});

const startEditing = (item) => {
  isEditing.value = item.id;
  editedItem.value = { ...item };
};

const saveChanges = async (item) => {
  try {
    const response = await updateStock(item.id, editedItem.value);
    if (response.success) {
      const index = stok.value.findIndex(prod => prod.id === item.id);
      if (index !== -1) {
        stok.value[index] = { ...stok.value[index], ...editedItem.value };
      }
      isEditing.value = null;
    } else {
      console.error("Error saving data:", response.message);
    }
  } catch (error) {
    console.error('Error saving changes:', error);
  }
};

const cancelEditing = () => {
  isEditing.value = null;
};


const goToCreateStokPage = () => {
  router.push('/Create/stok');
};

</script>

<template>
  <Spinner v-if="showSpinner" />
  <div class="p-6 bg-gradient-to-b from-blue-50 to-blue-100 shadow-lg min-h-screen">

    <h1 class="text-4xl font-bold text-center text-black-600 mb-8">Stock Dashboard</h1>
    <div class="flex justify-end mb-4">
  <button 
    @click="goToCreateStokPage"
    class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow-md transition-all duration-200 ease-in-out">
    Add Stok
  </button>
</div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg"> 
      <table class="min-w-full table-auto">
        
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="px-6 py-4 text-left border-b font-medium">Produkt</th>
            <th class="px-6 py-4 text-left border-b font-medium">Sasia në Stok</th>
            <th class="px-6 py-4 text-left border-b font-medium">Çmimi i Blerjes</th>
            <th class="px-6 py-4 text-left border-b font-medium">Action</th>
          </tr>
          
        </thead>
        
        <tbody>
          <tr v-for="item in stok" :key="item.id" class="border-b hover:bg-gray-50">
            <td class="px-6 py-4" @dblclick="startEditing(item)">
              <template v-if="isEditing === item.id">
                <input type="text" v-model="editedItem.produkti_id" class="p-2 border border-gray-300 rounded-md" />
              </template>
              <template v-else>
                {{ item.produkti_id }}
              </template>
            </td>

            <td class="px-6 py-4" @dblclick="startEditing(item)">
              <template v-if="isEditing === item.id">
                <input type="number" v-model="editedItem.sasia" class="p-2 border border-gray-300 rounded-md" />
              </template>
              <template v-else>
                {{ item.sasia }}
              </template>
            </td>

            <td class="px-6 py-4" @dblclick="startEditing(item)">
              <template v-if="isEditing === item.id">
                <input type="number" v-model="editedItem.cmimi_blerjes" class="p-2 border border-gray-300 rounded-md" />
              </template>
              <template v-else>
                ${{ item.cmimi_blerjes }}
              </template>
            </td>

            <td class="px-6 py-4">
              <!-- Button për të nisur editimin -->
              <template v-if="isEditing !== item.id">
                <button @click="startEditing(item)"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                  Edit
                </button>
              </template>

              <!-- Button për të ruajtur ndryshimet -->
              <template v-if="isEditing === item.id">
                <button @click="saveChanges(editedItem)"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition-all duration-200">
                  Ruaj
                </button>
                <!-- Button për të anuluar editimin -->
                <button @click="cancelEditing"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition-all duration-200 ml-2">
                  Anulo
                </button>
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
