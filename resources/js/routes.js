import Home from './components/Home.vue';
import Register from './components/Auth/Register.vue';
import Login from './components/Auth/Login.vue';


import TeamMain from './components/Teams/Main.vue';
import TeamList from './components/Teams/List.vue';
import TeamNew from './components/Teams/New.vue';
import Team from './components/Teams/Show.vue';
import TeamEdit from './components/Teams/Edit.vue';

import PlayerMain from './components/Players/Main.vue';
import PlayerList from './components/Players/List.vue';
import PlayerNew from './components/Players/New.vue';
import Player from './components/Players/Show.vue';
import PlayerEdit from './components/Players/Edit.vue';


import UsersMain from './components/Users/Main.vue';
import UserList from './components/Users/List.vue';
import UserNew from './components/Users/New.vue';
import User from './components/Users/Show.vue';
import UserEdit from './components/Users/Edit.vue';


export const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/register',
        component: Register,
    },
    {
        path: '/login',
        component: Login,
    },
    {
        path: '/team',
        component: TeamMain,
        children:[
            {
                path:'/',
                component:TeamList
            },
            {
                path:'new',
                component:TeamNew
            },
            {
                path:':id',
                component:Team
            },
            {
                path:':id/edit',
                component:TeamEdit
            },


        ]
    },
    {
        path: '/player',
        component: PlayerMain,
        children:[
            {
                path:'/',
                component:PlayerList
            },
            {
                path:'new',
                component:PlayerNew
            },
            {
                path:':id',
                component:Player
            },
            {
                path:':id/edit',
                component:PlayerEdit
            },
        ]
    },
    {
        path: '/users',
        component: UsersMain,
        children:[
            {
                path:'/',
                component:UserList
            },
            {
                path:'new',
                component:UserNew
            },
            {
                path:':id',
                component:User
            },
            {
                path:':id/edit',
                component:UserEdit
            },
        ]
    },
]
