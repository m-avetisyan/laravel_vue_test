<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/users/new" class="btn btn-primary" v-if="currentUser.role==='superadmin'">New</router-link>
        </div>
        <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th colspan="3" v-if="currentUser.role === 'superadmin'">Actions</th>
                </thead>
                <tbody>
                    <template v-if="!users.length">
                        <tr>
                            <td colspan="4" class="text-center">No users Available</td>
                        </tr>
                    </template>
                    <template v-else-if="currentUser.role === 'superadmin'">
                        <tr v-for="(user,index) in users" :key="index">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role }}</td>
                            <td>
                                <router-link :to="`/users/${user.id}`">Show</router-link>
                            </td>
                            <td>
                                <router-link :to="`/users/${user.id}/edit`">Edit</router-link>
                            </td>
                            <td>
                                <input type="submit" value="Delete" @click="deleteUser(index,user.id)" class="btn btn-danger"/>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr v-for="(user,index) in users" :key="index" v-if="user.id===currentUser.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role }}</td>
                        </tr>
                </template>
                </tbody>
        </table>
    </div>
</template>

<script>

export default {

    name: 'list',
    mounted() {
        if (this.users.length) {
            return;
        }
        this.$store.dispatch('getUsers');
    },
    computed: {
        users() {
            return this.$store.getters.users
        },
        currentUser() {
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        deleteUser(index, id) {
            axios.delete(`/api/user/${id}`, {
                headers: {
                    "Authorization": `Bearer ${this.currentUser.token}`,
                }
            })
                .then(res => {
                    this.$store.commit('updateUsers', res.data.data);
                })
                .catch(err => {
                    console.error(err)
                })
        },
    }
}
</script>
<style scoped>

.btn-wrapper {
    text-align: right;
    margin-bottom: 20px;
}

table thead, table tbody {
    text-align: center !important
}

table tr td {
    vertical-align: middle
}

.table thead th {
    text-align: center
}
</style>
