<template>
  
  <h2> Countries' covid19 cases by the total of confirmed cases</h2>

    <button class="filter" @click="this.setSortedMethod()">
      <i :class="this.sortIcon" />
     <!-- {{  $store.state.sorted }} -->
    </button>
  <Alert :messages="this.messages" v-if="this.messages.length" v-bind:type="this.message_type"/>
 
  <router-link :to="{ name: 'country_add' }">
    <button class="buttonT"> Add Country </button>
  </router-link>

  <button class="button" @click="this.fillData"> Fill Data</button>
  <input class="search" type="text" v-model="this.search_query" placeholder="Search.."/>

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
import Search from '../components/Search.vue';
import Alert from "../components/Alert.vue";
import ENDPOINTS from '../../API_ENDPOINTS';
import { mapGetters } from 'vuex';
import { useRouter, useRoute } from 'vue-router'


export default {
  name: 'CountriesList',
  computed:{
    ...mapGetters(['getSortingMethod']),
    sorted() {
      return this.getSortingMethod;
    }
  },
  components: {
    Countries,
    Search,
    Alert
  },
  data() {
    return {
      countries: [],
      isLoading:true,
      isFetching:true,
      current_page: 1,
      total_pages: 1,
      search_query:"",
      messages:[],
      message_type:'info',
      sortIcon:'',
    };
  },
  methods:{
    setSortedMethod() {
      this.$store.commit('setSortMethodMutation');
    },
    async fillData()
    {
      this.messages=[];
      await fetch("http://localhost:8000/api/fill_data")
      .then(result => this.messages.push('the data was filled'))
      .catch(error => {this.messages.push('an error occure, please try again.');this.message_type = 'danger'});
    },
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
      console.log('fetching data....')
      this.isLoading =true;
      let response = await fetch(`http://localhost:8000/api/countries/?page=${this.current_page}&sorted=${this.sorted}`);
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
    this.sortIcon=`icon-sort-amount-${this.sorted}` ;
    let page = this.$route.params?.page;
    page = parseInt(page);
    this.current_page = isNaN(page) ? 1 : parseInt(page) ;
    await this.fetchData();
    this.isFetching =false;
  },
  watch:{
    "$store.state.sorted":async function(newValue, oldValue)
    {
      this.sortIcon =  `icon-sort-amount-${this.sorted}`; 
      await this.fetchData();
    },
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
.filter{
  margin-right:10px;
  border-radius: 8px;
  background-color: rgba(164, 164, 164, 0.819);
  color: #ffffff;

}

.page{
  color:  rgb(68, 165, 213);
}

</style>
