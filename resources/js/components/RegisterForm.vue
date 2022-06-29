<template>
    <div>
        <h3 class="text-center">Register</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addUser">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label>email</label>
                        <input type="text" class="form-control" v-model="user.email">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                user: {},
                apiUrl: process.env.MIX_API_URL
            }
        },
        methods: {
            addUser() {
                this.axios
                    .post(this.apiUrl+'user', this.user)
                    .then(response => {
                        if(response.data.data.email){
                            localStorage.setItem('isLoggedIn', response.data.data.id)
                        }
                        this.$router.push({ name: 'home' })
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>