<template>
  <div class="space-y-6">
    <!-- Header Paket -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 font-medium mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
          <span>Konfigurasi Layanan</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Katalog Paket WiFi</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400 font-medium">Atur jenis layanan, kecepatan, dan harga.</p>
      </div>
      <div class="flex items-center gap-3">
        <button @click="openModal()" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition-all active:scale-95 group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Tambah Paket
        </button>
      </div>
    </header>

    <!-- Content Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
      <div class="p-6 border-b border-gray-50 dark:border-gray-700/50">
        <div class="relative w-full md:w-80 group">
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari paket..." 
            class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/10 outline-none text-sm transition-all" 
          />
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </div>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="bg-gray-50/50 dark:bg-gray-900/10 text-gray-400 dark:text-gray-500 text-xs font-bold uppercase tracking-tight">
              <th class="px-8 py-4 text-center w-16">No</th>
              <th class="px-8 py-4">Nama Paket</th>
              <th class="px-8 py-4">Kecepatan</th>
              <th class="px-8 py-4">Harga</th>
              <th class="px-8 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30 text-sm">
            <tr v-for="(paket, index) in paginatedPakets" :key="paket.id" class="hover:bg-blue-50/30 dark:hover:bg-blue-400/5 transition-colors">
              <td class="px-8 py-4 text-center">
                 <span class="text-xs font-bold text-gray-400 dark:text-gray-600">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</span>
              </td>
              <td class="px-8 py-4">
                <span class="font-bold text-gray-900 dark:text-white">{{ paket.nama_paket }}</span>
              </td>
              <td class="px-8 py-4">
                <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-400/10 text-blue-600 dark:text-blue-400 rounded text-[10px] font-bold">
                  {{ paket.kecepatan }}
                </span>
              </td>
              <td class="px-8 py-4 font-bold text-gray-700 dark:text-gray-300">
                Rp {{ formatNumber(paket.harga) }}
              </td>
              <td class="px-8 py-4">
                <div class="flex items-center justify-center space-x-2">
                  <button @click="openModal(paket)" class="p-2 text-blue-400 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                  </button>
                  <button @click="deletePaket(paket.id)" class="p-2 text-rose-400 hover:text-rose-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredPakets.length === 0">
               <td colspan="5" class="px-8 py-20 text-center opacity-40 dark:opacity-60 italic text-sm text-gray-500 dark:text-white">Data tidak ditemukan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Boxed Pagination Footer -->
      <div v-if="filteredPakets.length > 0" class="px-6 py-6 border-t border-gray-50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
           {{ filteredPakets.length }} total layanan
        </div>
        
        <div class="flex items-center gap-1.5">
          <button @click="prevPage" :disabled="currentPage === 1" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          
          <template v-for="page in paginationWindow" :key="page">
            <button v-if="page !== '...'" @click="currentPage = page" :class="currentPage === page ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-700 hover:border-blue-500 hover:text-blue-500'" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all">
              {{ page }}
            </button>
            <div v-else class="w-10 h-10 flex items-end justify-center text-gray-400 pb-2">
              <span class="tracking-widest">...</span>
            </div>
          </template>

          <button @click="nextPage" :disabled="currentPage >= totalPages" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <Teleport to="body">
       <Transition
         enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95"
       >
         <div v-if="showModal" class="fixed inset-0 z-[110] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
               <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm" @click="closeModal()"></div>
               <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-700 relative z-10 p-6">
                  <h3 class="text-xl font-bold dark:text-white mb-6">Kelola Paket</h3>
                  <form @submit.prevent="savePaket" class="space-y-4">
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Nama Paket</label>
                        <input v-model="form.nama_paket" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="Basic..." />
                     </div>
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Kecepatan</label>
                        <input v-model="form.kecepatan" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="20 Mbps..." />
                     </div>
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Harga Langganan</label>
                        <div class="relative group">
                          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-xs font-bold text-blue-500">Rp</span>
                          </div>
                          <input :value="formattedHarga" @input="onHargaInput" type="text" required class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="0" />
                        </div>
                     </div>
                     <div class="pt-4 flex justify-end gap-3 text-sm">
                        <button type="button" @click="closeModal()" class="font-bold text-gray-400 hover:text-gray-600 px-4 py-2">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition-all active:scale-95">Simpan</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
       </Transition>
    </Teleport>

    <!-- Custom Confirm Modal -->
    <ConfirmModal :show="showConfirm" @confirm="confirmDelete" @cancel="showConfirm = false" />
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { supabase } from '../utils/supabase'
import ConfirmModal from './ConfirmModal.vue'

const pakets = ref([])
const searchQuery = ref('')
const showModal = ref(false)
const showConfirm = ref(false)
const deleteId = ref(null)
const currentPage = ref(1)
const itemsPerPage = ref(10)
const form = ref({ id: null, nama_paket: '', kecepatan: '', harga: 0 })

const formattedHarga = computed(() => form.value.harga ? formatNumber(form.value.harga) : '')
const onHargaInput = (e) => { const val = e.target.value.replace(/\D/g, ''); form.value.harga = val ? parseInt(val) : 0 }

const fetchData = async () => {
   const { data } = await supabase.from('pakets').select('*').order('harga', { ascending: true })
   pakets.value = data || []
}

const filteredPakets = computed(() => {
   const q = searchQuery.value.toLowerCase()
   return pakets.value.filter(p => p.nama_paket.toLowerCase().includes(q) || p.kecepatan.toLowerCase().includes(q))
})

const totalPages = computed(() => Math.ceil(filteredPakets.value.length / itemsPerPage.value))
const paginatedPakets = computed(() => {
   const start = (currentPage.value - 1) * itemsPerPage.value
   return filteredPakets.value.slice(start, start + itemsPerPage.value)
})

const paginationWindow = computed(() => {
  const total = totalPages.value; const current = currentPage.value; const delta = 1; const range = []; const rangeWithDots = []; let l;
  for (let i = 1; i <= total; i++) { if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) range.push(i) }
  for (const i of range) { if (l) { if (i - l === 2) rangeWithDots.push(l + 1); else if (i - l !== 1) rangeWithDots.push('...') } rangeWithDots.push(i); l = i }
  return rangeWithDots
})

const nextPage = () => { if (currentPage.value < totalPages.value) currentPage.value++ }
const prevPage = () => { if (currentPage.value > 1) currentPage.value-- }
watch(searchQuery, () => { currentPage.value = 1 })

const openModal = (p = null) => {
   if (p) form.value = { ...p }
   else form.value = { id: null, nama_paket: '', kecepatan: '', harga: 0 }
   showModal.value = true
}
const closeModal = () => { showModal.value = false }
const savePaket = async () => {
   const payload = { nama_paket: form.value.nama_paket, kecepatan: form.value.kecepatan, harga: form.value.harga }
   try {
      if (form.value.id) await supabase.from('pakets').update(payload).eq('id', form.value.id)
      else await supabase.from('pakets').insert([payload])
      fetchData(); closeModal()
   } catch (err) { alert(err.message) }
}
const deletePaket = (id) => { deleteId.value = id; showConfirm.value = true }
const confirmDelete = async () => { await supabase.from('pakets').delete().eq('id', deleteId.value); fetchData(); showConfirm.value = false }
const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num)
onMounted(() => { fetchData() })
</script>
