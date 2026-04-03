<template>
  <div class="space-y-6">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 font-medium mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <span>Data Master</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Data Pelanggan WiFi</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Kelola informasi pelanggan anda secara teratur.</p>
      </div>
      <div class="flex items-center gap-3">
        <button @click="openModal()" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md shadow-blue-500/20 transition-all duration-300 focus:outline-none active:scale-95 group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Tambah Pelanggan
        </button>
      </div>
    </header>

    <!-- Content Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
      <!-- Advanced Search & Filters -->
      <div class="p-6 border-b border-gray-50 dark:border-gray-700/50 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div class="relative w-full md:w-80 group">
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Cari pelanggan..." 
              class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/10 focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500 transition-all outline-none text-sm" 
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
          <div class="flex items-center gap-1 p-1 bg-gray-100 dark:bg-gray-900 rounded-xl">
            <button @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap">Semua</button>
            <button @click="filterStatus = 'aktif'" :class="filterStatus === 'aktif' ? 'bg-white dark:bg-gray-800 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-emerald-500'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap">Aktif</button>
            <button @click="filterStatus = 'nonaktif'" :class="filterStatus === 'nonaktif' ? 'bg-white dark:bg-gray-800 text-rose-600 dark:text-rose-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-rose-500'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap">Nonaktif</button>
            <button @click="filterStatus = 'isolir'" :class="filterStatus === 'isolir' ? 'bg-white dark:bg-gray-800 text-amber-600 dark:text-amber-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-amber-500'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap">Isolir</button>

            <button @click="resetFilters" class="px-2 py-1.5 text-gray-300 hover:text-rose-500 transition-colors ml-1" title="Reset Filters">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
          </div>
        </div>

        <!-- Advanced Searchable Region Filters -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="space-y-1.5">
             <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Kabupaten</label>
             <SearchableSelect 
                v-model="filterKabupaten" 
                :options="kabupatens" 
                placeholder="Semua Kabupaten" 
             />
          </div>
          <div class="space-y-1.5">
             <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Kecamatan</label>
             <SearchableSelect 
                v-model="filterKecamatan" 
                :options="availableKecamatans" 
                :placeholder="filterKabupaten ? 'Semua Kecamatan' : 'Pilih Kab. Dahulu'"
                :disabled="!filterKabupaten"
             />
          </div>
          <div class="space-y-1.5">
             <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Desa / Kelurahan</label>
             <SearchableSelect 
                v-model="filterDesa" 
                :options="availableDesas" 
                :placeholder="filterKecamatan ? 'Semua Desa' : 'Pilih Kec. Dahulu'"
                :disabled="!filterKecamatan"
             />
          </div>
        </div>
      </div>

      <!-- Datatable -->
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-gray-50/50 dark:bg-gray-900/10 text-gray-400 dark:text-gray-500 text-[10px] font-bold uppercase tracking-widest">
              <th class="px-6 py-4 text-center w-16">No</th>
              <th class="px-6 py-4">ID Pelanggan</th>
              <th class="px-6 py-4">Tgl Daftar</th>
              <th class="px-6 py-4">Identitas</th>
              <th class="px-6 py-4">Alamat</th>
              <th class="px-6 py-4">Sales</th>
              <th class="px-6 py-4">Paket</th>
              <th class="px-6 py-4">Status</th>
              <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30 text-sm">
            <tr v-for="(customer, index) in paginatedPelanggans" :key="customer.id" class="hover:bg-blue-50/30 dark:hover:bg-blue-400/5 transition-colors">
              <td class="px-6 py-4 text-center">
                 <span class="text-xs font-bold text-gray-400 dark:text-gray-600">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ customer.id_pelanggan || '-' }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ formatDate(customer.tanggal_daftar) }}</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex flex-col">
                  <span class="text-sm font-bold text-gray-900 dark:text-white">{{ customer.nama }}</span>
                  <span class="text-[11px] text-gray-400 dark:text-gray-500 font-mono tracking-tighter">{{ customer.no_hp }}</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex flex-col">
                  <span class="text-[11px] font-bold text-gray-900 dark:text-white uppercase">{{ customer.desa?.nama || '-' }}</span>
                  <span class="text-[10px] text-gray-400 dark:text-gray-500 whitespace-nowrap">
                    {{ customer.desa?.kecamatan?.nama }}, {{ customer.desa?.kecamatan?.kabupaten?.nama }}
                  </span>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex flex-col">
                  <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ customer.sales?.nama || '-' }}</span>
                  <span class="text-[10px] text-gray-400">{{ customer.sales?.no_hp || '' }}</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center space-x-2">
                  <div class="h-1.5 w-1.5 rounded-full bg-blue-500"></div>
                  <div class="flex flex-col">
                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ customer.paket?.nama_paket }}</span>
                    <span class="text-[10px] text-gray-400">{{ customer.paket?.kecepatan }}</span>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span :class="getStatusClass(customer.status_langganan)" class="px-2 py-0.5 rounded-lg text-[10px] font-bold capitalize border">
                  {{ customer.status_langganan }}
                </span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center justify-center space-x-1">
                  <button @click="openModal(customer)" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                  </button>
                  <button @click="deletePelanggan(customer.id)" class="p-2 text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredPelanggans.length === 0">
               <td colspan="8" class="px-6 py-20 text-center opacity-40 dark:opacity-60 italic text-sm text-gray-500 dark:text-white">Data tidak ditemukan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modern Pagination Footer -->
      <div v-if="filteredPelanggans.length > 0" class="px-6 py-6 border-t border-gray-50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="text-[11px] font-bold text-gray-400 tracking-wider uppercase">
           Menampilkan {{ startIndex + 1 }} - {{ Math.min(endIndex, filteredPelanggans.length) }} data
        </div>
        
        <div class="flex items-center gap-1.5">
          <button @click="prevPage" :disabled="currentPage === 1" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          
          <div class="flex items-center gap-1.5">
            <template v-for="page in paginationWindow" :key="page">
              <button v-if="page !== '...'" @click="currentPage = page" :class="currentPage === page ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-blue-500 hover:text-blue-500'" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all">
                {{ page }}
              </button>
              <div v-else class="w-10 h-10 flex items-end justify-center text-gray-400 pb-2">
                <span class="tracking-widest">...</span>
              </div>
            </template>
          </div>

          <button @click="nextPage" :disabled="currentPage >= totalPages" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <Teleport to="body">
       <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
         <div v-if="showModal" class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
               <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>
               <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100 dark:border-gray-700 relative z-10 p-6">
                  <div class="flex justify-between items-center mb-6">
                     <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-50 dark:bg-blue-400/10 rounded-lg text-blue-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                        <h3 class="text-xl font-bold dark:text-white">{{ form.id ? 'Edit Pelanggan' : 'Pelanggan Baru' }}</h3>
                     </div>
                     <button @click="closeModal()" class="p-1 text-gray-400 hover:text-gray-600 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                  </div>
                  <form @submit.prevent="savePelanggan" class="space-y-4">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">ID Pelanggan</label><input v-model="form.id_pelanggan" type="text" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 outline-none text-blue-600 dark:text-blue-400" placeholder="P001" /></div>
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Nama Lengkap</label><input v-model="form.nama" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 outline-none dark:text-white" placeholder="Sesuai KTP" /></div>
                     </div>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">NIK (16 Digit)</label><input v-model="form.nik" type="text" required maxlength="16" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 outline-none dark:text-white" placeholder="320..." /></div>
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Nomor WhatsApp</label><input v-model="form.no_hp" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 outline-none dark:text-white" placeholder="08..." /></div>
                     </div>
                     <div class="p-5 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700 space-y-4">
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Domisili Desa</label><SearchableSelect v-model="form.desa_id" :options="desas" placeholder="Pilih Desa..." /></div>
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Alamat Lengkap</label><textarea v-model="form.alamat_lengkap" rows="2" required class="w-full px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Blok, No House, etc..."></textarea></div>
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Data Sales</label><SearchableSelect v-model="form.sales_id" :options="salesList" placeholder="Pilih Sales..." /></div>
                     </div>
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-24">
                        <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Pilihan Paket</label><SearchableSelect v-model="form.paket_id" :options="pakets" label-key="nama_paket" placeholder="Pilih Paket..." /></div>
                        <div class="grid grid-cols-2 gap-4">
                           <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Status</label><select v-model="form.status_langganan" required class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option><option value="isolir">Isolir</option></select></div>
                           <div class="space-y-1.5"><label class="text-xs font-semibold text-gray-500 ml-1">Tgl Daftar</label><input v-model="form.tanggal_daftar" type="date" required class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-xs font-medium dark:text-white outline-none" /></div>
                        </div>
                     </div>
                     <div class="pt-4 flex justify-end items-center gap-4">
                        <button type="button" @click="closeModal()" class="text-sm font-bold text-gray-400 hover:text-gray-600 px-4 py-2">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition-all active:scale-95 text-sm">{{ form.id ? 'Perbarui' : 'Simpan Pelanggan' }}</button>
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

