<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Welcome to Code Test</h3></div>
                        <div class="card-body">
                            <div class="text-center">
                                Assessment Task for Full Stack Web Developer
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">
                                <router-link to="/login" class="nav-link" exact>Have an account? go to Login</router-link>
                            </div>
                            <div class="small">
                                <router-link to="/register" class="nav-link" exact>Need an account? Sign up!</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

};
</script>
