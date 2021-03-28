import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
    tags: [],
}

export const getters = {
    tags: state => state.tags,
}

export const actions = {
    async fetchTags ({ commit }) {
        const { data:tags } = await axios.get('/tags')

        commit(types.FETCH_TAGS, tags)
    },
}

export const mutations = {
    [types.FETCH_TAGS] (state, payload) {
        console.log('payload', payload);
        state.tags = payload
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
