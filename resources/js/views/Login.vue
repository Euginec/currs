<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="POST" @submit.prevent="login">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        autocomplete="email"
                                        autofocus
                                        required
                                        v-model="email"
                                        @keydown="hideAlert"
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        v-model="password"
                                        @keydown="hideAlert"
                                    >
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Login
                                    </button>
                                    <div
                                        v-if="error_message"
                                        class="alert alert-danger mt-3"
                                        role="alert"
                                        v-text="error_message"
                                    ></div>
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
            email: '',
            password: '',
            error_message: ''
        };
    },

    methods: {
        login() {
            this.hideAlert();
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password
            })
                .then(resp => {
                    this.$router.push('rates');
                })
                .catch(error => {
                    console.log(error);

                    this.error_message = error.response.data.error;
                });
        },

        hideAlert() {
            this.error_message = '';
        }
    }
}
</script>
