<template>
  <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
      <h2 class="text-xl font-bold mb-4">Delete Product</h2>
      <p>Are you sure you want to delete this product?</p>
      <div class="flex justify-end space-x-4 mt-4">
        <button @click="emit('closeDeleteModal')" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
        <button @click="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { deleteProduct } from "@/services/products";
import { defineProps, defineEmits, ref } from "vue";

const props = defineProps({
  productId: Number, // Sigurohemi që është një numër
});
const emit = defineEmits(["closeDeleteModal"]);
const showModal = ref(true);

const submit = async () => {
  try {
    if (!props.productId) {
      console.error("Product ID is missing!");
      return;
    }

    await deleteProduct(props.productId);
    emit("closeDeleteModal");

    // Rifresko faqen pas fshirjes (nëse është e nevojshme)
    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } catch (error) {
    console.error("Error deleting product:", error);
  }
};
</script>
