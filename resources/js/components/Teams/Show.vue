<template>
    <div  v-if="team">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ team.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ team.name }}</td>
                </tr>
              <tr>
                <th>Players</th>
                <td v-for="(item,index) in team.player" :key="index">
                  {{ item.name }}
                </td>
              </tr>
            </table>
            <div v-if="errors.length" class="alert alert-danger">
              <b>Please fix following errors</b>
              <ul>
                <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
              </ul>
            </div>
            <router-link to="/team">Back to all teams</router-link>
    </div>
</template>

<script>
    export default {
        name: 'show',
        mounted() {
                axios.get(`/api/team/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.team = response.data.data
                });
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        data() {
            return {
                team: [],
                errors:[],
            };
        },

    }
</script>
<style scoped>

    .team-view {
        display: flex;
        align-items: center;
    }

</style>
