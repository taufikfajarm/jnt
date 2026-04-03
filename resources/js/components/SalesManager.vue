<template>
  <div class="space-y-6">
    <!-- Header Sales -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 font-medium mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span>Manajemen Tim & Laporan</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Data Sales & Laporan</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400 font-medium">Kelola tim marketing dan lihat detail laporan penjualan.</p>
      </div>
      <div v-if="activeTab === 'data'" class="flex items-center gap-3">
        <button @click="openModal()" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition-all active:scale-95 group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Tambah Sales
        </button>
      </div>
    </header>

    <!-- Tabs Navigation -->
    <div class="flex space-x-2 border-b border-gray-200 dark:border-gray-700">
      <button 
        @click="activeTab = 'data'" 
        :class="activeTab === 'data' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
        class="px-4 py-2 font-medium text-sm transition-colors"
      >
        Tim Sales
      </button>
      <button 
        @click="activeTab = 'laporan'" 
        :class="activeTab === 'laporan' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
        class="px-4 py-2 font-medium text-sm transition-colors flex items-center space-x-1.5"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        <span>Laporan Penjualan</span>
      </button>
    </div>

    <!-- Content Card: Tim Sales -->
    <div v-if="activeTab === 'data'" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
      <div class="p-6 border-b border-gray-50 dark:border-gray-700/50">
        <div class="relative w-full md:w-80 group">
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari sales..." 
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
              <th class="px-8 py-4">Nama Sales</th>
              <th class="px-8 py-4">Nomor HP</th>
              <th class="px-8 py-4">Alamat</th>
              <th class="px-8 py-4">Status</th>
              <th class="px-8 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30 text-sm">
            <tr v-for="(s, index) in paginatedSales" :key="s.id" class="hover:bg-blue-50/30 dark:hover:bg-blue-400/5 transition-colors">
              <td class="px-8 py-4 text-center">
                 <span class="text-xs font-bold text-gray-400 dark:text-gray-600">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</span>
              </td>
              <td class="px-8 py-4">
                <span class="font-bold text-gray-900 dark:text-white">{{ s.nama }}</span>
              </td>
              <td class="px-8 py-4 text-gray-500 dark:text-gray-400 font-medium">
                {{ s.no_hp }}
              </td>
              <td class="px-8 py-4 text-gray-500 dark:text-gray-400 max-w-xs truncate">
                {{ s.alamat }}
              </td>
              <td class="px-8 py-4">
                <span :class="s.status === 'aktif' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-400' : 'bg-rose-50 text-rose-600 dark:bg-rose-400/10 dark:text-rose-400'" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                  {{ s.status }}
                </span>
              </td>
              <td class="px-8 py-4">
                <div class="flex items-center justify-center space-x-2">
                  <button @click="openModal(s)" class="p-2 text-blue-400 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                  </button>
                  <button @click="deleteSales(s.id)" class="p-2 text-rose-400 hover:text-rose-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredSales.length === 0">
               <td colspan="6" class="px-8 py-20 text-center opacity-40 dark:opacity-60 italic text-sm text-gray-500 dark:text-white">Data sales tidak ditemukan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination Sales -->
      <div v-if="filteredSales.length > 0" class="px-6 py-6 border-t border-gray-50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
           {{ filteredSales.length }} total sales
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

    <!-- Content Card: Laporan Penjualan -->
    <div v-if="activeTab === 'laporan'" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
      <div class="p-6 border-b border-gray-50 dark:border-gray-700/50 flex flex-col lg:flex-row gap-4 items-end lg:items-center justify-between">
        
        <div class="relative w-full lg:w-72 group">
          <input 
            v-model="reportSearchQuery"
            type="text" 
            placeholder="Cari pelanggan..." 
            class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/10 outline-none text-sm transition-all" 
          />
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
          <!-- Filter Sales -->
          <select v-model="filterSalesId" class="px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all font-semibold">
            <option value="all">Semua Sales</option>
            <option v-for="s in salesList" :key="s.id" :value="s.id">{{ s.nama }}</option>
          </select>

          <!-- Filter Tipe Waktu -->
          <select v-model="filterType" class="px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all">
            <option value="all">Semua Waktu</option>
            <option value="month">Bulanan</option>
            <option value="custom">Kustom Range</option>
          </select>
          
          <div v-if="filterType === 'month'" class="flex flex-col sm:flex-row items-center gap-2">
            <select v-model="filterSelectedMonth" class="px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all font-medium">
              <option value="">Bulan</option>
              <option v-for="(m, i) in monthsList" :key="i" :value="i+1">{{ m }}</option>
            </select>
            <select v-model="filterSelectedYear" class="px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all font-medium">
              <option value="">Tahun</option>
              <option v-for="y in availableYears" :key="y" :value="y">{{ y }}</option>
            </select>
          </div>
          
          <div v-if="filterType === 'custom'" class="flex flex-col sm:flex-row items-center gap-2">
            <input v-model="filterStartDate" type="date" class="px-4 py-2 w-full sm:w-auto bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all" />
            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">s/d</span>
            <input v-model="filterEndDate" type="date" class="px-4 py-2 w-full sm:w-auto bg-gray-50 dark:bg-gray-900 border border-transparent dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all" />
          </div>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
          <thead>
            <tr class="bg-gray-50/50 dark:bg-gray-900/10 text-gray-400 dark:text-gray-500 text-xs font-bold uppercase tracking-tight">
              <th class="px-6 py-4 text-center w-16">No</th>
              <th class="px-6 py-4">ID Pel.</th>
              <th class="px-6 py-4">Pelanggan</th>
              <th class="px-6 py-4">Tanggal Daftar</th>
              <th class="px-6 py-4">Paket</th>
              <th class="px-6 py-4">Sales</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30 text-sm">
            <tr v-for="(p, index) in paginatedReport" :key="p.id" class="hover:bg-blue-50/30 dark:hover:bg-blue-400/5 transition-colors">
              <td class="px-6 py-4 text-center">
                 <span class="text-xs font-bold text-gray-400 dark:text-gray-600">{{ (currentReportPage - 1) * itemsPerPage + index + 1 }}</span>
              </td>
              <td class="px-6 py-4 font-mono text-xs text-gray-500 dark:text-gray-400">
                {{ p.id_pelanggan }}
              </td>
              <td class="px-6 py-4">
                <div class="font-bold text-gray-900 dark:text-white">{{ p.nama }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ p.no_hp }}</div>
              </td>
              <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium">
                {{ formatDate(p.tanggal_daftar) }}
              </td>
              <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                <span v-if="p.paket" class="bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400 px-2 py-1 rounded text-xs font-medium">
                  {{ p.paket.nama_paket }}
                </span>
                <span v-else>-</span>
              </td>
              <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-medium">
                {{ p.sales ? p.sales.nama : '-' }}
              </td>
            </tr>
            <tr v-if="filteredReportData.length === 0">
               <td colspan="6" class="px-8 py-20 text-center opacity-40 dark:opacity-60 italic text-sm text-gray-500 dark:text-white">Data laporan tidak ditemukan untuk filter ini.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination Report -->
      <div v-if="filteredReportData.length > 0" class="px-6 py-6 border-t border-gray-50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">
           Menampilkan <span class="font-bold text-gray-900 dark:text-white">{{ filteredReportData.length }}</span> data pelanggan dari Total <span class="font-bold text-gray-900 dark:text-white">{{ pelanggansData.length }}</span> data pelangggan.
        </div>
        
        <div class="flex items-center gap-1.5">
          <button @click="prevReportPage" :disabled="currentReportPage === 1" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          
          <template v-for="page in reportPaginationWindow" :key="page">
            <button v-if="page !== '...'" @click="currentReportPage = page" :class="currentReportPage === page ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-700 hover:border-blue-500 hover:text-blue-500'" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all">
              {{ page }}
            </button>
            <div v-else class="w-10 h-10 flex items-end justify-center text-gray-400 pb-2">
              <span class="tracking-widest">...</span>
            </div>
          </template>

          <button @click="nextReportPage" :disabled="currentReportPage >= totalReportPages" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 disabled:opacity-20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Form Tim Sales -->
    <Teleport to="body">
       <Transition
         enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95"
       >
         <div v-if="showModal" class="fixed inset-0 z-[110] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
               <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm" @click="closeModal()"></div>
               <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-700 relative z-10 p-6">
                  <h3 class="text-xl font-bold dark:text-white mb-6">Kelola Data Sales</h3>
                  <form @submit.prevent="saveSales" class="space-y-4">
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Nama Sales</label>
                        <input v-model="form.nama" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="Nama lengkap..." />
                     </div>
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Nomor HP</label>
                        <input v-model="form.no_hp" type="text" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="08..." />
                     </div>
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Alamat</label>
                        <textarea v-model="form.alamat" rows="3" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10" placeholder="Alamat lengkap..."></textarea>
                     </div>
                     <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Status</label>
                        <select v-model="form.status" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-blue-500/10">
                          <option value="aktif">Aktif</option>
                          <option value="nonaktif">Nonaktif</option>
                        </select>
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