const pelanggans = ref([])
const pakets = ref([])
const kabupatens = ref([])
const kecamatans = ref([])
const desas = ref([])
const salesList = ref([])

const showModal = ref(false)
const showConfirm = ref(false)
const selectedPelanggan = ref(null)

const searchQuery = ref('')
const filterStatus = ref('all')
const filterKabupaten = ref('')
const filterKecamatan = ref('')
const filterDesa = ref('')

const deleteId = ref(null)
const currentPage = ref(1)
const itemsPerPage = ref(10)

const form = ref({
  id: null, id_pelanggan: '', nama: '', nik: '', no_hp: '', email: '', desa_id: '',
  alamat_lengkap: '', status_langganan: 'aktif', paket_id: '', sales_id: '',
  tanggal_daftar: new Date().toISOString().split('T')[0]
})

const availableKecamatans = computed(() => {
  if (!filterKabupaten.value) return []
  return kecamatans.value.filter(k => k.kabupaten_id === filterKabupaten.value)
})

const availableDesas = computed(() => {
  if (!filterKecamatan.value) return []
  return desas.value.filter(d => d.kecamatan_id === filterKecamatan.value)
})

const fetchPelanggans = async () => {
  const { data, error } = await supabase
    .from('pelanggans')
    .select('*, paket:pakets(*), sales:sales(*), desa:desas(id, nama, kecamatan:kecamatans(id, nama, kabupaten:kabupatens(id, nama)))')
    .order('created_at', { ascending: false })
  if (!error) pelanggans.value = data
}



