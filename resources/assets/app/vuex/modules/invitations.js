import http from '../api';


const actions = {
  async store({ dispatch }, payload){
    try {
      return await http.post(true, 'people/invite', payload);
    } catch (e) {
      return e;
    }
  }
}


export default {
  namespaced: true,
  actions,
}