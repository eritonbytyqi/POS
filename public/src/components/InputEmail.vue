 <script setup>

import {computed} from "vue";

const props = defineProps(  {
  label: String,
  modelValue: String,
  placeholder: String,
  

})

const emit = defineEmits(['update:modelValue']);

const inputValue = computed({ 
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
});

</script>

<template>
  <div>
    <label class="block text-sm font-medium text-gray-700">{{ label }}</label>
    <div class="mt-2">
      <input
       :type="type"
       v-model="inputValue"
      class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
      :placeholder="placeholder"
      />
    
    </div>
  </div>
</template> 



