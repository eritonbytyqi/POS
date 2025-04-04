<script setup>
import doctorhome from '@/assets/home/doctorhome.jpg';
</script>

<template>
  <section 
    class="relative h-[650px] w-full flex items-center text-white"
    :style="{ backgroundImage: `url(${doctorhome})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
    
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/60 to-blue-400/50"></div>
    
    <div class="container mx-auto px-8 lg:px-20 text-left relative z-10">
      <h2 class="text-5xl font-bold text-white leading-tight">
        YOUR HEALTH IS OUR TOP PRIORITY      </h2>
      <p class="text-lg mt-4 max-w-3xl text-white/90 leading-relaxed">
        Your trusted platform for booking medical appointments, managing doctors, and more.      </p>
      <router-link 
        to="landing/BookAppointment" 
        class="mt-6 inline-block bg-white text-blue-600 px-8 py-4 rounded-lg shadow-lg hover:bg-gray-200 transition">
        Book Appointment
      </router-link>
    </div>    
    
    <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 320">
  <defs>
    <linearGradient id="lightBlueGradient" x1="0" x2="1" y1="0" y2="0">
      <stop offset="0%" stop-color="#ebf8ff" /> 
      <stop offset="100%" stop-color="#e0f2fe" /> 
    </linearGradient>
  </defs>
  <path fill="url(#lightBlueGradient)" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,250.7C384,267,480,277,576,266.7C672,256,768,224,864,202.7C960,181,1056,171,1152,176C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
</svg>

  </section>
  
</template>