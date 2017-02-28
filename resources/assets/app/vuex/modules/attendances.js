import http from '../api';

const actions = {
    async index(_, { session }){
      const {attendances} = http.get(`sessions/${session.id}/attendances`);

      return {attendances}

    },

    async find (_, { session, student }){
      const { attendances } = http.get(`sessions/${session.id}/students/${student.id}/attendances`);

      return { attendances }
    },

    async store (_, { session, payload }) {

        const {attendances} = http.post(`sessions/${session.id}/attendances`, payload);

    }


}

// THE STORE!
export default {
    namespaced: true,
    actions,
}