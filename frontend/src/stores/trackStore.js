import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../services/api'

export const useTrackStore = defineStore('tracks', () => {
  const tracks = ref([])
  const loading = ref(false)
  const error = ref(null)
  const editingTrack = ref(null)

  const fetchTracks = async () => {
    loading.value = true
    error.value = null
    try {
      tracks.value = await api.getTracks()
    } catch (err) {
      error.value = 'Failed to fetch tracks'
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  const createTrack = async (data) => {
    loading.value = true
    error.value = null
    try {
      const response = await api.createTrack(data)
      tracks.value.push(response)
      return { success: true, data: response }
    } catch (err) {
      error.value = err.response?.data?.errors || 'Failed to create track'
      return { success: false, errors: err.response?.data?.errors }
    } finally {
      loading.value = false
    }
  }

  const updateTrack = async (id, data) => {
    loading.value = true
    error.value = null
    try {
      const response = await api.updateTrack(id, data)
      const index = tracks.value.findIndex(t => t.id === id)
      if (index !== -1) {
        tracks.value[index] = response
      }
      return { success: true, data: response }
    } catch (err) {
      error.value = err.response?.data?.errors || 'Failed to update track'
      return { success: false, errors: err.response?.data?.errors }
    } finally {
      loading.value = false
    }
  }

  const setEditingTrack = (track) => {
    editingTrack.value = track ? { ...track } : null
  }

  return {
    tracks,
    loading,
    error,
    editingTrack,
    fetchTracks,
    createTrack,
    updateTrack,
    setEditingTrack
  }
})