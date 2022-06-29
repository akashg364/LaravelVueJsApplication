<template>
    <div class="container mt-5">
        <div>
            <b-modal id="modal-registration" ref="modal" title="Register to subscribe" @show="resetModal"
                @hidden="resetModal" @ok="handleOk">
                <form ref="form" @submit.stop.prevent="handleSubmit">
                    <b-form-group label="Name" label-for="name-input" invalid-feedback="Name is required"
                        :state="nameState">
                        <b-form-input id="name-input" v-model="name" :state="nameState" required></b-form-input>
                    </b-form-group>
                    <b-form-group label="Email" label-for="email-input" invalid-feedback="Email is invalid"
                        :state="emailState">
                        <b-form-input id="email-input" v-model="email" :state="emailState" required></b-form-input>
                    </b-form-group>
                </form>
            </b-modal>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: '',
            nameState: null,
            email: '',
            emailState: null,
            apiUrl: process.env.MIX_API_URL
        }
    },
    methods: {
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            this.emailState = valid
            return valid
        },
        resetModal() {
            this.name = ''
            this.nameState = null
            this.email = ''
            this.emailState = null
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
            this.axios
                .post(this.apiUrl+'user', {name:this.name, email:this.email})
                .then(response => {
                    if(response.data.errors){
                        this.emailState = response.data.errors.email?false:true
                        this.nameState = response.data.errors.name?false:true
                        return;
                    }
                    if (response.data.data.email) {
                        localStorage.setItem('isLoggedIn', response.data.data.id)
                    }
                    
                    this.$router.go()
                    // Hide the modal manually
                    this.$nextTick(() => {
                        this.$bvModal.hide('modal-registration')
                    })
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        }
    }
}
</script>