// TABS
const activeTab = ref('data')

// TIM SALES STATE
const salesList = ref([])
const searchQuery = ref('')
const showModal = ref(false)
const showConfirm = ref(false)
const deleteId = ref(null)
const currentPage = ref(1)
const itemsPerPage = ref(10)
const form = ref({ id: null, nama: '', no_hp: '', alamat: '', status: 'aktif' })

// LAPORAN PENJUALAN STATE
const pelanggansData = ref([])
const reportSearchQuery = ref('')
const filterSalesId = ref('all')
const filterType = ref('all')
const filterSelectedMonth = ref('')
const filterSelectedYear = ref('')
const filterStartDate = ref('')
const filterEndDate = ref('')
const currentReportPage = ref(1)

const monthsList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

const availableYears = computed(() => {
   const years = new Set(pelanggansData.value.filter(p => p.tanggal_daftar).map(p => new Date(p.tanggal_daftar).getFullYear()))
   const sorted = Array.from(years).sort((a, b) => b - a)
   const currentYear = new Date().getFullYear()
   if (!sorted.includes(currentYear)) sorted.push(currentYear)
   return sorted.sort((a, b) => b - a)
})

const fetchData = async () => {
   // Fetch Sales
   const { data: sData } = await supabase.from('sales').select('*').order('created_at', { ascending: false })
   salesList.value = sData || []

   // Fetch Pelanggans with relation
   const { data: pData } = await supabase.from('pelanggans').select(`
      *,
      paket:pakets(*),
      sales:sales(*)
   `).order('tanggal_daftar', { ascending: false })
   pelanggansData.value = pData || []
}

