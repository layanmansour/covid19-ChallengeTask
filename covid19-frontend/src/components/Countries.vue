<template>
    <div class="t">
    <table class="table table-striped">
      <thead>
    <tr>
      <th>Slug</th>
      <th>Country</th>
      <th>Country Code</th>
      <th>New Confirmed</th>
      <th>Total Confirmed 
        <i :class="this.sortIcon" @click="this.setSortedMethod()">
        </i>
        </th>
      <th>New Deaths</th>
      <th>New Recovered</th>
      <th>Total Recovered</th>
      <th>Total Death</th>
      <th>Edit </th>
    </tr>
  </thead>
  <tbody >
    <tr v-for="(item, index) in data" :key="index" v-if="!isLoading">
      <td>{{ item.slug }}</td>
      <td>{{ item.country }}</td>
      <td>{{ item.country_code }}</td>
      <td>{{ item.new_confirmed }}</td>
      <td>{{ item.total_confirmed }}</td>
      <td>{{ item.new_deaths }}</td>
      <td>{{ item.new_recovered }}</td>
      <td>{{ item.total_recovered }}</td>
      <td>{{ item.total_deaths }}</td>
      <td>
        <router-link :to="{ name: 'country_edit', params: { slug: item.slug } }">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" color=" rgba(82, 157, 182, 0.853)">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
</router-link>
      </td>
    </tr>
    <tr v-else class="loading">
      <td colspan="10">Loading....</td>
    </tr>
  </tbody>
    </table>
  </div>
    </template>
    
    <script>
import { mapGetters } from 'vuex';
    export default {
      name:"Countries",
       //get data 
  computed:{
    ...mapGetters(['getSortingMethod']),
    sorted() {
      return this.getSortingMethod;
    }
  },
  props: {
    data: { type: Array, required: true, },
    isLoading: { type: Boolean, required: true, },
  },
  methods:{
    setSortedMethod() {
      console.log('hello')
      this.$store.commit('setSortMethodMutation');
      //this.sortIcon =   `icon-sort-amount-${sorted}` ;
      //console.log('sorted icon:',this.sortIcon)
    }
  },
  data:function()
  {
    return {
      sortIcon:'' 
       }
  },
  mounted()
  {
    this.sortIcon=`icon-sort-amount-${this.sorted}` 
    console.log('sorted icon',this.sorted)
  },
  watch:{
    "$store.state.sorted":async function(newValue, oldValue)
    {
      this.sortIcon =  `icon-sort-amount-${this.sorted}`; 
    },
  }
  
};
    </script>
  