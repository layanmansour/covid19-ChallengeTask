<template>
    <p v-if="this.isLoading">Loading...</p>
    <div class="container mt-3" v-else>
      <h2>Countries state </h2>
      <div style="display:flex;">
        <div class="card">
          Total Confirmed
          <div class="card-body">
           {{ numberWithCommas(this.total_confirmed)}}
          </div>
        </div>
    
        <div class="card">
          Total Recovered
          <div class="card-body">{{this.total_recovered}}</div>
        </div>
    
        <div class="card">
        Total Death
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
        let response = await fetch('http://localhost:8082/api/stats'); 
        const data = await response.json();
        this.total_confirmed = data.total_confirmed ;
        this.total_recovered = data.total_recovered ;
        this.total_deaths = data.total_deaths ;
        this.new_deaths = data.new_deaths ;
        this.new_confirmed = data.new_confirmed ;
        this.countries = data.countries ;
        this.isLoading = false;
      },
      setup () {
    return {
      numberWithCommas (x) {
        return x.toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      }
    };
  }
    };
    </script>
    
    
    <style scoped>
    .read-the-docs {
      color: #888;
    }
    .card{
      height: 350px;
      width: 300px;
      margin-right:8%;
      font-size: 20px;
      text-align: center;
     white-space:nowrap;
     box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);

    }
    .card_d{
      height: 350px;
      width: 300px;
      margin-right:8%;
      font-size: 20px;
      text-align: center;
       white-space:nowrap;
     box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    }
    </style>
    