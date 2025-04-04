<template>
<div class="w-94 min-h-screen bg-gradient-to-r from-gray-800 to-gray-900 text-white fixed top-0 left-0" @click="clearActiveFolder">





  <button
  @click="toggleAddFolder"
  class="ml-4 pt-3 text-blue-500 hover:text-blue-700"
  v-if="isOpen"
>
  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path d="M3 5a2 2 0 0 1 2-2h6l2 2h6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5z"/>
    <g transform="translate(14, 2)">
      <path d="M2 0v4M0 2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </g>
  </svg>
</button>

    <ul class="space-y-4 mt-10">
 

      <ul class="space-y-4 ml-5 mt-10">
  <li>
    <RouterLink :to="{ name: 'shitjet'}" class="flex items-center space-x-3 py-2 px-3 text-white rounded-md hover:text-blue-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
</svg>

   <span>Sales</span>
    </RouterLink>
  </li> 

  <li>
    <RouterLink :to="{ name: 'klientet'}" class="flex items-center space-x-3 py-2 px-3 text-white rounded-md hover:text-blue-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
</svg>

      <span>Klientet</span>

    </RouterLink>
  </li>

  <li>
    <RouterLink :to="{ name: 'stoku'}" class="flex items-center space-x-3 py-2 px-3 text-white rounded-md hover:text-blue-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
</svg>

      <span>Stoku</span>

    </RouterLink>
  </li>
</ul>


      <li>
           <button @click="toggleProducts" class="flex items-center space-x-3 py-2 px-3 text-white rounded-md hover:text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-transform"
              :class="{ 'rotate-180': isOpen }">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
            </svg>
            <span>Produktet</span>
          </button>
         <!-- Ndrysho butonat në context menu për të përdorur funksionet aktuale -->
         <div v-if="showContextMenu"
     :style="{ top: contextMenuY + 'px', left: contextMenuX + 'px' }"
     class="absolute bg-black text-black shadow-lg rounded-md p-2 w-40 z-50 context-menu" style="background-color: aquamarine !important; color: white !important;">
  <!-- <button @click="editfolder(activeFolder)" class="block w-full text-left p-2 hover:bg-gray-200  text-black hover:text-black">✏️ Redakto</button> -->
  <button @click="confirmDeleteFolder" class="block w-full text-left p-2 text-red-600 hover:bg-red-200">🗑️ Fshij</button>
  <button @click="confirmDeleteSubfolder" class="block w-full text-left p-2 text-red-600 hover:bg-red-200">🗑️ Fshij Subfolder</button>
  <!-- <button @click="addSubfolder(activeFolder)" class="block w-full text-left p-2 hover:bg-blue-200 hover:text-black">➕ Shto Nën-Folder</button> -->
</div>





        <ul v-if="isOpen" class="space-y-2 pl-6 mt-2">
          <li v-for="folder in folders" :key="folder.id" class="mb-2 p-2 rounded-lg cursor-pointer"
          @click.stop="getSubfoldersRecursively(folder)"
          
            @click="handleFolderClick(folder)" 
            :class="{'opacity-75': activeFolder === folder.id} "
            @contextmenu="openContextMenu($event, folder)">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="#C4C4C4">
  <path d="M3 5a2 2 0 0 1 2-2h6l2 2h6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5z"/>
</svg>
            <span v-if="!folder.isEditing"  @dblclick="editfolder(folder)" class="folder-name"> {{ folder.name }} </span>
            <input v-else v-model="folder.name" @blur="saveFolderName(folder)" @keyup.enter="saveFolderName(folder)" class=" bg-gray  text-black border rounded p-1 "  autofocus  />
            <button @click.stop="addSubfolder(folder)" class="ml-2 text-blue-500 hover:text-blue-700">+</button>
            <div v-if="folder.isOpen">
              <ul>
    <li v-for="subfolder in folder.subfolders" :key="subfolder.id"
        class="ml-4 py-1 px-2 rounded border border-gray-200 shadow-sm cursor-pointer transition-all ease-in-out duration-200"
        @click.stop="handleSubfolderClick(subfolder)"  
        @dblclick="editSubfolder(subfolder)"
        :class="{'bg-blue-200': activeSubfolder === subfolder.id}">
      <router-link v-if="!subfolder.isEditing" 
                   :to="'/folder/' + folder.id + '/subfolder/' + subfolder.id" 
                   class="flex items-center space-x-3 py-2 px-3 text-white rounded-md hover:text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="#C4C4C4">
          <path d="M3 5a2 2 0 0 1 2-2h6l2 2h6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5z"/>
        </svg>
        <span>{{ subfolder.name }}</span>
      </router-link>
      <input v-if="subfolder.isEditing" 
             v-model="subfolder.name" 
             @blur="saveSubfolderName(subfolder)" 
             @keyup.enter="saveSubfolderName(subfolder)" 
             class=" bg-gray  text-black border rounded p-1 "
             autofocus />
    </li>
  </ul>

              <div v-if="products.length > 0" class="mt-4">
  <h3 class="text-lg font-semibold">Produkte në këtë folder:</h3>
  <ul>
    <li v-for="product in products" :key="product.id" class="py-2 px-4 border-b">
      <span>{{ product.name }}</span>
    </li>
  </ul>
