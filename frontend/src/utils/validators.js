import { durationToSeconds } from './formatting'

export const isValidISRC = (isrc) => {
  if (!isrc || isrc.trim() === '') return true
  const pattern = /^[A-Z]{2}-[A-Z0-9]{3}-\d{2}-\d{5}$/
  return pattern.test(isrc)
}

export function parseDuration(duration) {
  if (!duration) {
    return { error: 'Duration is required' }
  }
  const seconds = durationToSeconds(duration)
  if (seconds === null || seconds < 0 || seconds > 5999) {
    return { error: 'Invalid duration. Use mm:ss (max 99:59)' }
  }
  return { seconds }
}

export function validateTitle(title) {
  if (!title?.trim()) {
    return 'Title is required'
  }
}

export function validateArtist(artist) {
  if (!artist?.trim()) {
    return 'Artist is required'
  }
}

export function validateISRC(isrc) {
  if (isrc && !isValidISRC(isrc)) {
    return 'Invalid ISRC format. Use: XX-XXX-XX-XXXXX'
  }
}