<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import { get, post } from "@/composable/useApi.js"; 
import InputText from "@/components/InputText.vue";
import { useRoute } from "vue-router";

const route= useRoute();
const appointmentId=ref(null);
const formattedAmount = computed(() => `${form.amount} €`);

onMounted(()=>
{
    appointmentId.value=route.query.appointment_id;
    console.log("appointmentId", appointmentId.value)
}
)
console.log("appointment id",appointmentId)
const form = reactive({
    amount: "$10.00",
    appointment_id: appointmentId,
    status: "",
   
});

const message = ref("");
const success = ref(false);

const submit = async () => {
    try {
        console.log("Te dhenat po dergohen", form, "appId", appointmentId);
        const response = await post('/api/appointments/${appointmentId}/payments', form);
        if (response.status== 201){
        console.log("Pagesa u krye me sukses");
        }
        message.value = "Payment created successfully!";
        success.value = true;
        console.log(response.data);
        router.push({ name: "landing" }); 
    } catch (error) {
        message.value = "Error creating payment. Please check all fields.";
        success.value = false;
    
        console.error("Gabim gjatë krijimit të pagesës:", error);

        if (error.response) {
            console.error("Status Code:", error.response.status);
            console.error("Response Data:", error.response.data);
        }
    }
};
</script>

  <template>
    <div class="py-10 min-h-screen bg-gradient-to-b from-blue-50 to-blue-100 shadow-lg flex justify-center items-center">
        <div class="bg-transparent shadow-lg rounded-lg p-8 w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create payment</h1>
            <div v-if="message" :class="success ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                class="p-3 rounded-md mb-4">
                {{ message }}
            </div>
            <form @submit.prevent="submit" class="space-y-4">
            <div class="w-full">    
                <InputText disabled v-model="form.amount" required="true" label="Amount:"  readonly/>
            </div>
            <div class="w-full">
            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method:</label>
            <select id="payment_method" v-model="form.payment_method" required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled>Select a payment method</option>
                <option value="cash">Cash</option>
                <option value="paypal">Paypal</option>
                <option value="credit_card">Credit Card</option>
            </select>
            </div>
                <div>     
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md">
                    Save
                </button>
            </form> 
        </div>
    </div>
</template>