</div>
            </div>
          </li>
        </ul>
      </li>
    </ul>

    <div v-if="isAddingFolder" class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 shadow-2xl rounded-lg p-6 w-80 transition-all duration-300">
      <button @click="isAddingFolder = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Shto një folder</h2>
      <input 
        v-model="newFolderName" 
        type="text" 
        placeholder="Emri i folderit..." 
        class="p-2 text-gray-900 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3"
      />
      <button 
        @click="addFolderAndSubmit" 
        class="w-full p-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition-all duration-300"
      >
        Shto Folder
      </button>
    </div>

  </div>
</template>
<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue';
import { deleteFolder, deleteSubfolder, fetchFolderProducts, fetchProducts, getFolders, getSubfolders, storeFolder, storeSubfolder, updateFolder } from '@/services/folders'; 
import { useRoute } from 'vue-router';

// State for managing whether the product section is open
const isOpen = ref(false);

const folders = ref([]);
const products = ref([]);
const route = useRoute();
const newFolderName = ref('');
const isAddingFolder = ref(false);
const showSpinner = ref(false);

const noProductsMessage = ref('Zgjidh një folder që përmban produkte për t\'i parë.'); // Deklarimi i mesazhit

// Funksioni për të çaktivizuar folderin kur klikohet jashtë
const clearActiveFolder = () => {
  activeFolder.value = null;
};
const toggleProducts = () => {
  isOpen.value = !isOpen.value;
};

const addFolderAndSubmit = () => {
  if (newFolderName.value.trim() === "") {
    alert("Folder name cannot be empty");
    return;
  }

  storeFolder(newFolderName.value)
    .then((newFolder) => {
      folders.value.push(newFolder);
      newFolderName.value = '';  // Pastro fushën e input-it
      isAddingFolder.value = false;  // Mbylle modalin
    })
    .catch((error) => {
      console.error("Error adding folder:", error);
    });
};

// Funksioni për të aktivizuar modalin e shtimit të folderit
const toggleAddFolder = () => {
  isAddingFolder.value = !isAddingFolder.value;
};
// Fetch folders from the API
// onMounted(() => {
//   getFolders()
//     .then((data) => {
//       folders.value = data.result.data.map(folder => ({
//         ...folder,
//         isOpen: false,
//         subfolders: folder.subfolders || [],
//       }));
//     })
//     .catch((error) => {
//       console.error('Error fetching folders:', error);
//     });
// });

// Placeholder function for selecting a folder (you can add your logic for this)
const selectedFolder = (folder) => {
  console.log('Selected folder:', folder);
};

const getSubfoldersRecursively = async (folderId) => {
  try {
    const subfolderResponse = await getSubfolders(folderId); // Merr subfolderët për këtë folder
    const subfolders = subfolderResponse.result?.data || [];

    // Merr subfolderët e subfolderëve në mënyrë rekursive
    for (const subfolder of subfolders) {
      subfolder.subfolders = await getSubfoldersRecursively(subfolder.id); 
    }

    return subfolders;
  } catch (error) {
    console.error('Gabim gjatë marrjes së subfolderëve rekursivisht:', error);
    return [];
  }
};

// Merr të gjitha folderët dhe subfolderët kur komponenti ngarkohet
onMounted(async () => {
  try {
    const folderResponse = await getFolders(); // Merr folderët nga API
    const fetchedFolders = folderResponse.result?.data || [];

    // Për çdo folder, merr subfolderët e tij në mënyrë rekursive
    for (const folder of fetchedFolders) {
      folder.subfolders = await getSubfoldersRecursively(folder.id);
    }

    folders.value = fetchedFolders; // Ruaj folderët me subfolderët përkatës
  } catch (error) {
    console.error('Gabim gjatë marrjes së folderëve:', error);
  }
});

// Funksioni për të hapur dhe mbyllur folderët
const toggleFolder = (folder) => {
  folder.isOpen = !folder.isOpen; // Ndrysho gjendjen e hapjes/mbylljes së folderit
  
  if (folder.isOpen && folder.subfolders.length === 0) {
    // Nëse folderi është hapur por nuk ka subfolderë të ngarkuar, merr subfolderët
    getSubfoldersRecursively(folder.id).then((subfolders) => {
      folder.subfolders = subfolders; // Ruaj subfolderët në folder
    });
  }
};

