<template>
  <div class="min-h-[300px]">
    <div v-if="loading" class="flex flex-col items-center justify-center py-16">
      <div class="relative">
        <div class="w-16 h-16 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center">
          <svg class="w-8 h-8 text-indigo-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
          </svg>
        </div>
      </div>
      <p class="mt-4 text-gray-500 font-medium">Loading your tracks...</p>
    </div>

    <div v-else-if="error" class="bg-red-50 p-8 text-center rounded-lg">
      <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
      <h3 class="text-lg font-semibold text-red-800 mb-2">Oops! Something went wrong</h3>
      <p class="text-red-600 mb-4">{{ error }}</p>
      <button @click="$emit('refresh')" class="btn-primary inline-flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span>Try Again</span>
      </button>
    </div>

    <div v-else-if="tracks.length === 0" class="py-16 text-center">
      <div class="inline-block p-4 bg-indigo-50 rounded-full mb-4">
        <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
      </div>
      <h3 class="text-xl font-semibold text-gray-700 mb-2">No tracks yet</h3>
      <p class="text-gray-500 mb-6">Start building your music collection by adding your first track!</p>
      <button @click="$emit('add')" class="mx-auto flex items-center gap-1 px-3 py-1.5 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 shadow-sm transition-colors duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Add Track</span>
      </button>
    </div>

    <template v-else>
      <div class="flex justify-between items-center mb-6">
        <div>
          <h2 class="text-2xl font-bold text-gray-800 mb-1">Your Tracks</h2>
          <p class="text-gray-500 text-sm">Manage your music collection</p>
        </div>
        <button
          @click="$emit('add')"
          class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 transition"
        >
          <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          <span>Add New Track</span>
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-gray-50 border-b-2 border-gray-200">
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Artist</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ISRC</th>
              <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr
              v-for="track in tracks"
              :key="track.id"
              class="hover:bg-indigo-50 transition-colors duration-150 group text-sm"
            >
              <td class="px-6 py-4 text-gray-900 font-medium">{{ track.title }}</td>
              <td class="px-6 py-4 text-gray-700 font-mono text-gray-600">{{ track.artist }}</td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full font-medium bg-indigo-100 text-indigo-800">
                  <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ formatDuration(track.duration) }}
                </span>
              </td>
              <td class="px-6 py-4">
                <span v-if="track.isrc" class="font-mono text-gray-600">{{ track.isrc }}</span>
                <span v-else class="text-gray-400">—</span>
              </td>
              <td class="px-6 py-4 text-right">
                <button @click="$emit('edit', track)" class="inline-flex items-center space-x-1 text-indigo-600 hover:text-indigo-800 font-medium">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  <span>Edit</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </div>
</template>

<script setup>
import { secondsToDuration } from '../utils/formatting'

defineProps({
  tracks: {
    type: Array,
    default: () => []
  },
  loading: {
    type: Boolean,
    default: false
  },
  error: {
    type: String,
    default: null
  }
})

defineEmits(['add', 'edit', 'refresh'])

const formatDuration = (seconds) => {
  return secondsToDuration(seconds)
}
</script>