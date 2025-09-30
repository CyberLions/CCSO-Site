<template>
  <div class="min-h-screen">
    <section class="home-about py-12">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Lockpicking Leaderboard/&gt;</h2>

        <div v-if="loading" class="text-seasalt/80">Loading leaderboard…</div>
        <div v-else>
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <div v-for="category in categories" :key="category" class="bg-black/40 border border-slate-800 rounded-lg p-4">
              <h3 class="text-xl font-semibold text-naplesyellow mb-3">
                {{ categoryLabels[category] || category }}
              </h3>

              <table class="min-w-full text-left text-seasalt/90">
                <thead>
                  <tr class="text-sm text-seasalt/60">
                    <th class="py-2 pr-2">Rank</th>
                    <th class="py-2 pr-2">Name</th>
                    <th class="py-2 pr-2">Time</th>
                    <th class="py-2 pr-2">Lock #</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="(groupedByCategory[category] || []).length === 0">
                    <td colspan="4" class="py-3 text-seasalt/60">No attempts yet.</td>
                  </tr>
                  <tr v-for="(entry, idx) in groupedByCategory[category]" :key="entry.id || idx" class="border-t border-slate-800/60">
                    <td class="py-2 pr-2 w-14">#{{ idx + 1 }}</td>
                    <td class="py-2 pr-2">{{ entry.name }}</td>
                    <td class="py-2 pr-2 font-mono">{{ formatTime(entry.time) }}</td>
                    <td class="py-2 pr-2">{{ entry.lock_number || '—' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
</template>

<script setup>
import { onMounted } from 'vue'
import { useLockpickingLeaderboards } from '@/composables/useStrapi'

const categoryLabels = {
  handcuffs: 'Handcuffs (Front)',
  handcuffs_back: 'Handcuffs (Behind Back)',
  handcuffs_double_locked: 'Handcuffs (Double Locked)',
  pin_3: '3-Pin Lock',
  pin_4: '4-Pin Lock',
  pin_5: '5-Pin Lock'
}

const { loading, loadLeaderboards, groupedByCategory, categories, formatTime } = useLockpickingLeaderboards()

onMounted(async () => {
  await loadLeaderboards({ pagination: { pageSize: 1000 } })
})
</script>

<style scoped>
.section-title {
  margin-bottom: 1.25rem;
}
</style>