const fetchData = async () => {
  const { data: p } = await supabase.from('pakets').select('*')
  pakets.value = p || []
  const { data: kab } = await supabase.from('kabupatens').select('*').order('nama', { ascending: true })
  kabupatens.value = kab || []
  const { data: kec } = await supabase.from('kecamatans').select('*').order('nama', { ascending: true })
  kecamatans.value = kec || []
  const { data: ds } = await supabase.from('desas').select('*').order('nama', { ascending: true })
  desas.value = ds || []
  const { data: sl } = await supabase.from('sales').select('*').order('nama', { ascending: true })
  salesList.value = sl || []
}

const filteredPelanggans = computed(() => {
  let result = pelanggans.value
  if (filterStatus.value !== 'all') result = result.filter(p => p.status_langganan === filterStatus.value)
  if (filterKabupaten.value) result = result.filter(p => p.kabupaten_id === filterKabupaten.value)
  if (filterKecamatan.value) result = result.filter(p => p.kecamatan_id === filterKecamatan.value)
  if (filterDesa.value) result = result.filter(p => p.desa_id === filterDesa.value)
  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    result = result.filter(p => p.nama.toLowerCase().includes(q) || p.nik.includes(q))
  }
  return result
})

const totalPages = computed(() => Math.ceil(filteredPelanggans.value.length / itemsPerPage.value))
const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value)
const endIndex = computed(() => startIndex.value + itemsPerPage.value)
const paginatedPelanggans = computed(() => filteredPelanggans.value.slice(startIndex.value, endIndex.value))

