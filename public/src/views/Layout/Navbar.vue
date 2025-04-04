<template>
  <nav>
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        
        <div class="relative ml-auto">
          <button 
            class="flex items-center space-x-2 px-4 py-2 bg-gray-700 text-white rounded-md shadow-md "
      @click="toggleDropdown"
          >
            <span>Admin</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
      
          </button>
  
          <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
            <ul class="py-1 text-gray-700">
             
              <li>
<button @click="logoutAndRedirect" class="py-2 px-4 text-indigo-600 text-sm rounded-md hover:text-indigo-700">
  Sign Out
</button>

           </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup>

import { useRouter } from 'vue-router'; // Import Vue Router
import {ref} from 'vue'
const router = useRouter();

// State to control the dropdown
let isDropdownOpen = ref(false);

// Function to toggle the dropdown
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};




</script>

  
  <style scoped>
  /* Profile Dropdown adjustments */
  .relative {
    position: relative;
  }
  
  .absolute {
    position: absolute;
  }
  
  .right-0 {
    right: 0;
  }
  
  .ml-auto {
    margin-left: auto; /* Aligns profile dropdown to the right */
  }
  
  /* Ensure dropdown stays hidden when isDropdownOpen is false */
  </style>

  