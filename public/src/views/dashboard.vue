<template>
    <div class="dashboard-container">
      <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <div class="folders">
          <h3>Folders</h3>
          <ul>
            <li v-for="folder in folders" :key="folder.id" @click="selectFolder(folder)">
              {{ folder.name }}
            </li>
          </ul>
        </div>
      </div>
      <div class="main-content">
        <h2 v-if="selectedFolder">Products for: {{ selectedFolder.name }}</h2>
        <div v-if="selectedFolder" class="product-list">
          <div v-for="product in products" :key="product.id" class="product-card">
            <h4>{{ product.name }}</h4>
            <p>{{ product.description }}</p>
          </div>
        </div>
        <div v-if="!selectedFolder">
          <p>Select a folder to view products.</p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const folders = ref([]);
  const products = ref([]);
  const selectedFolder = ref(null);
  
  // Simulimi i të dhënave të folderave dhe produkteve
  onMounted(() => {
    folders.value = [
      { id: 1, name: 'Folder 1' },
      { id: 2, name: 'Folder 2' },
      { id: 3, name: 'Folder 3' },
    ];
  });
  
  // Simulimi i produkteve për çdo folder
  const fetchProducts = (folderId) => {
    const allProducts = [
      { id: 1, name: 'Product 1', description: 'Description for Product 1', folderId: 1 },
      { id: 2, name: 'Product 2', description: 'Description for Product 2', folderId: 1 },
      { id: 3, name: 'Product 3', description: 'Description for Product 3', folderId: 2 },
      { id: 4, name: 'Product 4', description: 'Description for Product 4', folderId: 2 },
      { id: 5, name: 'Product 5', description: 'Description for Product 5', folderId: 3 },
    ];
  
    products.value = allProducts.filter((product) => product.folderId === folderId);
  };
  
  const selectFolder = (folder) => {
    selectedFolder.value = folder;
    fetchProducts(folder.id); // Merr produktet për këtë folder
  };
  </script>
  
  <style scoped>
  .dashboard-container {
    display: flex;
    min-height: 100vh;
  }
  
  .sidebar {
    width: 250px;
    background-color: #333;
    color: white;
    padding: 20px;
  }
  
  .sidebar h2 {
    color: #fff;
    margin-bottom: 20px;
  }
  
  .folders {
    margin-top: 20px;
  }
  
  .folders ul {
    list-style-type: none;
    padding-left: 0;
  }
  
  .folders li {
    padding: 10px;
    background-color: #444;
    margin: 5px 0;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .folders li:hover {
    background-color: #555;
  }
  
  .main-content {
    flex: 1;
    padding: 20px;
    background-color: #f4f4f4;
  }
  
  .product-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  
  .product-card {
    background-color: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .product-card h4 {
    margin-bottom: 10px;
    color: #333;
  }
  
  .product-card p {
    color: #555;
  }
  
  h2 {
    color: #333;
  }
  </style>
  