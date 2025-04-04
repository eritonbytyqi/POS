<template>
  <section id="departments" class="py-16 bg-gradient-to-r from-blue-50 to-blue-100">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold text-gray-800">Our Medical Departments</h2>
      <p class="text-lg text-gray-700 mt-4 max-w-2xl mx-auto">
        We offer specialized medical services with expert doctors committed to delivering high-quality healthcare.
      </p>

      <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="department in departments"
          :key="department.name"
          class="flex flex-col items-center text-center p-6 bg-white shadow-lg rounded-xl transition transform hover:scale-105 w-80 h-60 mx-auto"
        >
          <div class="w-20 h-20 bg-blue-100 flex items-center justify-center rounded-full">
            <span class="text-4xl text-blue-700">{{ department.icon }}</span>
          </div>
          <h3 class="text-xl font-semibold text-blue-700 mt-4">{{ department.name }}</h3>
          <p class="text-gray-600 mt-2">
            {{ department.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const departments = [
  { name: "Cardiology", icon: "❤️", description: "Heart diseases, ECGs, and expert cardiac care." },
  { name: "Neurology", icon: "🧠", description: "Treatment for strokes, epilepsy, and migraines." },
  { name: "Pediatrics", icon: "👶", description: "Medical care for infants, children, and adolescents." },
  { name: "Orthopedics", icon: "🦴", description: "Bone fractures, joint injuries, and mobility treatments." },
  { name: "General Medicine", icon: "🩺", description: "Routine checkups, disease management, and healthcare." },
  { name: "Ophthalmology", icon: "👁️", description: "Vision correction, eye diseases, and cataract surgeries." },
];
</script>
