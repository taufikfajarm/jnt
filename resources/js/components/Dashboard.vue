<template>
  <div class="space-y-8 animate-in fade-in duration-700">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 font-medium mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
          <span>Statistik Real-time</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Dashboard Pelanggan</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400 font-medium italic">Pantau pertumbuhan bisnis WiFi anda hari ini.</p>
      </div>
      <div class="flex items-center gap-2 text-xs font-bold px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400">
         <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
         Live Updates Terhubung
      </div>
    </header>

    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Card: Total Pelanggan -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-50 dark:border-gray-700 transition-all hover:shadow-xl hover:shadow-blue-500/5 group relative overflow-hidden">
        <div class="absolute -right-6 -top-6 h-24 w-24 bg-blue-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex items-center justify-between mb-4 relative">
          <div class="p-3 bg-blue-50 dark:bg-blue-400/10 text-blue-600 dark:text-blue-400 rounded-xl">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
          </div>
        </div>
        <div class="space-y-1 relative">
           <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Total Pelanggan</p>
           <h2 class="text-3xl font-black text-gray-900 dark:text-white leading-tight mt-1">{{ stats.totalPelanggan }}</h2>
           <p class="text-xs font-medium text-blue-500 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7 7 7" /></svg>
              {{ stats.newToday }} pendaftar baru
           </p>
        </div>
      </div>

      <!-- Card: Aktif -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-50 dark:border-gray-700 transition-all hover:shadow-xl hover:shadow-emerald-500/5 group relative overflow-hidden">
        <div class="absolute -right-6 -top-6 h-24 w-24 bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex items-center justify-between mb-4">
          <div class="p-3 bg-emerald-50 dark:bg-emerald-400/10 text-emerald-600 dark:text-emerald-400 rounded-xl">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          </div>
        </div>
        <div class="space-y-1">
           <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Pelanggan Aktif</p>
           <h2 class="text-3xl font-black text-gray-900 dark:text-white leading-tight mt-1">{{ stats.aktif }}</h2>
           <div class="w-full bg-emerald-100 dark:bg-emerald-400/10 h-1.5 rounded-full mt-3 overflow-hidden">
             <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" :style="{ width: stats.activeRate + '%' }"></div>
           </div>
           <p class="text-[10px] text-gray-400 mt-1.5 font-bold uppercase">{{ stats.activeRate }}% dari total</p>
        </div>
      </div>

      <!-- Card: Revenue -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-50 dark:border-gray-700 transition-all hover:shadow-xl hover:shadow-indigo-500/5 group relative overflow-hidden">
        <div class="absolute -right-6 -top-6 h-24 w-24 bg-indigo-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex items-center justify-between mb-4">
          <div class="p-3 bg-indigo-50 dark:bg-indigo-400/10 text-indigo-600 dark:text-indigo-400 rounded-xl">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1m4-12H8a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2z" /></svg>
          </div>
        </div>
        <div class="space-y-1">
           <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Estimasi Pendapatan</p>
           <h2 class="text-2xl font-black text-gray-900 dark:text-white leading-tight mt-1">Rp {{ formatCurrency(stats.revenue) }}</h2>
           <p class="text-[10px] text-indigo-500 mt-2 font-bold uppercase">Prediksi Bulanan</p>
        </div>
      </div>

      <!-- Card: Wilayah -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-50 dark:border-gray-700 transition-all hover:shadow-xl hover:shadow-amber-500/5 group relative overflow-hidden">
        <div class="absolute -right-6 -top-6 h-24 w-24 bg-amber-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex items-center justify-between mb-4">
          <div class="p-3 bg-amber-50 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 rounded-xl">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
          </div>
        </div>
        <div class="space-y-1">
           <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Cakupan Wilayah</p>
           <h2 class="text-3xl font-black text-gray-900 dark:text-white leading-tight mt-1">{{ stats.totalDesa }} <span class="text-sm font-bold text-gray-400">Desa</span></h2>
           <p class="text-[10px] text-amber-500 mt-2 font-bold uppercase">{{ stats.totalKecamatan }} Kecamatan Terlayani</p>
        </div>
      </div>
    </div>

    <!-- Charts and Table Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left: Distribution Charts -->
      <div class="lg:col-span-2 space-y-8">
        <!-- Popular Packages Chart -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
          <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold dark:text-white tracking-tight">Eksplorasi Paket Populer</h3>
            <span class="px-3 py-1 bg-blue-50 dark:bg-blue-400/10 text-blue-500 rounded-lg text-xs font-bold uppercase">Trend Layanan</span>
          </div>
          <div class="space-y-6">
            <div v-for="paket in stats.paketDist" :key="paket.name" class="space-y-2">
              <div class="flex justify-between items-end">
                <span class="text-sm font-bold dark:text-gray-300">{{ paket.name }}</span>
                <span class="text-xs font-black text-blue-500">{{ paket.count }} User</span>
              </div>
              <div class="h-2.5 w-full bg-gray-100 dark:bg-gray-900 rounded-full overflow-hidden">
                <div 
                  class="h-full bg-gradient-to-r from-blue-600 to-indigo-500 rounded-full transition-all duration-1000"
                  :style="{ width: stats.totalPelanggan ? (paket.count / stats.totalPelanggan * 100) + '%' : '0%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sales Performance Chart -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
          <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold dark:text-white tracking-tight">Performa Sales</h3>
            <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-400/10 text-indigo-500 rounded-lg text-xs font-bold uppercase">Distribusi Pelanggan</span>
          </div>
          <div class="space-y-6">
            <div v-for="s in stats.salesDist" :key="s.name" class="space-y-2">
              <div class="flex justify-between items-end">
                <span class="text-sm font-bold dark:text-gray-300">{{ s.name }}</span>
                <div class="flex items-center space-x-2">
                   <span class="text-[10px] text-gray-400 font-medium">{{ s.no_hp }}</span>
                   <span class="text-xs font-black text-indigo-500">{{ s.count }} Pelanggan</span>
                </div>
              </div>
              <div class="h-2.5 w-full bg-gray-100 dark:bg-gray-900 rounded-full overflow-hidden">
                <div 
                  class="h-full bg-gradient-to-r from-indigo-600 to-purple-500 rounded-full transition-all duration-1000"
                  :style="{ width: stats.totalPelanggan ? (s.count / stats.totalPelanggan * 100) + '%' : '0%' }"
                ></div>
              </div>
            </div>
            <div v-if="stats.salesDist.length === 0" class="py-10 text-center text-xs text-gray-400 italic">
               Belum ada data sales.
            </div>
          </div>
        </div>

        <!-- Recent Registrations -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
          <div class="p-8 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
            <h3 class="text-lg font-bold dark:text-white tracking-tight">Pendaftaran Terbaru</h3>
            <button class="text-xs font-bold text-blue-500 hover:text-blue-600 uppercase tracking-widest transition-colors">Lihat Semua Data</button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-gray-900/10">
                  <th class="px-8 py-4">Nama Pelanggan</th>
                  <th class="px-8 py-4">Paket</th>
                  <th class="px-8 py-4">Wilayah</th>
                  <th class="px-12 py-4">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                <tr v-for="item in stats.recent" :key="item.id" class="group hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                  <td class="px-8 py-4">
                    <div class="flex items-center space-x-3">
                      <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center text-[10px] font-bold text-gray-400 group-hover:scale-110 transition-transform">
                        {{ item.nama.charAt(0) }}
                      </div>
                      <span class="text-sm font-bold dark:text-white">{{ item.nama }}</span>
                    </div>
                  </td>
                  <td class="px-8 py-4">
                    <span class="text-[11px] font-bold text-indigo-500 uppercase">{{ item.paket?.nama_paket }}</span>
                  </td>
                   <td class="px-8 py-4">
                    <div class="flex flex-col">
                      <span class="text-xs font-bold dark:text-gray-300">{{ item.desa?.nama || '-' }}</span>
                      <span class="text-[9px] text-gray-400 dark:text-gray-500 tracking-tighter">
                        {{ item.desa?.kecamatan?.nama }}, {{ item.desa?.kecamatan?.kabupaten?.nama }}
                      </span>
                    </div>
                  </td>
                  <td class="px-12 py-4">
                    <span :class="getStatusClass(item.status_langganan)" class="px-2 py-0.5 rounded-lg text-[10px] font-bold capitalize">
                      {{ item.status_langganan }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Right: Subscriptions Breakdown -->
      <div class="space-y-8">
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-3xl shadow-xl shadow-blue-500/20 text-white relative overflow-hidden">
          <div class="absolute -right-10 -bottom-10 h-40 w-40 bg-white/10 rounded-full blur-3xl"></div>
          <div class="relative">
             <h3 class="text-lg font-bold mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 21a10.003 10.003 0 008.384-4.51l.054.09m-4.285-10.76A10.023 10.023 0 0116.254 9" /></svg>
                Snapshot Layanan
             </h3>
             <div class="space-y-6">
                <div class="flex items-center justify-between">
                   <span class="text-sm font-bold opacity-80 uppercase tracking-widest text-[10px]">Pendaftar Bulan Ini</span>
                   <span class="text-2xl font-black">{{ stats.newToday }}</span>
                </div>
                <div class="h-px bg-white/20"></div>
                <div class="flex items-center justify-between">
                   <span class="text-sm font-bold opacity-80 uppercase tracking-widest text-[10px]">Isolir / Bermasalah</span>
                   <span class="text-2xl font-black text-amber-300">{{ stats.isolir }}</span>
                </div>
                <div class="h-px bg-white/20"></div>
                <div class="flex items-center justify-between">
                   <span class="text-sm font-bold opacity-80 uppercase tracking-widest text-[10px]">Total Desa Tercover</span>
                   <span class="text-2xl font-black">{{ stats.totalDesa }}</span>
                </div>
             </div>
             <button class="w-full mt-8 py-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold rounded-2xl transition-all uppercase tracking-widest">Atur Tagihan</button>
          </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
           <h3 class="text-sm font-black dark:text-white uppercase tracking-widest mb-6 opacity-40">Status Koneksi</h3>
           <div class="space-y-5">
              <div v-for="stat in connectionStats" :key="stat.label" class="flex items-center justify-between">
                 <div class="flex items-center space-x-3">
                    <div :class="stat.color" class="h-2 w-2 rounded-full shadow-[0_0_8px] shadow-current"></div>
                    <span class="text-xs font-bold dark:text-gray-300">{{ stat.label }}</span>
                 </div>
                 <span class="text-xs font-black dark:text-white">{{ stat.value }}</span>
              </div>
           </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { supabase } from '../utils/supabase'

const stats = ref({
  totalPelanggan: 0,
  aktif: 0,
  activeRate: 0,
  revenue: 0,
  totalDesa: 0,
  totalKecamatan: 0,
  newToday: 0,
  isolir: 0,
  paketDist: [],
  salesDist: [],
  recent: []
})

const connectionStats = computed(() => [
  { label: 'Koneksi Stabil', value: stats.value.aktif, color: 'text-emerald-500 bg-emerald-500' },
  { label: 'Terlambat Bayar', value: stats.value.isolir, color: 'text-amber-500 bg-amber-500' },
  { label: 'Layanan Terhenti', value: stats.value.totalPelanggan - stats.value.aktif - stats.value.isolir, color: 'text-gray-400 bg-gray-400' }
])

const fetchData = async () => {
  // Parallel fetch for speed
  const [
    { data: p },
    { data: desas },
    { data: kecs },
    { data: pkts },
    { data: sales }
  ] = await Promise.all([
    supabase.from('pelanggans').select('*, paket:pakets(*), sales:sales(*), desa:desas(nama, kecamatan:kecamatans(nama, kabupaten:kabupatens(nama)))'),
    supabase.from('desas').select('id'),
    supabase.from('kecamatans').select('id'),
    supabase.from('pakets').select('*'),
    supabase.from('sales').select('*')
  ])

  if (!p) return

  const total = p.length
  const aktif = p.filter(c => c.status_langganan === 'aktif').length
  const isolir = p.filter(c => c.status_langganan === 'isolir').length
  
  // Calculate Revenue (Sum price of active packages)
  const revenue = p.filter(c => c.status_langganan === 'aktif').reduce((sum, c) => sum + (c.paket?.harga || 0), 0)
  
  // Package distribution logic
  const distMap = {}
  pkts.forEach(pk => distMap[pk.nama_paket] = 0)
  p.forEach(c => {
    if (c.paket?.nama_paket) distMap[c.paket.nama_paket]++
  })
  
  const paketDist = Object.keys(distMap).map(name => ({
    name,
    count: distMap[name]
  })).sort((a,b) => b.count - a.count)

  // Sales distribution logic
  const salesMap = {}
  if (sales) {
    sales.forEach(s => salesMap[s.id] = { name: s.nama, no_hp: s.no_hp, count: 0 })
    p.forEach(c => {
      if (c.sales_id && salesMap[c.sales_id]) salesMap[c.sales_id].count++
    })
  }
  const salesDist = Object.values(salesMap).sort((a,b) => b.count - a.count)

  // Recent 5
  // Note: we'll sort manually if created_at is available, or just take first 5 for now
  const recent = [...p].sort((a,b) => new Date(b.created_at) - new Date(a.created_at)).slice(0, 5)

  // Today's new (mocked as registrations from last 30 days for visual effect in dummy)
  const thirtyDaysAgo = new Date()
  thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30)
  const newThisMonth = p.filter(c => new Date(c.tanggal_daftar) >= thirtyDaysAgo).length

  stats.value = {
    totalPelanggan: total,
    aktif: aktif,
    activeRate: total ? Math.round((aktif / total) * 100) : 0,
    revenue: revenue,
    totalDesa: desas?.length || 0,
    totalKecamatan: kecs?.length || 0,
    newToday: newThisMonth,
    isolir: isolir,
    paketDist: paketDist,
    salesDist: salesDist,
    recent: recent
  }
}

const getStatusClass = (s) => {
  switch (s) {
    case 'aktif': return 'bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-400';
    case 'isolir': return 'bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-400';
    default: return 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400';
  }
}

const formatCurrency = (n) => new Intl.NumberFormat('id-ID').format(n)

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.animate-in {
  animation: fadeIn 0.8s ease-out forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
