<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500">
    <div class="max-w-6xl mx-auto px-6 py-10">
      <header class="text-center mb-10">
        <h1 class="text-4xl font-bold text-white drop-shadow-lg">
          <a href="/" class="inline-flex items-center justify-center gap-2 hover:opacity-80 transition">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-10 h-10 text-white"
                fill="currentColor"
                viewBox="0 0 24 24">
              <path d="M12 3v10.55A4 4 0 1014 17V7h4V3h-6z"/>
            </svg>
            Synchtank
          </a>
        </h1>
      </header>
      <main class="bg-white rounded-2xl shadow-2xl p-8">
        <TrackManager />
      </main>
    </div>
  </div>
</template>

<script setup>
  import TrackManager from './views/TrackManager.vue'
</script>