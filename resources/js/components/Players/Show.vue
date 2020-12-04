<template>
    <div  v-if="player">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ player.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ player.name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ player.description }}</td>
                </tr>
                <tr>
                    <th>Team Name</th>
                    <td>{{ player.team.name }}</td>
                </tr>
            </table>
            <router-link to="/player">Back to all players</router-link>
            <div v-if="errors.length" class="alert alert-danger">
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
    </div>
</template>

<script>
    export default {
        name: 'show',
        mounted() {
                axios.get(`/api/player/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.player = response.data.data;
                });
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        data() {
            return {
                player: [],
                errors:[],
            };
        },

    }
</script>
<style scoped>

    .player-view {
        display: flex;
        align-items: center;
    }

</style>
