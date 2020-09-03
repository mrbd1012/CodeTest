import Vue from 'vue';
import Vuex from 'vuex';
import router from "./router";

Vue.use(Vuex);

 let store =  new Vuex.Store({
    state: {
        isLogin: null,
        apiURL: 'http://localhost:8000/api',
        serverPath: 'http://localhost:8000',
        profile: {

        },
    },
    mutations: {
        authenticate(state, payload){
            state.isLogin = localStorage.getItem("code-test-user-token");
            if(state.isLogin != null){
                state.profile = payload;
            } else {
                state.profile = {};
            }
        }
    },
    actions: {
        authenticate(context, payload){
            context.commit('authenticate', payload);
        }
    }
});

 export default store;
