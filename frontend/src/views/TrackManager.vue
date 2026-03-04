<template>
  <div class="space-y-8 relative">
    <div class="card overflow-hidden">
      <TrackList
        :tracks="trackStore.tracks"
        :loading="trackStore.loading"
        :error="trackStore.error"
        @add="startAddNew"
        @edit="handleEdit"
        @refresh="trackStore.fetchTracks"
      />
    </div>

    <transition name="fade">
      <div
        v-if="showForm"
        class="fixed inset-0 bg-black/50 z-40"
        @click.self="cancelForm"
      ></div>
    </transition>

    <transition name="slide-down">
      <div
        v-if="showForm"
        class="fixed inset-0 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md relative">
          <button
            @click="cancelForm"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <TrackForm
            :initial-data="trackStore.editingTrack"
            :loading="trackStore.loading"
            @submit="handleFormSubmit"
            @cancel="cancelForm"
          />
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useTrackStore } from '../stores/trackStore'
import TrackForm from '../components/TrackForm.vue'
import TrackList from '../components/TrackList.vue'

const trackStore = useTrackStore()
const showForm = ref(false)

onMounted(() => {
  trackStore.fetchTracks()
})

const startAddNew = () => {
  trackStore.setEditingTrack(null)
  showForm.value = true
}

const handleEdit = (track) => {
  trackStore.setEditingTrack(track)
  showForm.value = true
}

const handleFormSubmit = async (formData) => {
  let result
  
  if (trackStore.editingTrack?.id) {
    result = await trackStore.updateTrack(trackStore.editingTrack.id, formData)
  } else {
    result = await trackStore.createTrack(formData)
  }
  
  if (result.success) {
    showForm.value = false
    trackStore.setEditingTrack(null)
  } else {
    console.error('Failed to save track:', result.errors)
  }
}

const cancelForm = () => {
  showForm.value = false
  trackStore.setEditingTrack(null)
}
</script>

<style>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.fade-enter-to, .fade-leave-from { opacity: 1; }

.slide-down-enter-active { transition: all 0.3s ease-out; }
.slide-down-enter-from { transform: translateY(-10px); opacity: 0; }
.slide-down-enter-to { transform: translateY(0); opacity: 1; }
.slide-down-leave-active { transition: all 0.2s ease-in; }
.slide-down-leave-from { transform: translateY(0); opacity: 1; }
.slide-down-leave-to { transform: translateY(-10px); opacity: 0; }
</style>