<template>
  {{ this.isLoading }}
  {{ this.current_page }}
  {{ this.total_pages  }}
  {{ typeof(this.total_pages)  }}
  <h2 class="h2"> Countries' cases by total cases by descends</h2>
  <router-link :to="{ name: 'country_add' }">
    <button class="buttonT"> Add Country </button>
  </router-link>

  <button class="button" @click="this.fillData"> Fill Data</button>
  <input class="search" type="text" v-model="this.search_query" placeholder="Search.."/>
  <p v-if="this.isLoading">Loading.....</p>

  <div class="row" >
    <Countries v-bind:is-loading="isLoading" :data="countries" />
  </div>

  <nav aria-label="Page navigation example" v-if="!this.isFetching">
    <ul class="pagination">
      <li class="page-item" v-if="this.current_page !== 1">
      <router-link :to="{ name: 'countries_list', params: { page: this.current_page } }" @click="PreviousPage(page)"  class="page-link">
     <p class="page">Previous</p> 
      </router-link>
      </li>
      <li class="page-item" v-for="page in this.total_pages">
          <!----router-link :to="{ name: 'countries_list', params: { page: page } }" @click="visitPage(page)"  class="page-link"----->
          <router-link :to="`/countries/${page}`" @click="visitPage(page)"  class="page-link" >
            <p class="page"> {{page}}</p>
          </router-link>
      </li>
      <li class="page-item">

          <router-link :to="{ name: 'countries_list', params: { page: this.current_page } }" @click="visitPage(page)"  class="page-link">
            <p class="page"> next</p>
          </router-link>
      </li>
    </ul>
  </nav>
</template>

<script>
import Countries from '../components/Countries.vue';

import { useRouter, useRoute } from 'vue-router'
export default {
name: 'CountriesList',
components: {
  Countries
},
data() {
  return {
    countries: [],
    isLoading:true,
    isFetching:true,
    current_page: 1,
    total_pages: 1,
    search_query:""
  };
},
methods:{
  visitPage(value)
  {
      this.current_page = parseInt(value);
      console.log('yo:',this.current_page)
  },
  PreviousPage()
  {
    this.current_page =this.current_page !==1 ? this.current_page-1 : 1;
  },
  NextPage()
  {
    this.current_page = this.current_page !==this.total_pages ? this.current_page + 1 : this.total_pages;
  },
  async fetchData()
  {

      this.isLoading = true;
      let url = `http://localhost:8000/api/country/search?q=${this.search_query}&page=${this.current_page}`;
      let response = await fetch(url);
      if ( response.status === 404 )
      {
          router.push({name:'404_page'});
      }
      const data = await response.json();
      this.countries = data.data ;
      this.isFetching =false;
      this.isLoading = false;
      this.total_pages = Math.ceil( data.total / 10);
      return response.status;
  }
},

async mounted()
{
   const route = useRoute();
   const router = useRouter();
  this.search_query = this.$route.params?.search;
  let page = this.$route.params?.page;
  page = parseInt(page);
  this.current_page = isNaN(page) ? 1 : parseInt(page) ;

  await this.fetchData();
},
watch:{

  current_page: async function(newValue, oldValue) {
      /*let page = this.$route.params?.page;
      page = parseInt(page);
      this.current_page = isNaN(page) ? 1 : parseInt(page) ;*/
      console.log('current page::;',this.current_page)
      this.$router.push(`/country/search/${this.search_query}/${this.current_page}`)
      await this.fetchData();
      this.isLoading = false;
  },
  search_query: async function(newValue, oldValue) {
      this.search_query = newValue;
      //this.$router.push(`/country/search/${this.search_query}`);
  }
}

};
</script>

<style>
.button{
 
  color: #ffffff;
  margin-top: 30px;
margin-bottom: 10px;
  border-radius: 8px;
   cursor: pointer;
  margin-right:55%;
  /* margin-left: 10%; */
  background-color: rgb(45, 106, 126);
}
.buttonT{
  color: #ffffff;
margin-top: 30px;
margin-bottom: 10px;
  border-radius: 8px;
   cursor: pointer;
   margin-right:3%;
   background-color: rgb(45, 106, 126);
}

.page{

  color:  rgb(68, 165, 213);
}
.h2{
  color: #ffffff;
}

</style>