const paginationWindow = computed(() => {
  const total = totalPages.value; const current = currentPage.value; const delta = 1; let l; const range = []; const rangeWithDots = [];
  for (let i = 1; i <= total; i++) { if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) range.push(i) }
  for (const i of range) { if (l) { if (i - l === 2) rangeWithDots.push(l + 1); else if (i - l !== 1) rangeWithDots.push('...') } rangeWithDots.push(i); l = i }
  return rangeWithDots
})

const nextPage = () => { if (currentPage.value < totalPages.value) currentPage.value++ }
const prevPage = () => { if (currentPage.value > 1) currentPage.value-- }
const resetFilters = () => { filterStatus.value = 'all'; filterKabupaten.value = ''; filterKecamatan.value = ''; filterDesa.value = ''; searchQuery.value = '' }

watch([searchQuery, filterStatus, filterKabupaten, filterKecamatan, filterDesa], () => { currentPage.value = 1 })
watch(filterKabupaten, () => { filterKecamatan.value = ''; filterDesa.value = '' })
watch(filterKecamatan, () => { filterDesa.value = '' })

const openModal = async (customer = null) => {
  if (customer) form.value = { ...customer }
  else form.value = { id: null, id_pelanggan: '', nama: '', nik: '', no_hp: '', email: '', desa_id: '', alamat_lengkap: '', status_langganan: 'aktif', paket_id: '', sales_id: '', tanggal_daftar: new Date().toISOString().split('T')[0] }
  showModal.value = true
}

const closeModal = () => { showModal.value = false }
const savePelanggan = async () => {
    try {
        const payload = { ...form.value }
        const id = payload.id
        delete payload.id
        // Clean up nested objects from Supabase join
        delete payload.paket
        delete payload.desa
        delete payload.sales
        
        const { data: d } = await supabase.from('desas').select('kecamatan_id, kecamatan:kecamatans(kabupaten_id)').eq('id', payload.desa_id).single()
        if (d) { payload.kecamatan_id = d.kecamatan_id; payload.kabupaten_id = d.kecamatan.kabupaten_id }
        
        if (id) await supabase.from('pelanggans').update(payload).eq('id', id)
        else await supabase.from('pelanggans').insert([payload])
        
        fetchPelanggans(); closeModal()
    } catch (err) { alert(err.message) }
}
const deletePelanggan = (id) => { deleteId.value = id; showConfirm.value = true }
const confirmDelete = async () => { await supabase.from('pelanggans').delete().eq('id', deleteId.value); fetchPelanggans(); showConfirm.value = false }
const getStatusClass = (s) => {
  switch (s) {
    case 'aktif': return 'bg-emerald-50 text-emerald-600 dark:bg-emerald-400/5 dark:text-emerald-400 border-emerald-100 dark:border-emerald-400/20';
    case 'nonaktif': return 'bg-rose-50 text-rose-600 dark:bg-rose-400/5 dark:text-rose-400 border-rose-100 dark:border-rose-400/20';
    case 'isolir': return 'bg-amber-50 text-amber-600 dark:bg-amber-400/5 dark:text-amber-400 border-amber-100 dark:border-amber-400/20';
    default: return 'bg-gray-100 text-gray-500';
  }
}
const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
onMounted(() => { fetchPelanggans(); fetchData() })
</script>
