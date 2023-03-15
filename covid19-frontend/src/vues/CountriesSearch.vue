<template>
    {{ this.isLoading }}
    {{ this.current_page }}
    {{ this.total_pages  }}
    {{ typeof(this.total_pages)  }}
    <h2> Countries' cases by total cases by descends</h2>
    <input type="text" v-model="this.search_query" @input="fetchData" />
    <p v-if="this.isLoading">Loading.....</p>
    <div class="row" v-else>
      <Countries :data="countries" v-if="!this.isFetching" />
    </div>

    <nav aria-label="Page navigation example" v-if="!this.isFetching">
      <ul class="pagination">
        <li class="page-item" v-if="this.current_page !== 1">

        <router-link :to="{ name: 'countries_search', params: { slug: this.current_page } }" @click="PreviousPage(page)"  class="page-link">
        Previous
        </router-link>
        </li>
        <li class="page-item" v-for="page in this.total_pages">
            <router-link :to="{ name: 'countries_search', params: { search: this.search_query,page:page } }" 
            @click="visitPage(page)"  class="page-link">
            {{page}}
            </router-link>
        </li>
        <li class="page-item">

            <router-link :to="{ name: 'countries_search', params: { slug: this.current_page } }" 
            @click="visitPage(page)"  class="page-link" v-if="this.current_page !== this.total_pages">
            next
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

