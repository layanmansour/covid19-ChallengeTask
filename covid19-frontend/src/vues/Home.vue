<template>
    <p v-if="this.isLoading">Loading...</p>
    <div class="container mt-3" v-else>
      <h2>Countries state </h2>
      <div style="display:flex;">
        <div class="card">
        total confirmed
          <div class="card-body">{{this.total_confirmed}}</div>
        </div>
    
        <div class="card">
        total recovered
          <div class="card-body">{{this.total_recovered}}</div>
        </div>
    
        <div class="card">
        total death
          <div class="card-body">{{this.total_deaths}}</div>
        </div>
      </div>
    
    </div>
    </template>
    
    <script>
    
    export default {
      name:"Home",
      metaInfo: {
        title:'home'
      },
      data:function(){
        return{
          total_confirmed:0,
          total_recovered:0,
          total_deaths:0,
          countries:[],
          isLoading:true
        }
      },
      async mounted()
      {
        let response = await fetch('http://localhost:8000/api/stats'); 
        const data = await response.json();
        this.total_confirmed = data.total_confirmed ;
        this.total_recovered = data.total_recovered ;
        this.total_deaths = data.total_deaths ;
        this.countries = data.countries ;
        this.isLoading = false;
      }
    };
    </script>
    
    
    <style scoped>
    .read-the-docs {
      color: #888;
    }
    .card{
      margin-right:2%;
      white-space:nowrap;
    }
    </style>
    