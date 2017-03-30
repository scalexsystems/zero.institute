import http from '../api';

const state = () => {}

const actions = {
    async index(_, { session }){
      const {attendances} = await http.get(`sessions/${session.id}/attendances`);

      return {attendances}

    },

    async find (_, { sessionId, student }){
      const { attendances } = await http.get(true, `sessions/${sessionId}/students/${student.person.uid}/attendances`);
      return { attendances };
    },

    async store (_, { session, attendance } ) {

        await http.post(`sessions/${session.id}/attendances`, attendance);

    },

    async getAggregates ({ dispatch }) {
        const { attendances } = await http.get(`attendances`)
        return { attendances }
    },
}

export default {
    namespaced: true,
    actions,
    state: state()
}