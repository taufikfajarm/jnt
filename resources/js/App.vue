<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Sidebar -->
    <aside 
      :class="[isSidebarCollapsed ? 'w-20' : 'w-64', 'fixed left-0 top-0 h-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 z-50 flex flex-col shadow-sm']"
    >
      <!-- Logo Section -->
      <div class="h-16 flex items-center px-5 border-b border-gray-50 dark:border-gray-700 overflow-hidden">
        <div class="flex items-center space-x-3 shrink-0">
          <div class="p-1.5 bg-blue-600 rounded-lg shadow-md shadow-blue-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
            </svg>
          </div>
          <span v-if="!isSidebarCollapsed" class="text-lg font-bold text-gray-900 dark:text-white tracking-tight whitespace-nowrap">
            J&T Network
          </span>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav class="flex-1 p-3 space-y-1.5 overflow-y-auto">
        <button 
          v-for="item in menuItems" 
          :key="item.id"
          @click="currentPage = item.id"
          :class="[
            currentPage === item.id 
              ? 'bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400 shadow-sm' 
              : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50',
            'w-full flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group relative'
          ]"
        >
          <!-- Icon Logic -->
          <div class="shrink-0 transition-transform duration-300 group-hover:scale-110">
            <!-- Dashboard Icon -->
            <svg v-if="item.id === 'dashboard'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <!-- Alamat Icon -->
            <svg v-else-if="item.id === 'alamat'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <!-- Paket Icon -->
            <svg v-else-if="item.id === 'paket'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <!-- Pelanggan Icon -->
            <svg v-else-if="item.id === 'pelanggan'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <!-- Sales Icon -->
            <svg v-else-if="item.id === 'sales'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>

          <span v-if="!isSidebarCollapsed" class="ml-3 font-semibold text-sm whitespace-nowrap">{{ item.label }}</span>
          
          <!-- Tooltip for collapsed mode -->
          <div v-if="isSidebarCollapsed" class="absolute left-full ml-4 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity font-medium z-[100] whitespace-nowrap shadow-lg border border-white/10">
            {{ item.label }}
          </div>
        </button>
      </nav>

      <!-- Bottom Actions -->
      <div class="p-3 border-t border-gray-50 dark:border-gray-700 space-y-1">
        <!-- Collapse Toggle -->
        <button @click="isSidebarCollapsed = !isSidebarCollapsed" class="w-full flex items-center px-3 py-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" :class="isSidebarCollapsed ? 'rotate-180' : ''" class="h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
          </svg>
          <span v-if="!isSidebarCollapsed" class="ml-3 text-xs font-semibold">Sembunyikan</span>
        </button>

        <!-- Dark Mode Toggle -->
        <button @click="toggleDarkMode" class="w-full flex items-center px-3 py-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-all text-left">
          <span v-if="isDarkMode">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
          </span>
          <span v-else>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
          </span>
          <span v-if="!isSidebarCollapsed" class="ml-3 text-xs font-semibold">{{ isDarkMode ? 'Tema Terang' : 'Tema Gelap' }}</span>
        </button>

        <!-- Logout Button -->
        <form method="POST" action="/logout" class="w-full">
          <input type="hidden" name="_token" :value="csrfToken">
          <button type="submit" class="w-full flex items-center px-3 py-2.5 text-rose-500 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl hover:bg-rose-50 dark:hover:bg-rose-400/10 transition-all text-left group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span v-if="!isSidebarCollapsed" class="ml-3 text-xs font-bold">Keluar Akun</span>
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main :class="[isSidebarCollapsed ? 'pl-20' : 'pl-64', 'min-h-screen transition-all duration-300']">
      <div class="pt-8 pb-12 px-6 max-w-7xl mx-auto">
        <!-- Render page based on selection -->
        <div v-if="currentPage === 'dashboard'">
          <Dashboard />
        </div>
        <div v-else-if="currentPage === 'pelanggan'">
          <PelangganManager />
        </div>
        <div v-else-if="currentPage === 'alamat'">
          <AlamatManager />
        </div>
        <div v-else-if="currentPage === 'paket'">
          <PaketManager />
        </div>
        <div v-else-if="currentPage === 'sales'">
          <SalesManager />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Dashboard from './components/Dashboard.vue'
import PelangganManager from './components/PelangganManager.vue'
import AlamatManager from './components/AlamatManager.vue'
import PaketManager from './components/PaketManager.vue'
import SalesManager from './components/SalesManager.vue'

const currentPage = ref('dashboard')
const isSidebarCollapsed = ref(false)
const isDarkMode = ref(false)

const menuItems = [
  { id: 'dashboard', label: 'Dashboard' },
  { id: 'alamat', label: 'Data Alamat' },
  { id: 'paket', label: 'Data Paket' },
  { id: 'sales', label: 'Data Sales' },
  { id: 'pelanggan', label: 'Data Pelanggan' }
]

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value
  localStorage.setItem('darkMode', isDarkMode.value)
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

onMounted(() => {
  const savedMode = localStorage.getItem('darkMode')
  if (savedMode !== null) {
    isDarkMode.value = savedMode === 'true'
  } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    isDarkMode.value = true
  }
  
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
})
</script>
