<template>
  <section id="about" class="py-16 bg-gradient-to-r from-blue-50 to-blue-100">
    <div class="container mx-auto px-6 text-center max-w-6xl">
      <!-- About QuickMed Section -->
      <div class="mb-12">
        <h2 class="text-4xl font-bold text-gray-800">
          About Us
        </h2>
        <p class="mt-4 text-lg leading-relaxed max-w-3xl mx-auto text-gray-700">
          At <span class="font-semibold text-blue-600">QuickMed</span>, we believe in making healthcare 
          <strong class="text-blue-700">fast, accessible, and hassle-free</strong>. Our platform connects patients with 
          trusted doctors, allowing seamless appointment booking and secure online payments.
        </p>
    
        <p class="mt-4 text-lg leading-relaxed max-w-3xl mx-auto text-gray-700">
          With over <strong class="text-blue-700">5 years of experience</strong> in the healthcare industry, QuickMed has successfully
          helped thousands of patients book appointments with top professionals. Our mission is to continue
          revolutionizing healthcare by providing innovative solutions and ensuring top-quality service.
        </p>
      </div>
      
      <!-- Image Section -->
      <div class="w-full flex justify-center">
        <img src="@/assets/doctors/10.webp" alt="About QuickMed" class="w-full max-w-5xl h-64 object-cover rounded-lg shadow-lg">
      </div>

      <!-- Gradient Bottom Wave -->
      <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 320">
        <defs>
          <linearGradient id="lightBlueGradient" x1="0" x2="1" y1="0" y2="0">
            <stop offset="0%" stop-color="#ebf8ff" />
            <stop offset="100%" stop-color="#e0f2fe" />
          </linearGradient>
        </defs>
        <path fill="url(#lightBlueGradient)" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,250.7C384,267,480,277,576,266.7C672,256,768,224,864,202.7C960,181,1056,171,1152,176C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>
  </section>
</template>

<script>
export default {};
</script>

<style scoped>
/* Custom styles if needed */
</style>
