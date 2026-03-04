import axios from 'axios'

const client = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json'
  }
})

const unwrap = (res) => res.data.data

export default {
  async getTracks() {
    return unwrap(await client.get('/tracks'))
  },

  async createTrack(data) {
    return unwrap(await client.post('/tracks', data))
  },

  async updateTrack(id, data) {
    return unwrap(await client.put(`/tracks/${id}`, data))
  }
}