import {getLoggedinUser} from './auth'

const user = getLoggedinUser();
export default {
    state:{
        welcome:"Welcome to my App",
        currentUser:user,
        auth_error:null,
        registeredUser: null,
        reg_error:null,
        teams:[],
        players:[],
        users:[],
        isLogged:false,
    },
    getters:{
        welcome(state){
            return state.welcome;
        },
        currentUser(state){
            return state.currentUser
        },
        authError(state){
            return state.auth_error
        },
        isLogged(state){
            return state.isLogged
        },
        regError(state){
            return state.reg_error;
        },
        registeredUser(state){
            return state.registeredUser;
        },
        teams(state){
            return state.teams
        },
        players(state){
            return state.players
        },
        users(state){
            return state.users
        },
    },
    mutations:{
        login(state) {
            state.auth_error = null;
        },
        loginSuccess(state,payload){
            state.auth_error = null
            state.isLogged = true
            state.currentUser = Object.assign({},payload.user,{token:payload.token})
            localStorage.setItem('user',JSON.stringify(state.currentUser))
        },
        loginFailed(state,payload){
            state.auth_error = payload.data.error
        },
        regFailed(state,payload){
            state.reg_error = payload.error
        },
        regSuccess(state,payload){
            state.reg_error = null
            state.registeredUser = payload.user;
        },
        logout(state){
            state.isLogged = false
            localStorage.removeItem('user')
            state.currentUser = null
        },
        updateTeams(state,payload){
            state.teams = payload
        },
        updatePlayers(state,payload){
            state.players = payload
        },
        updateUsers(state,payload){
            state.users = payload
        },
    },
    actions:{
        login(context){
            context.commit('login')
        },
        getTeams(context){
            axios.get('/api/team',{
                headers:{
                    'Authorization':`Bearer ${context.state.currentUser.token}`
                }
            })
                .then((response) => {
                    context.commit('updateTeams', response.data.data);
                })
        },
        getUsers(context){
            axios.get('/api/users',{
                headers:{
                    'Authorization':`Bearer ${context.state.currentUser.token}`
                }
            })
                .then((response) => {
                    context.commit('updateUsers', response.data.data);
                })
        },
        getPlayers(context){
            axios.get('/api/player',{
                headers:{
                    'Authorization':`Bearer ${context.state.currentUser.token}`
                }
            })
                .then((response) => {
                    context.commit('updatePlayers', response.data.data);
                })
        },
    }
};
