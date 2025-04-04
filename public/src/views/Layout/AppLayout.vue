<template>
  <!-- Main container -->
  <div class="flex  min-h-screen bg-green-100">
    <!-- Sidebar -->
    <Sidebar class="fixed w-[360px] h-screen bg-green-800 text-white" />

    <!-- Main content area -->
    <div class="flex-1 p-4 ml-64 bg-green-50">
      <!-- Topbar with Profile -->
      <Navbar />

      <!-- Content area for dynamic content -->
      <div class="max-w-6xl mx-auto">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar.vue';  // Import Sidebar component
import Navbar from './Navbar.vue';    // Import Navbar component
import { useNotification } from '@kyvg/vue3-notification';  // Import useNotification hook
import { watchEffect } from "vue";

const { notify } = useNotification();  // Inicializoni notify për të përdorur notifikimet

export default {
  name: "MainLayout",
  components: {
    Sidebar,   // Register Sidebar component
    Navbar,    // Register Navbar component
  },
};
</script>

<style scoped>
/* Apply background color for the entire page */
html, body {
  height: 100%; /* Ensure that the page takes full height */
  margin: 0;    /* Remove default margin */
  padding: 0;   /* Ensure no padding on body */
  background-color: #1a202c; /* Dark background for the whole page */
  border: none; /* Ensure there's no border */
}

/* Layout main container with custom green background */
.flex {
  display: flex;
}

.bg-green-100 {
  background-color: #d4f8e8;  /* Light green background */
}

/* Sidebar styling */
.fixed {
  position: fixed;
}

.w-64 {
  width: 16rem;
}

.h-screen {
  height: 100vh;
}

.bg-green-800 {
  background-color: #2f855a;  /* Dark green for sidebar */
}

.text-white {
  color: white;
}

/* Main content area */
.flex-1 {
  flex: 1;
}

.ml-64 {
  margin-left: 16rem; /* Leave space for the sidebar */
}

.bg-green-50 {
  background-color: #f0fdf4; /* Light green background for content */
}

/* Navbar and content container */
.max-w-6xl {
  max-width: 72rem;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.p-4 {
  padding: 1rem;
}
</style>
