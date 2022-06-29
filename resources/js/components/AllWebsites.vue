<template>
    <div>
        <h2 class="text-center">All Available Websites</h2>
 
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Total Subscribers</th>
                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="website in websites" :key="website.id">
                <td>{{ website.id }}</td>
                <td>{{ website.name }}</td>
                <td>{{ website.totalSubscribers }}</td>
                <td>
                    <div class="btn-group" role="group" >
                        <button v-if="website.isAlreadySubscribed == 1" v-b-modal.modal-add-posts @click="showModal(website.id)" class="btn btn-primary" >Add Post</button>
                        <button v-else-if="isUserLoggedIn" class="btn btn-success" @click="subscribeToWebsite(website.id )">Subscribe</button>
                        <button v-else="website.isAlreadySubscribed" v-b-modal.modal-registration class="btn btn-warning" >Register</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <register-modal />
        <add-post-modal :postProps="postProps" />
    </div>
</template>
<script>
    import AddPostModal from './modals/AddPostModal'
    import RegisterModal from './modals/RegisterModal'
    
    export default {
        components: { AddPostModal, RegisterModal },
        data() {
            return {
                websites: [],
                isUserLoggedIn:false,
                postModalState:false,
                postProps:{},
                apiUrl: process.env.MIX_API_URL
            }
        },
        mounted() {
            if (localStorage.getItem("isLoggedIn")){
                this.isUserLoggedIn = true
            }
        },
        created() {
            this.axios
                .get(this.apiUrl+'website?userId='+localStorage.getItem("isLoggedIn"))
                .then(response => {
                    this.websites = response.data.data;
                });
        },
        methods: {
            subscribeToWebsite(id) { 
                this.axios
                    .post(this.apiUrl+'subscribe', {"userId":localStorage.getItem("isLoggedIn"), "websiteId":id})
                    .then(response => {
                        this.axios
                            .get(this.apiUrl+'website?userId='+localStorage.getItem("isLoggedIn"))
                            .then(response => {
                                this.websites = response.data.data;
                            });
                    });
            },
            showModal(websiteId){
                this.postProps = {
                    websiteId:websiteId,
                    userId:localStorage.getItem("isLoggedIn")
                }
                
            }
        }
    }
</script>