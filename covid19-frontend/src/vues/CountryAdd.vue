<template>
  <br/>
  {{  this.showAlert }} {{  this.error }}
<br/>
  <div class="space">
  </div>
  <div class="form-container"  style="width: 40%;   margin: 0 auto;">
    <form @submit.prevent="addCountrySubmitHandler">
      <h5 class="add-text">Add New Country</h5>
      show alert:{{ this.showAlert }}
  <Alert :messages="this.error"  type="danger" v-if="showAlert" @close="hideAlert"/>
      <div v-for="error in error" class="error-message">{{ error }}!</div>

      <div class="form-row">
        <label class="form-label" for="slug-input">Slug:</label>
        <input id="slug-input" class="form-input" type="text" v-model="slug" />
      </div>

      <div class="form-row">
        <label class="form-label" for="country-input">Country:</label>
        <input id="country-input" class="form-input" type="text" v-model="country" />
      </div>

      <div class="form-row">
        <label class="form-label" for="country-code-input">Country code:</label>
        <input id="country-code-input" class="form-input" type="text" v-model="country_code" />
      </div>

      <div class="form-row">
        <label class="form-label" for="new-confirmed-input">New confirmed:</label>
        <input id="new-confirmed-input" class="form-input" type="number" v-model="new_confirmed" min="0" />
      </div>

      <div class="form-row">
        <label class="form-label" for="total-confirmed-input">Total confirmed:</label>
        <input id="total-confirmed-input" class="form-input" type="number" v-model="total_confirmed" min="0" />
      </div>

      <div class="form-row">
        <label class="form-label" for="new-deaths-input">New deaths:</label>
        <input id="new-deaths-input" class="form-input" type="number" v-model="new_deaths" min="0" />
      </div>
      <div class="form-row">
        <label class="form-label" for="total-deaths-input">Total deaths:</label>
        <input id="total-deaths-input" class="form-input" type="number" v-model="total_deaths" min="0" />
      </div>
      <div class="form-row">
        <label class="form-label" for="new-recovered-input">New recovered:</label>
        <input id="new-recovered-input" class="form-input" type="number" v-model="new_recovered" min="0" />
      </div>

      <div class="form-row">
        <label class="form-label" for="total-recovered-input">Total recovered:</label>
        <input id="total-recovered-input" class="form-input" type="number" v-model="total_recovered" min="0" />
      </div>

      <button type="submit" class="submit-button">Submit</button>
    </form>
  </div>
</template>

    


