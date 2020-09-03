<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                    <div class="card-body">
                        <form v-on:submit.prevent="login">
                            <div class="form-group">
                                <label class="small mb-1" for="email">Email</label>
                                <input class="form-control py-4" id="email" v-model="user.email" type="email" placeholder="Enter email address" />
                                <div class="text-danger" v-if="errors.email">{{errors.email[0]}}</div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="password">Password</label>
                                <input class="form-control py-4" id="password" v-model="user.password" type="password" placeholder="Enter password" />
                                <div class="text-danger" v-if="errors.password">{{errors.password[0]}}</div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" v-model="user.remember_me" id="rememberPasswordCheck" type="checkbox" />
                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <router-link class="small" to="/register">Need an account? Sign up!</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as auth from '../../services/auth_service'
export default {
    name: 'Login',
    data() {
        return {
            user: {
                email: '',
                password: '',
                remember_me: false,
            },
            errors: {},
        }
    },
    methods:{
        login: async function(){
            try {
                await auth.login(this.user);
                this.errors = {};
                this.$router.push('/home');
            } catch (error){
                switch (error.response.status) {
                    case 401:
                        this.flashMessage.error({
                            message: error.response.data.message,
                            time: 5000,
                        })
                        break;
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    case 500:
                        this.flashMessage.error({
                            message: error.response.data.message,
                            time: 5000,
                        })
                        break;
                    default:
                        alert("some error occurred");
                        break;
                }
            }
        }
    }
};
</script>
