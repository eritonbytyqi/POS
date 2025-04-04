<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-container">
        <h3 class="text-lg font-semibold mb-4 text-center">Make Payment</h3>
        
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label for="paymentMethod" class="block font-medium mb-1">Payment Method</label>
            <select id="method_id" v-model="form.payment_method" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
  <option value="" disabled>Select a payment method</option>
  <option v-for="method in payment_methods" :key="method.id" :value="method.id">
    {{ method.payment_method }}
  </option>
</select>

          </div>
          <div>
            <label for="amount" class="block font-medium mb-1">Amount</label>
            <input v-model="form.amount" type="number" id="amount" required class="input-field" />
          </div>
          
          <div class="flex justify-between mt-4">
            <button type="submit" class="btn-primary">Pay Now</button>
            <button @click="$emit('close')" class="btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits, onMounted } from "vue";
  import axios from "axios";
  import { storePayment } from "@/services/payments.js"; 
  
  
  // Props

const payment_methods = ref([]);
const appointmentId = ref("123");
  const props = defineProps({
    isVisible: {
      type: Boolean,
      required: true,
    },
    appointmentId: {
      type: [String, Number],
      required: true,
    },
  });
  
  // Emits
  const emit = defineEmits(["close"]);
  
  const paymentMethods = ref([]);
  const form = ref({
    amount: 100,
    payment_method: "", 
  });
  
  const fetchPaymentMethods = async () => {
  try {
    const response = await axios.get(`/api/appointments/${appointmentId.value}/payment`);
    payment_methods.value = response.data.payment_methods;
  } catch (error) {
    console.error('Gabim në marrjen e metodave të pagesës:', error);
  }
};
  
  onMounted(fetchPaymentMethods);
  
  const submit = () => {
    storePayment(form).then(response => {
      if (response) {
        console.log('Payment Successful:', response);
        emit("close"); 
      } else {
        console.log('Payment Failed');
      }
    }).catch(error => {
      console.error('Error:', error);
    });
  };
  </script>
  
  <style scoped>
  /* Modal Overlay */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
  }
  
  /* Modal Container */
  .modal-container {
    background: white;
    padding: 24px;
    border-radius: 10px;
    width: 350px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.3s ease-in-out;
  }
  
  /* Inputs */
  .input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
  }
  
  /* Buttons */
  .btn-primary {
    background: #3498db;
    color: white;
    padding: 10px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
  }
  
  .btn-primary:hover {
    background: #2980b9;
  }
  
  .btn-secondary {
    background: #e74c3c;
    color: white;
    padding: 10px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
  }
  
  .btn-secondary:hover {
    background: #c0392b;
  }
  
  /* Animation */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0.9);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }
  </style>
    