<script>
import {useRouter} from 'vue-router';
import Alert from "../components/Alert.vue";
import ENDPOINTS from '../../API_ENDPOINTS';
const router = useRouter();
export default{
  name:"CountrieAdd",
  components:{ Alert },
  mounted()
  {
    console.log( ENDPOINTS.ADD_NEW_COUNTRY );
    console.log( `${import.meta.env.VITE_API_BASE_URL}/country/add` )
  },
  data:function(){
    return{
        slug:"",
        country:"",
        country_code:"",
        new_confirmed:0,
        total_confirmed:0,
        new_deaths:0,
        new_recovered:0,
        total_recovered:0,
        total_deaths:0 ,
        error: [],
        showAlert:false,
    }
  },
  methods: {
    hideAlert() {
      this.showAlert = false;
    },
        // A method to send the data to the server using the POST method  
    async postData()
    {
      let raw = JSON.stringify({
        "slug": this.slug,
        "country": this.country,
        "country_code": this.country_code,
        "new_confirmed":this.new_confirmed,
        "total_confirmed":this.total_confirmed,
        "new_deaths":this.new_deaths,
        "new_recovered":this.new_recovered,
        "total_recovered":this.total_recovered,
        "total_deaths":this.total_deaths,
      });
      let requestOptions = {
        method: 'POST',
        body: raw,
        headers:{
        'Content-Type': 'application/json',
        "Accept":'application/json'
        },
      };


      let response = await fetch(ENDPOINTS.ADD_NEW_COUNTRY,requestOptions);
      console.log('response data:',response.status)
      if( response.status !== 201 )
      {
        let result = await response.json();
        this.error = result.msg || result;
        this.showAlert =true;
        console.log('response data:',response.status)
      }
      else if(  response.status === 201 ){
        this.$router.push('/countries');
      }
      console.log('status:', response.status  );
      return response;
      
    },
     // A method to check if a string is valid (only contains letters and spaces)
    checkStringIsValid(content)
    {
      if (content?.length === 0) return false;
        let data = content.match(/([a-zA-Z]+(\s[a-zA-Z]+){0,})/g) ;
        if ( data?.length === 0)
        {
          data = data[0].split(' ');
        }
        return data?.length === content.split(' ').length;
    },
           // A method to check if a slug is valid (only contains letters and hyphens)
    checkSlugIsValid(content)
    {
      if (content?.length === 0) return false;
        let data = content.match(/([a-zA-Z]+(-[a-zA-Z]+){0,})/g) ;
        if ( data?.length === 0)
        {
          data = data[0].split(' ');
        }
        return data?.length === content.split(' ').length;
    },
    checkCountryCodeIsValid(content)
    {
      if (content?.length === 0) return false;
        let data = content.match(/([A-Z]{2,})/g) ;
        if ( data?.length === 0)
        {
          data = data[0].split(' ');
        }
        return data?.length === content.split(' ').length;
    },

    checkValueValid(content)
    {
      return content >= 0;
    },
    setError()
    {
      this.error = []
      if (this.slug === '')
      {
        this.error.push('do not leave slug empty');
      }
      else if( this.checkSlugIsValid(this.slug)){
        this.error.push('the slug is not valide');
      }
      if (this.country === '')
      {
        this.error.push('do not leave country empty');
      }
      else if( this.checkStringIsValid(this.country)){
        this.error.push('the country is not valide');
      }
      if (this.country_code === '')
      {
        this.error.push('do not leave country_code empty');
      }
      else if( this.checkCountryCodeIsValid(this.country_code)){
        this.error.push('the country code is not valide');
      }
      this.showAlert =true;

    },
    async addCountrySubmitHandler()
    {
      console.log('...data')
      let isValidSubmition = ( 
        this.checkSlugIsValid(this.slug) &&
        this.checkStringIsValid( this.country ) &&
        this.checkCountryCodeIsValid(this.country_code) &&
        this.checkValueValid( this.new_confirmed) &&
        this.checkValueValid(this.total_confirmed) &&
        this.checkValueValid(this.new_deaths ) &&
        this.checkValueValid(this.new_recovered ) &&
        this.checkValueValid(this.total_recovered) &&
        this.checkValueValid(this.total_deaths)
      );
      console.log('validate...')
      if(isValidSubmition)
      { 
        console.log('requist...')
        let request = await this.postData();
      }
      else{
        console.log('error...')
        this.setError(); 
      }
    },
  },
}

</script>




    <style>
.form-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  margin-bottom: 10px;
}

.form-label {
  margin-right: 10px;
  width: 120px;
  text-align: left;
}

.form-input {
  flex: 1;
  max-width: 250px;
  height: 30px;
}
    .form-container {
      background-color: #fff;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    width: 40%;
    margin: 0 auto
    }
    .space{
      width: 300px;
      height: 100px;
    }
    body{
    background-image: url('/images/covi1d9.png');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    font-family: serif;
  }
  .submit-button{
    color: #fff;
    display: inline-block;
    background-color: rgb(58, 122, 143);
    border-radius: 10px;
    border: 4px double #cccccc;
width: 110px;
cursor: pointer;
margin: 5px;
box-shadow: #676767;
  }
  .submit-button:hover {
        background-color: rgb(31, 147, 70);
      }
      .add-text{
        color:rgb(58, 122, 143);
        padding-bottom: 10px;
      }
      .error-message{
        color:rgb(206, 28, 28);
        font-style: oblique;
      }
  </style>
  
 
  
    
    