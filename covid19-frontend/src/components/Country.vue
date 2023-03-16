<template>
    <tr>
      <th>{{ this.slug }} </th>
        <th>{{ this.country }} </th>
        <th>{{ this.country_code }} </th>
        <th>{{ this.new_confirmed }} </th>
        <th>{{ this.total_confirmed }} </th>
        <th>{{ this.new_deaths }} </th>
        <th>{{ this.new_recovered }} </th>
        <th>{{ this.total_recovered }} </th>
        <th>{{ this.total_deaths }} </th>
        <th> 
  
        <router-link :to="{ name: 'country_add' }">
         edit details 
         </router-link> </th>
    </tr>
  
  </template>
  
  <script>
  
  export default {
    name:"Country",
    props:{
      slug:String,
      country:String,
      country_code:String,
      new_confirmed:Number,
      total_confirmed:Number,
      new_deaths:Number,
      new_recovered:Number,
      total_recovered:Number,
      total_deaths:Number,
    },
    mounted(){
    }
  };
  </script>
  
  
  <style scoped>
  .read-the-docs {
    color: #888;
  }
  </style>
  