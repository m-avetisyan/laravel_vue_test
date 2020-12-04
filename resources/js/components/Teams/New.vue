<template>
    <div class="team-new">
        <form @submit.prevent="submitForm">
            <div v-if="errors.length" class="alert alert-danger" >
                <b>Please fix following errors</b>
                <ul>
                    <strong><li v-for="(error,index) in errors" :key="index">{{ error }}</li></strong>
                </ul>
            </div>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" class="form-control" v-model="team.name" placeholder="Name"/>
                    </td>
                    <td>
                         <span v-if="errors.name">
                            {{ errors.name }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Parent team</th>
                    <td>
                        <treeselect
                            :options="teams"
                            :value="value"
                            :normalizer="normalizer"
                            @input="changeTeam"
                        />
                    </td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/team" class="btn btn-danger">Cancel</router-link>
                    </td>
                    <td class="text-right">
                        <input type="submit" value="Create" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>

import '@riophae/vue-treeselect/dist/vue-treeselect.css'
    export default {
        name:'new',
        computed:{
            currentUserToken(){
                return this.$store.getters.currentUser.token;
            },
        },
        mounted(){
            this.AllTeams();
        },
        data() {
            return {
                team: {
                    name:'',
                    parent_id: null,
                },
                errors: [],
                teams:[],
                value:null,
                normalizer(node) {
                    return {
                        id: node.id,
                        label: node.name,
                        children: node.sub_options,
                    }
                },
            }
        },
        methods:{
            changeTeam(e){
                this.team.parent_id = e;
            },
            submitForm: function (e) {

                this.errors = [];

                if (!this.team.name) {
                    this.errors.push("Name required")
                }else if(this.team.name.length < 3){
                    this.errors.push("Name must contains minimum 3 characters")
                }
                if (!this.errors.length) {
                    axios.post('/api/team/new', this.$data.team,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUserToken}`
                        }
                    })
                    .then((response) => {
                        if(response.data.code === 200){
                            this.$store.commit('updateTeams',response.data.data);
                            this.$router.push('/team');
                        }
                    });
                }
                e.preventDefault();
            },
            AllTeams(){
                axios.get('/api/teams',{
                    headers:{
                        'Authorization':`Bearer ${this.$store.getters.currentUser.token}`
                    }
                }).then((response) => {
                    this.teams = response.data.data;
                })
            }
        }
    }
</script>
