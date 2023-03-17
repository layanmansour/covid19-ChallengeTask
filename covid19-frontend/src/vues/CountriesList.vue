<template>
    <h7 style="text-align:left">Countries' cases by total cases by descends<br> .</h7>
    <div class="has-search"> 
      <input class="has-search" type="text" v-model="this.search_query" placeholder="Search..."   />
    </div>
    <div>
      <h9> .</h9>
    </div>
    <div>
      <h1></h1>
    </div>
    <p v-if="this.isLoading">Loading.....</p>
    <div class="row" v-else>
      <Countries :data="countries" />
    </div>

    <nav aria-label="Page navigation example" v-if="!this.isFetching">
      <ul class="pagination">
        <li class="page-item" v-if="this.current_page !== 1">

        <router-link :to="{ name: 'countries_list', params: { slug: this.current_page } }" @click="PreviousPage(page)"  class="page-link">
        Previous
        </router-link>
        </li>
        <li class="page-item" v-for="page in this.total_pages">
            <router-link :to="{ name: 'countries_list', params: { slug: page } }" @click="visitPage(page)"  class="page-link">
            {{page}}
            </router-link>
        </li>
        <li class="page-item">

            <router-link :to="{ name: 'countries_list', params: { slug: this.current_page } }" @click="visitPage(page)"  class="page-link">
            next
            </router-link>
        </li>
      </ul>
    </nav>


</template>

<script>
import Countries from '../components/Countries.vue';
import Search from '../components/Search.vue';

import { useRouter, useRoute } from 'vue-router'
export default {
  name: 'CountriesList',
  components: {
    Countries,
    Search
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

      this.current_page = parseInt(value)
    },
    PreviousPage()
    {
      this.current_page =this.current_page ===1 ? parseInt(this.current_page-1) : 1;
    },
    NextPage()
    {
      this.current_page =this.current_page ===this.total_pages ? parseInt(this.current_page+1) : 1;
    },
    async fetchData()
    {

      this.isLoading =true;
      let response = await fetch(`http://localhost:8000/api/countries/?page=${this.current_page}`);
      if ( response.status === 404 )
      {
        router.push('/404');
      }
      const data = await response.json();
      this.countries = data.data ;
      this.isLoading =false;
      this.total_pages = Math.ceil( data.total / 10);

    }
  },

  async mounted()
  {
    const route = useRoute();
    const router = useRouter();
    //this.current_page = route.params?.page ?  
    console.log(route.params)
    //this.search_query = router.params?.query;

    let page = this.$route.params?.page;
    page = parseInt(page);
    this.current_page = isNaN(page) ? 1 : parseInt(page) ;
    console.log('current page:',this.current_page,page,typeof(page),isNaN(page))
    await this.fetchData();
    this.isFetching =false;
  },
  watch:{

    current_page: async function(newValue, oldValue)
    {
      //this.$router.push(`/countries/${this.current_page}`);
      await this.fetchData();
    },
    search_query:function(newValue, oldValue)
    {
      console.log(`search query ${this.search_query}`);
      this.$router.push(`/country/search/${this.search_query}`);
    }

  }

};
</script>
<style>
h7{
  padding-top: 100px;
}
</style>

