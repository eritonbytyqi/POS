<script setup>
import { ref } from 'vue';

const doctors = ref([
  {
    id: 1,
    name: "Dr. John Carter",
    specialty: "Cardiologist",
    image: new URL('@/assets/doctors/1.jpg', import.meta.url).href,
    shortDesc: "A leading cardiologist with 15+ years of experience.",
    fullDesc: "A leading cardiologist with 15+ years of experience in treating heart diseases, performing angioplasty, and managing hypertension.",
    expanded: false
  },
  {
    id: 2,
    name: "Dr. Daniel Martinez",
    specialty: "Neurologist",
    image: new URL('@/assets/doctors/2.jpg', import.meta.url).href,
    shortDesc: "A highly skilled neurologist specializing in stroke management.",
    fullDesc: "A highly skilled neurologist specializing in stroke management, epilepsy treatment, and advanced neurodiagnostics.",
    expanded: false
  },
  {
    id: 3,
    name: "Dr. Michael Brown",
    specialty: "Orthopedic Surgeon",
    image: new URL('@/assets/doctors/3.jpg', import.meta.url).href,
    shortDesc: "An expert orthopedic surgeon for knee and hip replacements.",
    fullDesc: "An expert orthopedic surgeon specializing in knee and hip replacements, fracture treatments, and sports injury rehabilitation.",
    expanded: false
  },
  {
    id: 4,
    name: "Dr. Emily Johnson",
    specialty: "Pediatrician",
    image: new URL('@/assets/doctors/4.jpg', import.meta.url).href,
    shortDesc: "A dedicated pediatrician providing care for infants and children.",
    fullDesc: "A dedicated pediatrician providing comprehensive care for infants and children, including vaccinations and growth monitoring.",
    expanded: false
  },
  {
    id: 5,
    name: "Dr. Sophia  Williams",
    specialty: "Ophthalmologist",
    image: new URL('@/assets/doctors/5.jpg', import.meta.url).href,
    shortDesc: "A trusted ophthalmologist specializing in vision correction.",
    fullDesc: "A trusted ophthalmologist specializing in cataract surgeries, vision correction, and advanced glaucoma treatments.",
    expanded: false
  },
  {
    id: 6,
    name: "Dr. Olivia Thompson",
    specialty: "General Physician",
    image: new URL('@/assets/doctors/6.jpg', import.meta.url).href,
    shortDesc: "A leading general physician in internal medicine.",
    fullDesc: "A leading general physician providing expert care in internal medicine, chronic disease management, and preventive healthcare.",
    expanded: false
  }
]);

// Funksioni për të hapur ose mbyllur përshkrimin
const toggleReadMore = (doctor) => {
  doctor.expanded = !doctor.expanded;
};
</script>

<template>
  <section id="doctors" class="py-16 bg-gradient-to-r from-blue-50 to-blue-100">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold text-gray-800">Meet Our Doctors</h2>
      <p class="text-lg text-gray-700 mt-4 max-w-2xl mx-auto">
        Our experienced doctors are dedicated to providing top-quality medical care.
      </p>

      <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="doctor in doctors" :key="doctor.id" class="p-6 bg-white shadow-lg rounded-xl transition transform hover:scale-105 w-80 h-auto mx-auto flex flex-col items-center">
          <img :src="doctor.image" :alt="doctor.name" class="w-24 h-24 rounded-full mb-4">
          <h3 class="text-xl font-semibold text-blue-700">{{ doctor.name }}</h3>
          <p class="text-gray-600 mt-2 text-center">
            {{ doctor.expanded ? doctor.fullDesc : doctor.shortDesc }}
          </p>
          <button @click="toggleReadMore(doctor)" class="mt-3 text-blue-600 hover:underline">
            {{ doctor.expanded ? "Read Less" : "Read More" }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>
