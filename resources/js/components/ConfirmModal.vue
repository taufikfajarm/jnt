<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div v-if="show" class="fixed inset-0 z-[150] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
          <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" @click="$emit('cancel')"></div>
          
          <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-center overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-gray-100 dark:border-gray-700 relative z-10 p-8">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-50 dark:bg-rose-400/10 mb-5">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-rose-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight mb-2">Konfirmasi Hapus</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-8 leading-relaxed">
              Apakah anda yakin ingin menghapus data ini? Tindakan ini <span class="text-rose-500 font-bold">tidak dapat dibatalkan</span>.
            </p>

            <div class="flex flex-col gap-2">
              <button 
                @click="$emit('confirm')" 
                class="w-full inline-flex justify-center px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-md transition-all active:scale-95 uppercase tracking-wider"
              >
                Hapus Permanen
              </button>
              <button 
                @click="$emit('cancel')" 
                class="w-full inline-flex justify-center px-6 py-2.5 bg-gray-50 dark:bg-gray-900 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs font-bold rounded-xl transition-all"
              >
                Batalkan
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  show: Boolean
})
defineEmits(['confirm', 'cancel'])
</script>
