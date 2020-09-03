<!-- Header.vue -->
<template>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Code Test</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div>{{ $store.state.profile.name }}</div>
            <button class="btn btn-sm btn-danger" v-on:click="logout">Logout</button>
        </div>
    </nav>
</template>
<script>
import * as auth from './../services/auth_service';
export default {
    methods: {
        logout: async function(){
            await auth.logout();
            this.$router.push('/login');
        }
    }
}
</script>
