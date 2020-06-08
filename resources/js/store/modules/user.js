export default {
    actions:{
        login(cxt,user){
            cxt.commit('updateUser',user);
        },
        logout({commit}) {
            commit('logoutUser');
        },
    },
    mutations:{
        updateUser(state,user){
            state.user = user;
        },
        logoutUser(state){
            state.user = null;
            console.log("USER_FROM_VUEX:"+state.user);
        }
    },
    state:{
        user:null
    },
    getters:{
        getUser(state){
            return state.user;
        },isAdmin(state){
            if(state.user===null)
                return false;
            else if(state.user.roles.length>0)
                if(state.user.roles[0].name ==='admin'){
                    return true;
                }
            return false;
        },isAuth(state){
            return state.user !== null;
        }
    }

}
