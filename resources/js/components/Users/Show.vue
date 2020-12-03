<template>
    <div  v-if="user">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ user.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ user.name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ user.email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ user.role }}</td>
                </tr>
            </table>
            <router-link to="/users">Back to all users</router-link>
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
                axios.get(`/api/users/${this.$route.params.id}`,{
                    headers:{
                        "Authorization":`Bearer ${this.currentUser.token}`
                    }
                })
                .then((response) => {
                    this.user = response.data.data
                });
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
    }
</script>
<style scoped>

    .user-view {
        display: flex;
        align-items: center;
    }

</style>
