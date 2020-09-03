<template>
    <div>
        <router-view></router-view>
        <flash-message position="right top"></flash-message>
    </div>
</template>

<script>
import * as auth from './services/auth_service';
export default {
    name: 'App',
    beforeCreate: async function(){
      try{
          if(localStorage.getItem('code-test-user-token')){
              const response = await auth.getProfile();
              this.$store.dispatch('authenticate', response.data);
          }
      }catch (error) {

      }

    },
};
</script>
