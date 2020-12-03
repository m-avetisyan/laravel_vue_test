<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/team/new" class="btn btn-primary">Add New</router-link>
        </div>
        <template v-if="teams.length">
            <ul>
                <TeamsTree :dataTree="teams"></TeamsTree>
            </ul>
        </template>
        <template v-else>
            <div class="alert alert-dark">
                There are no Teams available
            </div>
        </template>
    </div>
</template>

<script>
import TeamsTree from "./TeamsTree";

export default {
    name: 'list',
    components:{
      TeamsTree
    },
    mounted() {
        if (this.teams.length) {
            return;
        }
        this.$store.dispatch('getTeams');
    },
    computed:{
        currentUser(){
            return this.$store.getters.currentUser;
        },
        teams(){
            return this.$store.getters.teams;
        }
    },
}
</script>
<style scoped>

.btn-wrapper {
    text-align: right;
    margin-bottom: 20px;
}
table thead, table tbody{
    text-align:center!important
}
table tr td{
    vertical-align:middle
}
.table thead th{
    text-align:center
}
.list-group-collapse
{
    overflow: hidden;
}

.list-group-collapse li  ul {
    margin-left: -15px;
    margin-right: -15px;
    margin-bottom: -11px;
    border-radius: 0px;
}

.list-group-collapse li ul
{
    border-radius: 0px !important;
    margin-top: 8px;
}

.list-group-collapse li  ul li {
    border-radius: 0px !important;
    border-left: none;
    border-right: none;
    padding-left: 32px;
}

#subgroup
{
    display: none;
}
.slide-enter-active {
    -moz-transition-duration: 0.7s;
    -webkit-transition-duration: 0.7s;
    -o-transition-duration: 0.7s;
    transition-duration: 0.7s;
    -moz-transition-timing-function: linear;
    -webkit-transition-timing-function: linear;
    -o-transition-timing-function: linear;
    transition-timing-function: linear;
}

.slide-leave-active {
    -moz-transition-duration: 0.7s;
    -webkit-transition-duration: 0.7s;
    -o-transition-duration: 0.7s;
    transition-duration: 0.7s;
    -moz-transition-timing-function: linear;
    -webkit-transition-timing-function: linear;
    -o-transition-timing-function: linear;
    transition-timing-function: linear
}

.slide-enter-to, .slide-leave {
    max-height: 100px;
    overflow: hidden;
}

.slide-enter, .slide-leave-to {
    overflow: hidden;
    max-height: 0;
}
</style>
