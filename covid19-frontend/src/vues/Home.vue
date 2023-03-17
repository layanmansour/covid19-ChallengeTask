<template>
  <div class="container" v-if="!isLoading">
    <p v-if="this.isLoading">Loading...</p>
    <div class="container mt-3" v-else>
      <h2 class="text">
        <b>
          Global Stats
        </b></h2>
        <div style="display:flex; justify-content:center; align-items: center;">
        <div class="card0">
         <h4>
          <b>
          
          </b>
         </h4>
          <div class="card-body">
      
          </div>
        </div>
            <!-- Box2 -->

        <div class="card">
         <h4>
          <b>
            Cases
          </b>
         </h4>
          <div class="card-body">
          <p><b>New: </b>{{ numberWithCommas(this.new_confirmed)}}</p>
          <p> <b>Total: </b>{{ numberWithCommas(this.total_confirmed)}}</p>
          </div>
        </div>
    
    <!-- Box2 -->
        <div class="card">
          <h4>
            <b>
              Deaths
            </b>
         </h4>      
             <div class="card-body">
              <p><b>New: </b>{{ numberWithCommas(this.new_deaths)}}</p>
          <p> <b>Total: </b>{{ numberWithCommas(this.total_deaths)}}</p>
            </div>
        </div>
      </div>

    </div>
    <div class="text">
      
    <p>
      <i>This is an interactive world map that displays all countries, allowing you to click on a country to view comprehensive COVID-19 statistics and information
</i>
    </p>  
    </div>

    <div> 
      <Map/>
    </div>
   
  </div>
    </template>
    
    <script>
    import Map from '../components/Map.vue';
    export default {
      name:"Home",
      metaInfo: {
        title:'home'
      },
      components:{
    Map
  },
      data:function(){
        return{
          total_confirmed:0,
          total_recovered:0,
          total_deaths:0,
          countries:[],
          new_deaths:0,
          new_confirmed:0,
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
      width: 400px;
      margin-right:8%;
      font-size: 20px;
      text-align: center;
     white-space:nowrap;
     box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
     box-shadow: 2px;
     background-color:rgba(230, 245, 250, 0.865); 
   

    }
    .card0{
     
      width: 100px;
    }
   
    .text{
      padding-top: 100px;
      padding-bottom: 30px;
    }
    body {
    background-image: url('/images/covi1d9.png');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
  }
    </style>
    