// Funksioni për të menaxhuar klikimin në një folder
const handleFolderClick = (folder) => {
  activeFolder.value = folder.id; // Cakto folderin aktiv
  activeSubfolder.value = null;   // Çaktivizo çdo subfolder të zgjedhur
  toggleFolder(folder);           // Hap ose mbyll folderin
};

// Funksioni për të menaxhuar klikimin në një subfolder
const handleSubfolderClick = (subfolder) => {
  activeSubfolder.value = subfolder.id; // Cakto subfolderin aktiv
};
// Toggle the subfolder display (optional, if you want to toggle visibility within subfolders)
const toggleSubfolder = (subfolder) => {
  activeSubfolder.value = subfolder.id; // Set the active subfolder
};
// const toggleSubfolders = async (folder) => {
//   // Nëse folderi është mbyllur dhe nuk ka subfolderë, bëj një kërkesë për t'i marrë subfolderët
//   if (!folder.isOpen && folder.subfolders.length === 0) {
//     try {
//       // Kërko subfolderët rekurzivisht për këtë folder
//       folder.subfolders = await getAllFoldersAndSubfolders(folder.id);
//     } catch (error) {
//       console.error('Error fetching subfolders:', error);
//     }
//   }
  
//   // Ndrysho gjendjen e hapjes për këtë folder
//   folder.isOpen = !folder.isOpen;
// };


// const fetchSubfolderProducts = async (subfolderId) => {
//   try {
//     showSpinner.value = true;
//     const response = await fetchProducts(subfolderId);
//     products.value = response.length > 0 ? response : [];
//     noProductsMessage.value = response.length > 0 ? '' : 'Nuk ka produkte në këtë subfolder.';
//   } catch (error) {
//     console.error('Gabim gjatë marrjes së produkteve për subfolder:', error);
//     noProductsMessage.value = 'Gabim gjatë marrjes së produkteve.';
//   } finally {
//     showSpinner.value = false;
//   }
// };

// Pasi që komponenti është instaluar, merret subfolderId nga URL dhe bëhet kërkesa për produktet
// onMounted(() => {
//   const subfolderId = route.params.subfolderId;
//   if (subfolderId) {
//     fetchSubfolderProducts(subfolderId);

//     const folderId = route.params.folderId;
//   if (folderId) {
//     fetchfolderProducts(folderId);
//   }
// }
// });
// Në script setup
 // Ruajmë ID-në e folderit aktiv
const activeSubfolder = ref(null); // Ruajmë ID-në e subfolderit aktiv
const activefolder = ref(null);



watch(() => route.params.folderId, (newFolderId) => {
  fetchFolderProducts(newFolderId);
  });
// Function to fetch subfolder products


const fetchfolderProducts = async (folder) => {
  try {
    const response = await fetchfolderProducts(folder.id);
    if (response.length === 0) {
      products.value = [];
      noProductsMessage.value = 'Nuk ka produkte në këtë folder.';
    } else {
      products.value = response;
      noProductsMessage.value = ''; // Pastro mesazhin nëse ka produkte
    }
  } catch (error) {
    console.error("Gabim gjatë marrjes së produkteve:", error);
    noProductsMessage.value = 'Ndodhi një gabim gjatë marrjes së produkteve.';
  }
};

// Function to add a subfolder
const addSubfolder = (folder) => {
  if (!folder) {
    console.error('Folderi nuk është i vlefshëm');
    return;  // Kthehet nëse folderi është null ose undefined
  }

  const newSubfolderName = prompt("Shkruaj emrin e subfolderit:");
  if (newSubfolderName) {
    storeSubfolder(folder.id, newSubfolderName).then((newSubfolder) => {
      folder.subfolders.push(newSubfolder);
    });
  }
};

const showContextMenu = ref(false);
const contextMenuX = ref(0);
const contextMenuY = ref(0);
const activeFolder = ref(null);

// Funksioni për të hapur context menu
// Funksioni për të hapur context menu
const openContextMenu = (event, folder) => {
  event.preventDefault();
  // Kur hapet menuja, vendosim folderin ose subfolderin aktiv
  if (folder.subfolders) {
    activeFolder.value = folder.id; // Kjo do të jetë folderi
    activeSubfolder.value = null;   // Pasi që jemi në nivelin e folderit
  } else {
    activeFolder.value = null;      // Nëse është subfolder, e lëmë folderin null
    activeSubfolder.value = folder.id; // Vendosim subfolderin aktiv
  }

  // Vendosim pozicionin për context menu
  contextMenuX.value = event.clientX;
  contextMenuY.value = event.clientY;
  showContextMenu.value = true; // Shfaqim menuen kontekstuale
};

const saveFolderName = (folder) => {
  folder.isEditing = false;
  updateFolder(folder.id, folder.name).catch(error => {
    console.error("Gabim gjatë përditësimit të emrit të folderit:", error);
  });
};


