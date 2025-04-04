<script setup>
import { ref, reactive, onMounted, watch, computed } from "vue";
import { get, post } from "@/composable/useApi.js"; 
import InputText from "@/components/InputText.vue";
import router from "@/router";

const filteredDoctors = computed(() => {
    const selectedDepartment = departments.value.find(dept => dept.id === form.department_id);
    return selectedDepartment ? selectedDepartment.doctors : [];
});

const isSunday = (dateString) => {
    if (!dateString) return false;
    return new Date(dateString).getDay() === 0;
};

const handleDateChange = () => {
    if (isSunday(form.date)) {
        alert("E diel nuk lejohet! Zgjidh një ditë tjetër.");
        form.date = "";
    }
};

const form = reactive({
    department_id: "",
    doctor_id: "", 
    fullname: "",
    email: "",
    phoneNumber: "",
    personal_id: "",
    date: "",
    time: "",
});

const allAvailableTimes = ref([
    "08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00",
    "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00"
]);
const availableTimes = ref([]);

const fetchAvailableTimes = async () => {
    if (!form.department_id || !form.doctor_id || !form.date) return;

    try {
        const response = await get(`/api/appointments/unavailable/${form.department_id}/${form.doctor_id}`, {
            params: { date: form.date },
        });
        const bookedTimes = response.data?.data || [];
        availableTimes.value = allAvailableTimes.value.filter(time => !bookedTimes.includes(time));
    } catch (error) {
        console.error("Gabim në marrjen e orareve të zëna:", error);
    }
};

watch([() => form.department_id, () => form.date, () => form.doctor_id], fetchAvailableTimes);

const departments = ref([]);
const showMessage = ref(false);

const fetchDepartments = async () => {
    try {
        const response = await get('/api/departments/Client');
        departments.value = response.data.result.data;
    } catch (error) {
        console.error("Gabim në marrjen e departamenteve:", error);
    }
};

onMounted(fetchDepartments);

const closeModal = () => {
    showMessage.value = false;
    router.push("/landing");
};

const submit = async () => {
    try {
        await post('/api/appointment/Client', form);
        showMessage.value = true;
    } catch (error) {
        console.error("Gabim në krijimin e terminit:", error);
    }
};




const minDate = ref(getCurrentDate());

function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Muaji është 0-based, prandaj shtojmë 1
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`; // Formatimi: YYYY-MM-DD
}

const isFormValid = computed(() => {
    return form.department_id && form.doctor_id && form.fullname && form.email && form.phoneNumber && form.personal_id && form.date && form.time;
});
</script>

<template>
 <div class="relative bg-blue-50 py-16 px-4 flex justify-center items-center">
    <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      <!-- Information section -->
      <div class="mt-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Book Your Appointment Easily</h2>
        <p class="text-gray-600 mb-6">No long queues, no waiting – secure your appointment in just a few clicks.</p>
        
        <!-- Benefits -->
        <div class="space-y-4">
          <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
            <span class="text-3xl text-blue-500 mr-3">📅</span>
            <div>
              <h3 class="text-lg font-semibold">Easy Booking</h3>
              <p class="text-gray-500 text-sm">Choose the time that suits you best.</p>
            </div>
          </div>
          <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
            <span class="text-3xl text-green-500 mr-3">✅</span>
            <div>
              <h3 class="text-lg font-semibold">Instant Confirmation</h3>
              <p class="text-gray-500 text-sm">Receive confirmation instantly.</p>
            </div>
          </div>
          <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
            <span class="text-3xl text-red-500 mr-3">⏳</span>
            <div>
              <h3 class="text-lg font-semibold">Save Time</h3>
              <p class="text-gray-500 text-sm">Avoid unnecessary waiting.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="py-12 bg-gradient-to-r from-blue-50 to-blue-100 flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Book Appointment</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department:</label>
                    <select id="department_id" v-model="form.department_id" class="mt-1 block w-full p-2 border rounded-md">
                        <option value="" disabled>Select a department</option>
                        <option v-for="department in departments" :key="department.id" :value="department.id">
                            {{ department.name }}
                        </option>
                    </select>
                </div>
                <div v-if="form.department_id">
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor:</label>
                    <select id="doctor_id" v-model="form.doctor_id" class="mt-1 block w-full p-2 border rounded-md">
                        <option value="" disabled>Select a doctor</option>
                        <option v-for="doctor in filteredDoctors" :key="doctor.id" :value="doctor.id">
                            {{ doctor.name }} {{ doctor.surname }}
                        </option>
                    </select>
                </div>
                <InputText v-model="form.fullname" label="Full Name" required />
                <InputText v-model="form.email" label="Email" required />
                <InputText v-model="form.phoneNumber" label="Phone Number" required />
                <InputText v-model="form.personal_id" label="Personal ID" required />
             <div>
        <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
        <input
            type="date"
            id="date"
            v-model="form.date"
            @change="handleDateChange"
            class="mt-1 block w-full p-2 border rounded-md"
            :min="minDate" 
        />
    </div>
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700">Time:</label>
                    <select id="time" v-model="form.time" class="mt-1 block w-full p-2 border rounded-md">
                        <option value="" disabled>Select a time</option>
                        <option v-for="time in availableTimes" :key="time" :value="time">
                            {{ time }}
                        </option>
                    </select>
                </div>
                <button type="submit" :disabled="!isFormValid" class="w-full bg-blue-600 text-white disabled:bg-gray-400 font-semibold py-2 px-4 hover:bg-blue-700 rounded-md shadow-md">
                    Save
                </button>
            </form>
        </div>
    </div>
    <div v-if="showMessage" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold text-center mb-4">Thank you for your appointment!</h2>
            <p class="text-center text-gray-600">Please wait for our confirmation in your email.</p>
            <div class="flex justify-center mt-6">
                <button @click="closeModal" class="bg-blue-600 text-white py-2 px-4 rounded-md">Close</button>
            </div>
        </div>
    </div>
    </div>
    </div>
</template>
