<template>
  <div class="space">
  </div>
  <div class="form-container"  style="width: 40%;   margin: 0 auto;">
    <form @submit.prevent="addCountrySubmitHandler">
      <h5 class="add-text"> Edit Country</h5>
      <div v-for="error in error" class="error-message">{{ error }}</div>

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

      

      <button type="submit" class="submit-button">Save</button>
    </form>
  </div>
</template>
  
<script>
import {useRouter,useRoute} from 'vue-router';
import Alert from "../components/Alert.vue";
export default{
  name:"CountrieAdd",
  components:{ Alert },
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
  async mounted()
  {
    const router = useRouter();
    const route = useRoute();
    //this.current_page = route.params?.page ?  
    this.slug = route.params?.slug; 
    // fetch api
    // promise: I will get you the data from the server, ( resolve , error )
    let request = await fetch(`http://localhost:8000/api/country/details/${this.slug}`);
    if ( request.status === 404 )
    {
      this.$router.push({name:'404_page'})
    }
    const data = await request.json();
    this.countries = data.country ;
    this.country=data.country;
    this.country_code=data.country_code;
    this.new_confirmed=data.new_confirmed;
    this.total_confirmed=data.total_confirmed;
    this.new_deaths=data.new_deaths;
    this.new_recovered=data.new_recovered;
    this.total_recovered=data.total_recovered;
    this.total_deaths=data.total_deaths;
    this.isLoading = false;
  },
  methods: {
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
        'Accept': 'application/json',
        },
      };
;
      let request = await fetch(`http://localhost:8000/api/country/edit/${this.slug}`,requestOptions);
      console.log('request',request.status);
      if ( request.status === 201)
      {
        this.$router.push('/countries');
      }
      else if ( request.status === 422)
      {
        let response = await request.json();
        this.error = response.msg || response;
        this.showAlert =true
      }
      return request;
    },
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
    checkSlugIsValid(content)
    {
      if (content?.length === 0) return false;
        let data = content.match(/([a-z]+(-[a-z]+){0,})/g) ;
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
    hideAlert() {
      this.showAlert = false;
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
    },
    async submitData()
    {
      this.error =[];
      this.showAlert = false;
      console.log(this.showAlert);
      console.log('----------------------');
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
      console.log(
        this.checkSlugIsValid(this.slug) ,
        this.checkStringIsValid( this.country ) ,
        this.checkCountryCodeIsValid(this.country_code) ,
        this.checkValueValid( this.new_confirmed) ,
        this.checkValueValid(this.total_confirmed) ,
        this.checkValueValid(this.new_deaths ) ,
        this.checkValueValid(this.new_recovered ) ,
        this.checkValueValid(this.total_recovered) ,
        this.checkValueValid(this.total_deaths)
      )
      if(isValidSubmition)
      { 
      await this.postData();
      }
      else{
        this.setError(); 

        this.showAlert = true;
        console.log('error::',this.showAlert,this.error)
      }
      console.log('sending data1...',this.error.length);;
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
      
     
      