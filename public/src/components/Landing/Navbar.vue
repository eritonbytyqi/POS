<template>
  <nav class="bg-gradient-to-r from-blue-600/60 to-blue-400/50 p-4">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo + Text -->
      <div class="flex items-center space-x-2">
        <img src="@/assets/logo/quickkk.png" alt="QuickMed Logo" class="w-11 h-11 animate-pulse"> <!-- Pulsating logo -->
        <span class="text-white font-bold text-lg">QuickMed</span>
      </div>

      <!-- Navbar Links -->
      <div class="space-x-4">
        <a href="#home" class="text-white hover:text-gray-200 transition">Home</a>
        <a href="#about" class="text-white hover:text-gray-200 transition">About</a>
        <a href="#departments" class="text-white hover:text-gray-200 transition">Departments</a>
        <a href="#blog" class="text-white hover:text-gray-200 transition">Blog</a>
        <a href="#doctors" class="text-white hover:text-gray-200 transition">Doctors</a>
        <a href="#contactus" class="text-white hover:text-gray-200 transition">Contact Us</a>

        <!-- Management Link moved up -->
        <router-link 
          to="/login" 
          class="mt-2 inline-block bg-white text-blue-600 px-4 py-2 rounded-lg shadow-lg hover:bg-gray-200 transition">
          Management
        </router-link>
      </div>
    </div>
  </nav>
</template>

<style scoped>
/* Pulsating animation */
@keyframes pulseAnimation {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}

.animate-pulse {
  animation: pulseAnimation 1.5s ease-in-out infinite;
}
</style>
