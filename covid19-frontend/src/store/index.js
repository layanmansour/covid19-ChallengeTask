import { createStore } from "vuex";

let store = createStore({
    state:{
        sorted:'asc',
    },
    getters:{
        getSortingMethod(state)
        {
            return state.sorted;
        }
    },
    mutations:{
        setSortMethodMutation(state)
        {
            state.sorted = state.sorted === 'asc' ? 'desc':'asc';
        }
    },
    actions:{
        setSortMethodAction(state)
        {

            //commit('setSortMethodMutation');
            state.sorted = state.sorted === 'asc' ? 'desc':'asc';
        }
    },

});

export default store;

