<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.name.length }"
                                        autocomplete="name"
                                        autofocus
                                        v-model="form.name"
                                    >
                                    <span v-if="errors.name.length" class="invalid-feedback" role="alert">
                                        <strong v-for="(error, index) in errors.name" :key="index">{{ error }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input
                                        type="email"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.email.length }"
                                        autocomplete="email"
                                        v-model="form.email"
                                    >
                                    <span v-if="errors.email.length" class="invalid-feedback" role="alert">
                                        <strong v-for="(error, index) in errors.email" :key="index">{{ error }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.password.length }"
                                        v-model="form.password"
                                    >
                                    <span v-if="errors.password.length" class="invalid-feedback" role="alert">
                                        <strong v-for="(error, index) in errors.password" :key="index">{{ error }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.password.length }"
                                        v-model="form.password_confirmation"
                                    >
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {
                name: [],
                email: [],
                password:[]
            }
        };
    },

    methods: {
        register() {
            this.clearErrors();
            this.$store.dispatch('register', this.form)
                .then(res => {
                    console.log(res);
                    this.form.name = '';
                    this.form.email= '';
                    this.form.password = '';
                    this.form.password_confirmation = '';

                    this.$router.push('rates');
                })
                .catch(err => {
                    console.log(err);
                    this.errors = Object.assign(this.errors, err.response.data.errors);
                });
        },
        clearErrors() {
            this.errors.name = '';
            this.errors.email= '';
            this.errors.password = '';
        },
    }
}
</script>
