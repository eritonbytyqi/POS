<template>
  <div
    class="w-full md:w-96 min-h-screen bg-gradient-to-r from-gray-800 to-gray-900 text-white fixed top-0 left-0"
    @click="clearActiveFolder"
  >
    <!-- LISTA E FOLDERS -->
    <ul v-if="folders.length" class="space-y-2 pl-6 mt-2">
      <li v-for="folder in folders" :key="folder.id"
          class="mb-2 p-2 rounded-lg cursor-pointer relative"
          @click="handleFolderClick(folder)" 
          :class="{'opacity-75': activeFolder === folder.id}" 
          @contextmenu.prevent="openContextMenu($event, folder)">

        <!-- Ikona e Folderit -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block mr-2" viewBox="0 0 24 24" fill="#C4C4C4">
          <path d="M3 5a2 2 0 0 1 2-2h6l2 2h6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5z"/>
        </svg>

        <!-- Emri i folderit -->
        <span v-if="!folder.isEditing" @dblclick="editFolder(folder)">{{ folder.name }}</span>
        <input v-else v-model="folder.name" @blur="saveFolderName(folder)" @keyup.enter="saveFolderName(folder)" class="border rounded p-1 bg-gray-100 text-black" autofocus />

      </li>
    </ul>

    <!-- ✅ CONTEXT MENU -->
    <div v-if="showContextMenu"
         :style="{ top: contextMenuY + 'px', left: contextMenuX + 'px' }"
         class="absolute bg-white shadow-lg rounded-md p-2 w-40 z-50">
      <button @click="editFolder(selectedFolder)" class="block w-full text-left p-2 hover:bg-gray-200">✏️ Redakto</button>
      <button @click="confirmDeleteFolder(selectedFolder)" class="block w-full text-left p-2 text-red-600 hover:bg-red-200">🗑️ Fshij</button>
      <button @click="addSubfolder(selectedFolder)" class="block w-full text-left p-2 hover:bg-blue-200">➕ Shto Nën-Folder</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getFolders, storeSubfolder, updateFolder, deleteFolder } from '@/services/folders';

const folders = ref([]);
const activeFolder = ref(null);
const selectedFolder = ref(null);

// Për context menu
const showContextMenu = ref(false);
const contextMenuX = ref(0);
const contextMenuY = ref(0);

// Funksioni për të hapur context menu
const openContextMenu = (event, folder) => {
  selectedFolder.value = folder;
  contextMenuX.value = event.clientX;
  contextMenuY.value = event.clientY;
  showContextMenu.value = true;
};

// Funksioni për të mbyllur context menu
const closeContextMenu = () => {
  showContextMenu.value = false;
};

// Funksioni për të redaktuar një folder
const editFolder = (folder) => {
  folder.isEditing = true;
  closeContextMenu();
};

// Funksioni për të ruajtur ndryshimin e emrit të folderit
const saveFolderName = async (folder) => {
  folder.isEditing = false;
  try {
    await updateFolder(folder.id, folder.name);
  } catch (error) {
    console.error("Gabim gjatë përditësimit të emrit të folderit:", error);
  }
};

// Funksioni për të shtuar një nën-folder
const addSubfolder = async (folder) => {
  const newSubfolderName = prompt("Shkruaj emrin e nën-folderit:");
  if (!newSubfolderName) return;

  try {
    const newSubfolder = await storeSubfolder(folder.id, newSubfolderName);
    folder.subfolders = folder.subfolders || [];
    folder.subfolders.push(newSubfolder);
  } catch (error) {
    console.error("Gabim gjatë krijimit të nën-folderit:", error);
  }

  closeContextMenu();
};

// Funksioni për të fshirë një folder me konfirmim
const confirmDeleteFolder = async (folder) => {
  if (!folder || !folder.id) return;

  if (!confirm(`A jeni i sigurt që doni të fshini folderin: "${folder.name}"?`)) return;

  try {
    await deleteFolder(folder.id); // Fshije nga backend-i
    folders.value = folders.value.filter(f => f.id !== folder.id); // Përditëso frontend
    showContextMenu.value = false;
  } catch (error) {
    console.error("Gabim gjatë fshirjes së folderit:", error);
  }
};

// Funksioni për të marrë listën e foldereve nga backend
onMounted(async () => {
  try {
    const response = await getFolders();
    folders.value = response.result.data.map(folder => ({
      ...folder,
      isEditing: false,
      isOpen: false,
      subfolders: folder.subfolders || [],
    }));
  } catch (error) {
    console.error("Gabim gjatë marrjes së folderave:", error);
  }
});

// Mbyll context menu nëse klikohet jashtë tij
document.addEventListener('click', closeContextMenu);
</script>
