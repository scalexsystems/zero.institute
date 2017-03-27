import http from '../api';

const actions = {
    async index(_, { session }){
      const {attendances} = await http.get(`sessions/${session.id}/attendances`);

      return {attendances}

    },

    async find (_, { sessionId, student }){
      const { attendances } = await http.get(`sessions/${sessionId}/students/${student.person.uid}/attendances`);

      return { attendances };
    },

    async store (_, { session, attendance } ) {

        await http.post(`sessions/${session.id}/attendances`, attendance);

    }

}

// THE STORE!
export default {
    namespaced: true,
    actions,
}