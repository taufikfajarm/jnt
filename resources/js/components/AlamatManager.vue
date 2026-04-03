<template>
  <div class="space-y-6">
    <!-- Header Alamat -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 font-medium mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          </svg>
          <span>Konfigurasi Wilayah</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Data Alamat & Wilayah</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Atur struktur administrasi wilayah pelayanan.</p>
      </div>
      <div class="flex items-center gap-3">
        <button @click="openModal()" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition-all active:scale-95 group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Tambah {{ activeTabLabel }}
        </button>
      </div>
    </header>

    <!-- Tabs Navigation -->
    <div class="flex items-center p-1 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 w-fit">
      <button 
        v-for="tab in tabs" 
        :key="tab.id"
        @click="activeTab = tab.id"
        :class="activeTab === tab.id ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-blue-600'" 
        class="px-5 py-1.5 rounded-lg text-sm font-bold transition-all duration-200"
      >
        {{ tab.label }}
      </button>
    </div>

    <!-- Content Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
      <div class="p-6 border-b border-gray-50 dark:border-gray-700/50">
        <div class="relative w-full md:w-80">
          <input 
            v-model="searchQuery"
            type="text" 
            :placeholder="'Cari ' + activeTabLabel.toLowerCase() + '...'" 
            class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/10 outline-none text-sm transition-all" 
          />
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </div>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="bg-gray-50/50 dark:bg-gray-900/10 text-gray-400 dark:text-gray-500 text-[10px] font-bold uppercase">
              <th class="px-8 py-4 text-center w-16">No</th>
              <th class="px-8 py-4">Nama {{ activeTabLabel }}</th>
              <th v-if="activeTab === 'kecamatan'" class="px-8 py-4">Kabupaten</th>
              <th v-if="activeTab === 'desa'" class="px-8 py-4">Kecamatan (Kabupaten)</th>
              <th class="px-8 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30 text-sm">
            <tr v-for="(item, index) in paginatedItems" :key="item.id" class="hover:bg-blue-50/30 dark:hover:bg-blue-400/5 transition-colors">
              <td class="px-8 py-4 text-center">
                 <span class="text-xs font-bold text-gray-400 dark:text-gray-600">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</span>
              </td>
              <td class="px-8 py-4 font-semibold text-gray-900 dark:text-white">{{ item.nama }}</td>
              <td v-if="activeTab === 'kecamatan'" class="px-8 py-4 text-gray-600 dark:text-gray-300">
                {{ item.kabupaten?.nama }}
              </td>
              <td v-if="activeTab === 'desa'" class="px-8 py-4">
                <span class="font-bold text-blue-500 dark:text-blue-400">{{ item.kecamatan?.nama }}</span>
                <span class="text-xs ml-2 text-gray-400 dark:text-gray-500">({{ item.kecamatan?.kabupaten?.nama }})</span>
              </td>
              <td class="px-8 py-4">
                <div class="flex items-center justify-center space-x-2">
                  <button @click="openModal(item)" class="p-2 text-blue-400 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                  </button>
                  <button @click="deleteItem(item.id)" class="p-2 text-rose-400 hover:text-rose-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredItems.length === 0">
               <td colspan="5" class="px-8 py-20 text-center opacity-40 dark:opacity-60 italic text-sm text-gray-500 dark:text-white">Data tidak ditemukan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Boxed Pagination Footer -->
      <div v-if="filteredItems.length > 0" class="px-6 py-6 border-t border-gray-50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
           {{ filteredItems.length }} total data
        </div>
        
        <div class="flex items-center gap-1.5">
          <button 
            @click="prevPage" 
            :disabled="currentPage === 1"
            class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all font-bold"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          
          <template v-for="page in paginationWindow" :key="page">
            <button 
              v-if="page !== '...'"
              @click="currentPage = page"
              :class="currentPage === page ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-700 hover:border-blue-500 hover:text-blue-500'"
              class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all"
            >
              {{ page }}
            </button>
            <div v-else class="w-10 h-10 flex items-end justify-center text-gray-400 pb-2">
              <span class="tracking-widest">...</span>
            </div>
          </template>

          <button 
            @click="nextPage" 
            :disabled="currentPage >= totalPages"
            class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all font-bold"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <Teleport to="body">
       <Transition
         enter-active-class="transition duration-300 ease-out"
         enter-from-class="opacity-0 scale-95"
         enter-to-class="opacity-100 scale-100"
         leave-active-class="transition duration-200 ease-in"
         leave-from-class="opacity-100 scale-100"
         leave-to-class="opacity-0 scale-95"
       >
         <div v-if="showModal" class="fixed inset-0 z-[110] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
               <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>
               <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-700 relative z-10 p-6">
                  <h3 class="text-xl font-bold dark:text-white mb-6">Kelola {{ activeTabLabel }}</h3>
                  <form @submit.prevent="saveItem" class="space-y-4">
                     <div v-if="activeTab === 'kecamatan'" class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Pilih Kabupaten</label>
                        <SearchableSelect v-model="form.kabupaten_id" :options="kabupatens" placeholder="Pilih Kabupaten..." />
                     </div>
                     <div v-if="activeTab === 'desa'" class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Pilih Kecamatan</label>
                        <SearchableSelect v-model="form.kecamatan_id" :options="kecamatans" placeholder="Pilih Kecamatan..." />
                     </div>
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Nama {{ activeTabLabel }}</label>
                        <input v-model="form.nama" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="Masukkan nama..." />
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
import SearchableSelect from './SearchableSelect.vue'

