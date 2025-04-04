<template>
  <div class="w-64 min-h-screen bg-gradient-to-r from-blue-100 to-blue-10 fixed top-0 left-0">
    <div class="flex items-center space-x-4 mb-4 flex-col justify-end mt-10 mr-auto">
      <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="@/assets/logo/quickkk.png" class="h-12" alt="Flowbite Logo" />
        <span class="self-center text-3xl font-bold text-black">QuickMed</span>
      </a>
    </div>

    <ul class="space-y-4 mt-10">
      <li>
        <button @click="toggleProducts" class="flex items-center space-x-3 py-2 px-3 text-black rounded-md hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
          </svg>
          <span>Produktet</span>
        </button>

        <button @click="toggleAddFolder" class="ml-4 text-blue-500 hover:text-blue-700" v-if="isOpen">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </button>

        <ul v-if="isOpen" class="space-y-2 pl-6 mt-2">
          <li v-for="folder in folders" :key="folder.id" class="mb-2 p-2 rounded-lg cursor-pointer"
              @click="toggleSubfolders(folder)"
              :class="{'bg-blue-200': activeFolder === folder.id}"
              @contextmenu="openContextMenu($event, folder)">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2h-6l-2-2H10a2 2 0 00-2 2z" />
            </svg>

            <span v-if="!folder.isEditing" @dblclick="editFolder(folder)">{{ folder.name }}</span>
            <input v-else v-model="folder.name" @blur="saveFolderName(folder)" @keyup.enter="saveFolderName(folder)" class="border rounded p-1" autofocus />

            <button @click.stop="addSubfolder(folder)" class="ml-2 text-blue-500 hover:text-blue-700">+</button>

            <!-- Subfolders List -->
            <ul v-if="folder.isOpen" class="pl-4 mt-2">
              <li v-for="subfolder in folder.subfolders" :key="subfolder.id"
                  class="ml-6 p-3 rounded-md border border-gray-300 shadow-md hover:bg-gray-50 cursor-pointer transition-all ease-in-out duration-300"
                  @click.stop="toggleSubfolder(subfolder)"
                  :class="{'bg-blue-200': activeSubfolder === subfolder.id}">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2h-6l-2-2H10a2 2 0 00-2 2z" />
                </svg>

                <span v-if="!subfolder.isEditing" @dblclick="editSubfolder(subfolder)">{{ subfolder.name }}</span>
                <input v-else v-model="subfolder.name" @blur="saveSubfolderName(subfolder)" @keyup.enter="saveSubfolderName(subfolder)" class="border rounded p-1" autofocus />
              </li>
            </ul>

          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getFolders, getSubfolders, storeFolder, storeSubfolder, updateFolder } from '@/services/folders';

// State management
const isOpen = ref(false);
const folders = ref([]);
const activeFolder = ref(null);
const activeSubfolder = ref(null);
const isAddingFolder = ref(false);

// Toggle product section
const toggleProducts = () => {
  isOpen.value = !isOpen.value;
};

// Toggle folders
const toggleSubfolders = async (folder) => {
  if (!folder.isOpen) {
    try {
      const subfolderResponse = await getSubfolders(folder.id);
      folder.subfolders = subfolderResponse.result?.data.map(sub => ({ ...sub, isOpen: false })) || [];
    } catch (error) {
      console.error('Error fetching subfolders:', error);
    }
  }
  folder.isOpen = !folder.isOpen;
};

// Toggle subfolders individually
const toggleSubfolder = (subfolder) => {
  activeSubfolder.value = subfolder.id;
};

// Fetch folders
onMounted(() => {
  getFolders()
    .then((data) => {
      folders.value = data.result.data.map(folder => ({
        ...folder,
        isOpen: false,
        subfolders: [],
      }));
    })
    .catch((error) => {
      console.error('Error fetching folders:', error);
    });
});

// Add subfolder
const addSubfolder = (folder) => {
  const newSubfolderName = prompt("Shkruaj emrin e subfolderit:");
  if (newSubfolderName) {
    storeSubfolder(folder.id, newSubfolderName).then((newSubfolder) => {
      folder.subfolders.push({ ...newSubfolder, isOpen: false });
    });
  }
};

// Edit & Save Folder Name
const editFolder = (folder) => {
  folder.isEditing = true;
};
const saveFolderName = (folder) => {
  folder.isEditing = false;
  updateFolder(folder.id, folder.name).catch(error => console.error("Gabim gjatë përditësimit të emrit të folderit:", error));
};

// Edit & Save Subfolder Name
const editSubfolder = (subfolder) => {
  subfolder.isEditing = true;
};
const saveSubfolderName = (subfolder) => {
  subfolder.isEditing = false;
  updateFolder(subfolder.id, subfolder.name).catch(error => console.error("Gabim gjatë përditësimit të emrit të nën-folderit:", error));
};
</script>