// ---------------------------
// TIM SALES LOGIC
// ---------------------------
const filteredSales = computed(() => {
   const q = searchQuery.value.toLowerCase()
   return salesList.value.filter(s => s.nama.toLowerCase().includes(q) || s.no_hp.toLowerCase().includes(q))
})

const totalPages = computed(() => Math.ceil(filteredSales.value.length / itemsPerPage.value))
const paginatedSales = computed(() => {
   const start = (currentPage.value - 1) * itemsPerPage.value
   return filteredSales.value.slice(start, start + itemsPerPage.value)
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

const openModal = (s = null) => {
   if (s) form.value = { ...s }
   else form.value = { id: null, nama: '', no_hp: '', alamat: '', status: 'aktif' }
   showModal.value = true
}
const closeModal = () => { showModal.value = false }
const saveSales = async () => {
   const payload = { nama: form.value.nama, no_hp: form.value.no_hp, alamat: form.value.alamat, status: form.value.status }
   try {
      if (form.value.id) await supabase.from('sales').update(payload).eq('id', form.value.id)
      else await supabase.from('sales').insert([payload])
      fetchData(); closeModal()
   } catch (err) { alert(err.message) }
}
const deleteSales = (id) => { deleteId.value = id; showConfirm.value = true }
const confirmDelete = async () => { await supabase.from('sales').delete().eq('id', deleteId.value); fetchData(); showConfirm.value = false }


// ---------------------------
// LAPORAN LOGIC
// ---------------------------
const filteredReportData = computed(() => {
   let data = pelanggansData.value

   // Filter by Query 
   if (reportSearchQuery.value) {
      const q = reportSearchQuery.value.toLowerCase()
      data = data.filter(p => p.nama.toLowerCase().includes(q) || p.id_pelanggan.toLowerCase().includes(q) || p.no_hp.toLowerCase().includes(q))
   }

   // Filter by Sales
   if (filterSalesId.value !== 'all') {
      data = data.filter(p => p.sales_id == filterSalesId.value)
   }

   // Filter by Date
   if (filterType.value === 'month') {
      const mVal = filterSelectedMonth.value
      const yVal = filterSelectedYear.value
      
      if (mVal && yVal) {
         const paddedMonth = String(mVal).padStart(2, '0')
         const monthPrefix = `${yVal}-${paddedMonth}`
         data = data.filter(p => p.tanggal_daftar && p.tanggal_daftar.startsWith(monthPrefix))
      } else if (yVal) {
         data = data.filter(p => p.tanggal_daftar && p.tanggal_daftar.startsWith(`${yVal}`))
      } else if (mVal) {
         const paddedMonth = String(mVal).padStart(2, '0')
         data = data.filter(p => p.tanggal_daftar && p.tanggal_daftar.substring(5, 7) === paddedMonth)
      }
   } else if (filterType.value === 'custom') {
      if (filterStartDate.value && filterEndDate.value) {
         data = data.filter(p => p.tanggal_daftar >= filterStartDate.value && p.tanggal_daftar <= filterEndDate.value)
      } else if (filterStartDate.value) {
         data = data.filter(p => p.tanggal_daftar >= filterStartDate.value)
      } else if (filterEndDate.value) {
         data = data.filter(p => p.tanggal_daftar <= filterEndDate.value)
      }
   }

   return data
})

const totalReportPages = computed(() => Math.ceil(filteredReportData.value.length / itemsPerPage.value))
const paginatedReport = computed(() => {
   const start = (currentReportPage.value - 1) * itemsPerPage.value
   return filteredReportData.value.slice(start, start + itemsPerPage.value)
})

const reportPaginationWindow = computed(() => {
  const total = totalReportPages.value; const current = currentReportPage.value; const delta = 1; const range = []; const rangeWithDots = []; let l;
  for (let i = 1; i <= total; i++) { if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) range.push(i) }
  for (const i of range) { if (l) { if (i - l === 2) rangeWithDots.push(l + 1); else if (i - l !== 1) rangeWithDots.push('...') } rangeWithDots.push(i); l = i }
  return rangeWithDots
})

const nextReportPage = () => { if (currentReportPage.value < totalReportPages.value) currentReportPage.value++ }
const prevReportPage = () => { if (currentReportPage.value > 1) currentReportPage.value-- }
watch([reportSearchQuery, filterSalesId, filterType, filterSelectedMonth, filterSelectedYear, filterStartDate, filterEndDate], () => { currentReportPage.value = 1 })

// Helper Date Formatting
const formatDate = (dateString) => {
   if (!dateString) return '-'
   const options = { year: 'numeric', month: 'long', day: 'numeric' }
   return new Date(dateString).toLocaleDateString('id-ID', options)
}

onMounted(() => { fetchData() })
</script>
