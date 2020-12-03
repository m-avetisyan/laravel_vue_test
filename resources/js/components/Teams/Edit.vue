<template>
    <div class="team-view" v-if="team">
        <form @submit.prevent="updateForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
                </div>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text"  class="form-control" v-model="team.name">
                    </td>
                </tr>
            </table>
            <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>
</template>

<script>
    export default {
        name: 'edit',
        created() {
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
                team: {
                    name:'',
                },
                errors: []
            };
        },
        methods:{

            updateForm: function (e) {

                if (!this.team.name) {
                    this.errors.push ("Name required")
                }

                if (!this.errors.length) {
                    axios.put(`/api/team/${this.$route.params.id}`, this.$data.team,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.$store.commit('updateTeams',response.data.data);
                        this.$router.push('/team');
                    });
                }
                e.preventDefault();
            },
        }
    }
</script>
<style scoped>

    .table th{
        vertical-align:middle
    }

</style>
