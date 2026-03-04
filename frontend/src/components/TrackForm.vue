<template>
  <div class="space-y-6">
    <div class="flex items-center space-x-3">
      <div class="p-2 bg-indigo-100 rounded-lg">
        <svg v-if="isEditing" class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <svg v-else class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
      </div>
      <h3 class="text-xl font-semibold text-gray-800">
        {{ isEditing ? 'Edit Track' : 'Add New Track' }}
      </h3>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-5">

      <div class="space-y-4">
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">
            Title <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            v-model="formData.title"
            @blur="validateField('title')"
            :class="[
              'input-field',
              { 'input-error': errors.title }
            ]"
            placeholder="Enter track title"
          />
          <p v-if="errors.title" class="text-sm text-red-500 mt-1 animate-fade-in">
            {{ errors.title }}
          </p>
        </div>

        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">
            Artist <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            v-model="formData.artist"
            @blur="validateField('artist')"
            :class="[
              'input-field',
              { 'input-error': errors.artist }
            ]"
            placeholder="Enter artist name"
          />
          <p v-if="errors.artist" class="text-sm text-red-500 mt-1">
            {{ errors.artist }}
          </p>
        </div>
      </div>

      <div class="space-y-4">
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">
            Duration <span class="text-red-500">*</span>
            <span class="text-xs text-gray-400 ml-2">(mm:ss)</span>
          </label>
          <input
            type="text"
            v-model="durationDisplay"
            @input="handleDurationInput"
            @blur="validateDuration"
            :class="[
              'input-field',
              { 'input-error': errors.duration }
            ]"
            placeholder="03:45"
          />
          <p v-if="errors.duration" class="text-sm text-red-500 mt-1">
            {{ errors.duration }}
          </p>
        </div>

        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">
            ISRC <span class="text-xs text-gray-400 ml-2">(optional)</span>
          </label>
          <input
            type="text"
            v-model="formData.isrc"
            @blur="validateField('isrc')"
            :class="[
              'input-field',
              { 'input-error': errors.isrc }
            ]"
            placeholder="US-ABC-23-00123"
          />
          <p v-if="errors.isrc" class="text-sm text-red-500 mt-1">
            {{ errors.isrc }}
          </p>
          <p class="text-xs text-gray-400 mt-1">
            Format: XX-XXX-XX-XXXXX (e.g., US-ABC-23-00123)
          </p>
        </div>
      </div>

      <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
        <button
          type="button"
          @click="$emit('cancel')"
          class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md shadow-sm hover:bg-gray-300 transition-colors duration-200"
        >
          Cancel
        </button>

        <button
          type="submit"
          class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 flex items-center space-x-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="loading"
        >
          <svg v-if="loading" class="animate-spin w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span>{{ loading ? 'Saving...' : (isEditing ? 'Update Track' : 'Add Track') }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { formatDurationInput, normalizeDuration, secondsToDuration } from '../utils/formatting'
import { parseDuration, validateArtist, validateISRC, validateTitle } from '../utils/validators'

const props = defineProps({
  initialData: {
    type: Object,
    default: () => ({})
  },
  loading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['submit', 'cancel'])

const formData = ref({
  title: '',
  artist: '',
  duration: null,
  isrc: ''
})
const durationDisplay = ref('')
const errors = ref({})
const isEditing = computed(() => !!props.initialData?.id)

const resetForm = () => {
  formData.value = {
    title: '',
    artist: '',
    duration: null,
    isrc: ''
  }
  durationDisplay.value = ''
  errors.value = {}
}

watch(() => props.initialData, (newData) => {
  if (newData && Object.keys(newData).length > 0) {
    formData.value = { ...newData }
    if (newData.duration) {
      durationDisplay.value = secondsToDuration(newData.duration)
    }
  } else {
    resetForm()
  }
}, { immediate: true })

const handleDurationInput = () => {
  const formatted = formatDurationInput(durationDisplay.value)
  durationDisplay.value = normalizeDuration(formatted)
}

const fieldValidators = {
  title: validateTitle,
  artist: validateArtist,
  isrc: validateISRC,
}

const validateField = (field) => {
  const validator = fieldValidators[field]
  const error = validator?.(formData.value[field])
  errors.value[field] = error || null
}

const validateDuration = () => {
  const result = parseDuration(durationDisplay.value)

  if (result.error) {
    errors.value.duration = result.error
    return
  }

  errors.value.duration = null
  formData.value.duration = result.seconds
}

const validateForm = () => {
  validateField('title')
  validateField('artist')
  validateDuration()
  validateField('isrc')

  return !Object.values(errors.value).some(Boolean)
}

const handleSubmit = async () => {
  if (!validateForm()) return

  emit('submit', { ...formData.value })
}
</script>