const editSubfolder = (subfolder) => {
  subfolder.isEditing = true;
};

const editfolder = (folder) => {
  folder.isEditing = true;
};
const saveSubfolderName = (subfolder) => {
  subfolder.isEditing = false;
  updateFolder(subfolder.id, subfolder.name).catch(error => {
    console.error("Gabim gjatë përditësimit të emrit të nën-folderit:", error);
  });
};
const savefolderName = (folder) => {
  folder.isEditing = false;
  updateFolder(folder.id, folder.name).catch(error => {
    console.error("Gabim gjatë përditësimit të emrit të nën-folderit:", error);
  });
};

const confirmDeleteFolder = async () => {
  const folderToDelete = folders.value.find(folder => folder.id === activeFolder.value);

  if (!folderToDelete) {
    console.error('Nuk është zgjedhur asnjë folder');
    return;
  }

  // Konfirmimi i fshirjes
  if (!confirm(`A jeni i sigurt që doni ta fshini këtë folder?`)) return;

  try {
    const result = await deleteFolder(folderToDelete.id);
    if (result) {
      // Fshi folderin nga struktura e të dhënave lokale
      folders.value = folders.value.filter(folder => folder.id !== folderToDelete.id);
      alert('Folder u fshi me sukses!');

      // Ridrejto te folderi kryesor pas fshirjes
      window.location.replace('/folders');  // Kthehuni në URL e duhur për folderin kryesor
    }
  } catch (error) {
    console.error('Gabim gjatë fshirjes së folderit:', error);
  }
};

const confirmDeleteSubfolder = async () => {
  const subfolderToDelete = folders.value
    .flatMap(folder => folder.subfolders)
    .find(subfolder => subfolder.id === activeSubfolder.value);

  if (!subfolderToDelete) {
    console.error('Nuk është zgjedhur asnjë subfolder');
    return;
  }

  // Konfirmimi i fshirjes
  if (!confirm(`A jeni i sigurt që doni ta fshini këtë subfolder?`)) return;

  try {
    const result = await deleteSubfolder(subfolderToDelete.id);
    if (result) {
      // Fshi subfolderin nga struktura e të dhënave lokale
      const folder = folders.value.find(folder => folder.id === subfolderToDelete.folderId);

      // Sigurohu që folderi është i pranishëm dhe ka subfolders
      if (folder && folder.subfolders) {
        folder.subfolders = folder.subfolders.filter(subfolder => subfolder.id !== subfolderToDelete.id);
      } else {
        console.error('Folderi nuk është i gjetur ose nuk ka subfoldera');
      }

      alert('Subfolder u fshi me sukses!');

      // Ridrejto te folderi kryesor pas fshirjes
      window.location.replace('/folders');  // Kthehuni në URL e duhur për folderin kryesor
    }
  } catch (error) {
    console.error('Gabim gjatë fshirjes së subfolderit:', error);
  }
};

const deletedFolders = ref([]);  // For storing deleted folders
const deletedSubfolders = ref([]);  // For storing deleted subfolders

const undoDeleteFolder = () => {
  if (deletedFolders.value.length > 0) {
    const lastDeletedFolder = deletedFolders.value.pop();
    folders.value.push(lastDeletedFolder);
    alert('Folder është rikthyer!');
  }
};

// Undo delete subfolder
const undoDeleteSubfolder = () => {
  if (deletedSubfolders.value.length > 0) {
    const lastDeletedSubfolder = deletedSubfolders.value.pop();
    const folder = folders.value.find(f => f.id === lastDeletedSubfolder.folderId);
    folder.subfolders.push(lastDeletedSubfolder);
    alert('Subfolder është rikthyer!');
  }
};


const handleUndoShortcut = (event) => {
  if (event.ctrlKey && event.key === 'z') {
    event.preventDefault();
    if (activeSubfolder.value) {
      undoDeleteSubfolder();
    } else if (activeFolder.value) {
      undoDeleteFolder();
    }
  }
};
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});

const handleClickOutside = (event) => {
  const contextMenuElement = document.querySelector('.context-menu');
  if (contextMenuElement && !contextMenuElement.contains(event.target)) {
    showContextMenu.value = false;
  }
};
const reloadPage = () => {
  window.location.reload(); // Ky funksion do të rifreskojë faqen
};

</script>
<style scoped>
.context-menu {
  position: absolute;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  padding: 10px;
  border-radius: 8px;
  z-index: 9999; /* Sigurohu që është më e lartë se elementët e tjerë */
}



.folder-name {
  cursor: pointer;
}

.edit-input {
  background-color: black; /* Background i zi */
  color: white; /* Teksti i bardhë */
  padding: 5px;
  border: none;
  border-radius: 4px;
}

.folder-name.editing {
  background-color: black;
  color: white;
}

</style>
