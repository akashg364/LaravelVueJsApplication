<template>
    <div class="container mt-5">
        <div v-if="loading"></div>
        <div v-else>
            <b-modal id="modal-add-posts" ref="modal" title="Add post to subscribed website" @show="resetModal"
                @hidden="resetModal" @ok="handleOk">
                <form ref="form" @submit.stop.prevent="handleSubmit">
                    <b-form-group label="Title" label-for="title-input" invalid-feedback="title is required"
                        :state="titleState">
                        <b-form-input id="title-input" v-model="title" :state="titleState" required></b-form-input>
                    </b-form-group>
                    <b-form-group label="Description" label-for="description-input" invalid-feedback="Description is invalid"
                        :state="descriptionState">
                        <b-form-input id="description-input" v-model="description" :state="descriptionState" required></b-form-input>
                    </b-form-group>
                </form>
            </b-modal>
        </div>
    </div>
</template>
<script>
export default {
    props: ['postProps'],
    data() {
        return {
            title: '',
            titleState: null,
            description: '',
            descriptionState: null,
            loading: false,
            apiUrl: process.env.MIX_API_URL
        }
    },
    methods: {
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.titleState = valid
            this.descriptionState = valid
            return valid
        },
        resetModal() {
            this.title = ''
            this.titleState = null
            this.description = ''
            this.descriptionState = null
        },
        handleOk(bvModalEvent) {
            // Prevent modal from closing
            bvModalEvent.preventDefault()
            // Trigger submit handler
            this.handleSubmit()
        },
        handleSubmit() {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return
            }
             this.loading = true
            this.axios
                .post(this.apiUrl+'posts', {
                        title:this.title, 
                        description:this.description,
                        userId:this.postProps.userId,
                        websiteId:this.postProps.websiteId
                    })
                .then(response => {
                    if(response.data.errors){
                        this.titleState = response.data.errors.title?false:true
                        this.descriptionState = response.data.errors.description?false:true
                        return;
                    }
                   
                    this.$router.go()
                    this.$nextTick(() => {
                        this.$bvModal.hide('modal-add-posts')
                    })
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        }
    }
}
</script>