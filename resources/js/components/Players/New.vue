<template>
    <div class="player-new">
        <form action="#"  @submit.prevent="submitForm">
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
                        <input type="text" class="form-control" v-model="player.name" placeholder="Name"/>
                    </td>
                    <td>
                         <span v-if="errors.name">
                            {{ errors.name }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>
                        <textarea rows="3" class="form-control" v-model="player.description"></textarea>
                    </td>
                    <td>
                         <span v-if="errors.description">
                            {{ errors.description }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Team</th>
                    <td>
                        <treeselect
                            :options="teams"
                            :value="value"
                            :normalizer="normalizer"
                            @input="changeTeam"
                        />
                    </td>
                    <td>
                         <span v-if="errors.team">
                            {{ errors.team }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/player" class="btn btn-danger">Cancel</router-link>
                    </td>
                    <td class="text-right">
                        <input type="submit" class="btn btn-primary" value="Add">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>

    export default {
        name:'new',
        computed:{
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        mounted(){
            this.AllTeams();
        },
        data() {
            return {
                player: {
                    name:'',
                    description: '',
                    team:''
                },
                teams:[],
                value: null,
                errors: [],
                normalizer(node) {
                    return {
                        id: node.id,
                        label: node.name,
                        children: node.sub_options,
                    }
                },
            };
        },
        methods:{

            submitForm: function (e) {

                this.errors = [];

                if (!this.player.name) {
                    this.errors.push("Name required")
                }else if(this.player.name.length < 3){
                    this.errors.push("Name must contains minimum 3 characters")
                }
                if (!this.player.description) {
                    this.errors.push("Description required")
                }
                if (!this.player.team) {
                    this.errors.push("Team for added player required")
                }
                if (!this.errors.length) {
                    const data = new FormData();
                    data.append('name', this.player.name);
                    data.append('description', this.player.description);
                    data.append('team_id', this.player.team);
                    axios.post('/api/player/new', data,{
                        headers:{
                            'Authorization':`Bearer ${this.currentUser.token}`
                        }
                    })
                    .then((response) => {
                        this.$store.commit('updatePlayers',response.data.data);
                        this.$router.push('/player');
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
            },
            changeTeam(e){
                this.player.team = e;
            },
        }
    }
</script>
