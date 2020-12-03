<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/player/new" class="btn btn-primary">New</router-link>
        </div>
        <template v-if="players.length">
            <div v-if="errors.length" class="alert alert-danger">
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Team</th>
                    <th colspan="3">Actions</th>
                </tr>
                </thead>

            <tbody>
                <tr v-for="(player,index) in players" :key="index">
                    <td>{{ player.id}}</td>
                    <td>{{ player.name }}</td>
                    <td>{{ player.description}}</td>
                    <td>{{ player.team.name}}</td>
                    <td>
                        <router-link :to="`/player/${player.id}`">Show</router-link>
                    </td>
                    <td>
                        <router-link :to="`/player/${player.id}/edit`">Edit</router-link>
                    </td>
                    <td>
                         <input type="submit" value="Delete"  @click="deletePlayer(player.id,index)" class="btn btn-danger"/>
                    </td>
                </tr>
            </tbody>
        </table>
        </template>
        <template v-else>
          <div class="alert alert-dark">
            There are no Players available
          </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: 'list',
      mounted() {
        if (this.players.length) {
          return;
        }
        this.$store.dispatch('getPlayers');
      },
        data() {
            return {
                errors: [],
            };
        },
        computed:{
            currentUser(){
                return this.$store.getters.currentUser;
            },
            players(){
                return this.$store.getters.players;
            }
        },
        methods:{
          deletePlayer(id,index){
                axios.delete(`/api/player/${id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`,
                    }
                })
                .then(res => {
                    if(this.players && this.players.length > 0) {
                        this.players.splice(index, 1);
                    }
                    this.$store.commit('updatePlayers', res.data.data);
                })
                .catch(err => { console.error(err) })
            },
        }
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

</style>
