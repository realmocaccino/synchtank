export const durationToSeconds = (durationStr) => {
  if (!durationStr) return null
  const parts = durationStr.split(':')
  if (parts.length === 2) {
    const minutes = parseInt(parts[0], 10)
    const seconds = parseInt(parts[1], 10)
    if (!isNaN(minutes) && !isNaN(seconds)) {
      return minutes * 60 + seconds
    }
  }
  return null
}

export function formatDurationInput(value) {
  if (!value) return ''
  const digits = value.replace(/\D/g, '').slice(0, 4)
  if (digits.length <= 2) {
    return digits
  }
  return digits.slice(0, 2) + ':' + digits.slice(2)
}

export function normalizeDuration(value) {
  if (!value) return ''
  const [minutes = '', seconds = ''] = value.split(':')
  let safeMinutes = minutes.slice(0, 2)
  let safeSeconds = seconds.slice(0, 2)
  if (safeSeconds.length === 2) {
    const secNumber = parseInt(safeSeconds, 10)
    if (!isNaN(secNumber) && secNumber > 59) {
      safeSeconds = '59'
    }
  }
  return safeSeconds
    ? `${safeMinutes}:${safeSeconds}`
    : safeMinutes
}

export const secondsToDuration = (seconds) => {
  if (!seconds && seconds !== 0) return ''
  const mins = Math.floor(seconds / 60)
  const secs = seconds % 60
  return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`
}