const activeTab = ref('kabupaten')
const tabs = [{ id: 'kabupaten', label: 'Kabupaten' }, { id: 'kecamatan', label: 'Kecamatan' }, { id: 'desa', label: 'Desa' }]
const searchQuery = ref('')
const items = ref([])
const showModal = ref(false)
const showConfirm = ref(false)
const deleteId = ref(null)
const currentPage = ref(1)
const itemsPerPage = ref(10)
const kabupatens = ref([])
const kecamatans = ref([])
const form = ref({ id: null, nama: '', kabupaten_id: '', kecamatan_id: '' })
const activeTabLabel = computed(() => tabs.find(t => t.id === activeTab.value)?.label)

const fetchData = async () => {
   let query = supabase.from(activeTab.value + 's').select('*')
   if (activeTab.value === 'kecamatan') query = supabase.from('kecamatans').select('*, kabupaten:kabupatens(*)')
   else if (activeTab.value === 'desa') query = supabase.from('desas').select('*, kecamatan:kecamatans(*, kabupaten:kabupatens(*))')
   const { data } = await query.order('nama', { ascending: true })
   items.value = data || []
}

const fetchDependencies = async () => {
   if (activeTab.value === 'kecamatan') { const { data } = await supabase.from('kabupatens').select('*'); kabupatens.value = data || [] }
   else if (activeTab.value === 'desa') { const { data } = await supabase.from('kecamatans').select('*, kabupaten:kabupatens(*)'); kecamatans.value = data || [] }
}

const filteredItems = computed(() => {
   const q = searchQuery.value.toLowerCase()
   return items.value.filter(i => i.nama.toLowerCase().includes(q))
})

const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value))
const paginatedItems = computed(() => {
   const start = (currentPage.value - 1) * itemsPerPage.value
   return filteredItems.value.slice(start, start + itemsPerPage.value)
})

const paginationWindow = computed(() => {
  const total = totalPages.value; const current = currentPage.value; const delta = 1; const range = []; const rangeWithDots = []; let l;
  for (let i = 1; i <= total; i++) { if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) range.push(i) }
  for (const i of range) { if (l) { if (i - l === 2) rangeWithDots.push(l + 1); else if (i - l !== 1) rangeWithDots.push('...') } rangeWithDots.push(i); l = i }
  return rangeWithDots
})

const nextPage = () => { if (currentPage.value < totalPages.value) currentPage.value++ }
const prevPage = () => { if (currentPage.value > 1) currentPage.value-- }

watch([activeTab, searchQuery], () => { currentPage.value = 1; fetchData(); fetchDependencies() })

const openModal = (i = null) => {
   if (i) form.value = { ...i, kabupaten_id: i.kabupaten_id || '', kecamatan_id: i.kecamatan_id || '' }
   else form.value = { id: null, nama: '', kabupaten_id: '', kecamatan_id: '' }
   showModal.value = true
}
const closeModal = () => { showModal.value = false }
const saveItem = async () => {
   const payload = { nama: form.value.nama }
   if (activeTab.value === 'kecamatan') payload.kabupaten_id = form.value.kabupaten_id
   if (activeTab.value === 'desa') payload.kecamatan_id = form.value.kecamatan_id
   try {
      if (form.value.id) await supabase.from(activeTab.value + 's').update(payload).eq('id', form.value.id)
      else await supabase.from(activeTab.value + 's').insert([payload])
      fetchData(); closeModal()
   } catch (err) { alert(err.message) }
}
const deleteItem = (id) => { deleteId.value = id; showConfirm.value = true }
const confirmDelete = async () => {
   try {
      console.log('Menghapus dari:', activeTab.value + 's', 'ID:', deleteId.value);
      const { error } = await supabase.from(activeTab.value + 's').delete().eq('id', deleteId.value);
      if (error) throw error;
      fetchData(); 
      showConfirm.value = false;
   } catch (err) {
      alert('Gagal menghapus data: ' + (err.message || 'Terjadi kesalahan internal. Periksa apakah data ini masih digunakan oleh data lain.'));
      console.error(err);
      showConfirm.value = false;
   }
}
onMounted(() => { fetchData(); fetchDependencies() })
</script>
