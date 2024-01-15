import { createStore } from 'vuex';
import router from "@/router";

const store = createStore({
    state () {
        return {
            token: localStorage.getItem('token') || 0,
            user: '',
            products: [],
            layout: 'publicLayout',
            toggleMenu: false,
        }
    },
    mutations: {
        UPDATE_TOKEN(state, payload){
            state.token = payload
        },
        UPDATE_USER(state, payload) {
            state.user = payload
        },
        UPDATE_LAYOUT(state, payload) {
            state.layout = payload
        },
        UPDATE_TOGGLE_NAV(state, payload) {
            state.toggleMenu = payload
        }
    },

    actions: {
        setToken(context, payload) {
            localStorage.setItem('token', payload);
            context.commit('UPDATE_TOKEN', payload);
        },

        setUser(context, payload) {
            localStorage.setItem('user', JSON.stringify(payload));
            context.commit('UPDATE_USER', payload);
        },

        // removeUser(context) {
        //     localStorage.removeItem('user');
        //     context.commit('UPDATE_USER', {});
        //     router.push({name: 'Login'})
        // },

        removeToken(context) {
            // context.commit('REMOVE_TOKEN');
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN', 0);
            router.push({name: 'Login'})
        },

        toggleNav(context, payload) {
          context.commit('UPDATE_TOGGLE_NAV', payload);
        },

        setLayout(context, payload) {
            context.commit('UPDATE_LAYOUT', payload);
        }
    },

    getters: {
        getToken: (state) => {
            return state.token;
        },
        getLayout: (state) => {
            return state.layout;
        }
    }
});

export default store;
