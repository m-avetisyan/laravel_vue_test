<template>
    <div class="plan-view">
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
                        <input type="text"  class="form-control" v-model="player.name">
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>
                        <input type="text" class="form-control" v-model="player.description">
                    </td>
                </tr>
                <tr>
                  <th>Team</th>
                  <td>
                    <treeselect
                        :options="teams"
                        :value="player.team_id"
                        :normalizer="normalizer"
                        @input="changeTeam"
                    />
                  </td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td>
                        <input type="submit" value="Update" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'edit',
        created() {
            axios.get(`/api/player/${this.$route.params.id}`,{
                headers:{
                    "Authorization":`Bearer ${this.currentUser.token}`
                }
            })
            .then((response) => {
                this.player = response.data.data;
            });
          this.AllTeams();
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        data() {
            return {
              player: {
                    name:'',
                    description:'',
                    team_id:'',
                },
              errors: [],
              teams:[],
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
            updateForm: function (e) {

              if (!this.player.name) {
                  this.errors.push ("Name required")
              }else if(this.player.name.length < 3){
                  this.errors.push("Name must contains minimum 3 characters")
              }
              if (!this.player.description) {
                this.errors.push ("Description required")
              }
              if (!this.errors.length) {
                  axios.put(`/api/player/${this.$route.params.id}`, this.$data.player,{
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
              this.player.team_id = e;
            },
        }
    }
</script>
<style scoped>

    .table th{
        vertical-align:middle
    }

</style>
