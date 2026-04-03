<template>
  <div class="relative transition-all duration-200" :class="isOpen ? 'z-[200]' : 'z-10'" v-click-outside="close">
    <!-- Trigger Button -->
    <div 
      @click="toggle"
      :class="[
        isOpen ? 'border-blue-500 ring-2 ring-blue-500/10' : 'border-gray-200 dark:border-gray-700',
        'w-full px-4 py-2 bg-gray-50 dark:bg-gray-900/50 border rounded-xl cursor-pointer transition-all duration-200 flex items-center justify-between group'
      ]"
    >
      <span v-if="selectedOption" class="text-sm font-semibold text-gray-900 dark:text-white truncate">
        {{ selectedOption[labelKey] }}
      </span>
      <span v-else class="text-sm font-medium text-gray-400 italic">
        {{ placeholder }}
      </span>
      
      <svg 
        xmlns="http://www.w3.org/2000/svg" 
        :class="isOpen ? 'rotate-180' : ''" 
        class="h-4 w-4 text-gray-400 group-hover:text-blue-500 transition-transform duration-200" 
        fill="none" viewBox="0 0 24 24" stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </div>

    <!-- Dropdown Menu -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 translate-y-1 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 translate-y-1 scale-95"
    >
      <div 
        v-if="isOpen" 
        class="absolute z-[160] mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden backdrop-blur-xl bg-white/95 dark:bg-gray-800/95"
      >
        <!-- Search Input -->
        <div class="p-3 border-b border-gray-50 dark:border-gray-700/50">
          <div class="relative">
            <input 
              v-model="searchQuery"
              ref="searchInput"
              type="text" 
              placeholder="Cari..." 
              class="w-full pl-9 pr-4 py-1.5 bg-gray-100/50 dark:bg-gray-900/50 border-none rounded-lg text-xs font-semibold dark:text-white focus:ring-1 focus:ring-blue-500/20 outline-none"
              @keydown.esc="close"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
          </div>
        </div>

        <!-- Options List -->
        <div class="max-h-52 overflow-y-auto scrollbar-thin">
          <div 
            v-for="option in filteredOptions" 
            :key="option[valueKey]"
            @click="select(option)"
            :class="[
              modelValue === option[valueKey] ? 'bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50',
              'px-4 py-2.5 text-xs font-bold flex items-center justify-between cursor-pointer transition-colors'
            ]"
          >
            <span>{{ option[labelKey] }}</span>
            <span v-if="modelValue === option[valueKey]"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg></span>
          </div>
          
          <div v-if="filteredOptions.length === 0" class="px-6 py-6 text-center text-[10px] text-gray-400 italic">Data tidak ditemukan.</div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
const props = defineProps({
  modelValue: [String, Number],
  options: { type: Array, default: () => [] },
  placeholder: { type: String, default: 'Pilih opsi...' },
  labelKey: { type: String, default: 'nama' },
  valueKey: { type: String, default: 'id' }
})
const emit = defineEmits(['update:modelValue', 'change'])
const isOpen = ref(false)
const searchQuery = ref('')
const searchInput = ref(null)
const selectedOption = computed(() => props.options.find(opt => opt[props.valueKey] === props.modelValue))
const filteredOptions = computed(() => {
  const q = searchQuery.value.toLowerCase()
  return props.options.filter(opt => String(opt[props.labelKey]).toLowerCase().includes(q))
})
const toggle = () => { isOpen.value = !isOpen.value; if (isOpen.value) nextTick(() => searchInput.value?.focus()) }
const close = () => { isOpen.value = false; searchQuery.value = "" }
const select = (option) => { emit('update:modelValue', option[props.valueKey]); emit('change', option[props.valueKey]); close() }
const vClickOutside = {
  mounted(el, binding) { el.clickOutsideEvent = (event) => { if (!(el === event.target || el.contains(event.target))) binding.value(event) }; document.addEventListener("click", el.clickOutsideEvent) },
  unmounted(el) { document.removeEventListener("click", el.clickOutsideEvent) },
};
</script>

<style scoped>
@reference "../../css/app.css";
.scrollbar-thin::-webkit-scrollbar { width: 3px; }
.scrollbar-thin::-webkit-scrollbar-thumb { @apply bg-gray-200 dark:bg-gray-700 rounded-full; }
</style>
