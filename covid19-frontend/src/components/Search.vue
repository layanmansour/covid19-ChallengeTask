<template>
    {{this.search_query}}
    <input type="text" v-model="this.search_query" @change="this.search()"/>
    </template>
    
    <script>
    import { useRouter } from 'vue-router';
    export default {
      name:"Search",
      data:function()
      {
        return{
          search_query: ''
        }
      },
      methods:{
        search()
        {
          this.$router.push({name:"search",params:{search:this.search_query}});
        }
      },
      
    };
    </script>
    
    <style scoped>
    .read-the-docs {
      color: #888;
    }
    </style>
    