<template>
  <div class="space">
  </div>
  <div class="form-container"  style="width: 40%;   margin: 0 auto;">
    <form @submit.prevent="addCountrySubmitHandler">
      <h5 class="add-text">Add New Country</h5>
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
    const router = useRouter();
    export default{
      name:"CountrieAdd",
      mounted()
      {
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
            error: []
        }
      },
      methods: {
        async postData()
        {
          let formdata = new FormData();
          formdata.append("slug", this.slug);
          formdata.append("country", this.country);
          formdata.append("country_code", this.country_code);
          formdata.append("new_confirmed", this.new_confirmed);
          formdata.append("total_confirmed", this.total_confirmed);
          formdata.append("new_deaths", this.new_deaths);
          formdata.append("new_recovered", this.new_recovered);
          formdata.append("total_recovered", this.total_recovered);
          formdata.append("total_deaths", this.total_deaths);
          let requestOptions = {
            method: 'POST',
            body: formdata,
          };
          let request = await fetch('http://localhost:8000/api/country/add',requestOptions);
          if (request.status === 201)
          {
            this.$router.push('/countries');
          }
          else{
            let resposnse = await request.json();
            this.error = [response.msg];
          }
          return request;
        },
        checkStringIsValid(content)
        {
          if (content.length === 0) return false;
            let data = content.match(/([a-zA-Z]+(\s[a-zA-Z]+){0,})/g) ;
            if ( data.length === 0)
            {
              data = data[0].split(' ');
            }
            return data.length === content.split(' ').length;
        },
        checkValueValid(content)
        {
          return content >= 0;
        },
        setError()
        {
          this.error = []
          if(this.slug === '' && this.country === '' && this.country_code === ''){
            this.error.push('All fields are required, please fill them in');
          }
         else if (this.slug === '')
          {
            this.error.push('Slug is required, please fill ');
          }
        else  if (this.country === '')
          {
            this.error.push('Country name is required, please fill ');
          }
         else if (this.country_code === '')
          {
            this.error.push('Country Code is required, please fill ');
          }
        },
        async addCountrySubmitHandler()
        {
          let isValidSubmition = ( 
            this.checkStringIsValid(this.slug) &&
            this.checkStringIsValid( this.country ) &&
            this.checkStringIsValid(this.country_code) &&
            this.checkValueValid( this.new_confirmed) &&
            this.checkValueValid(this.total_confirmed) &&
            this.checkValueValid(this.new_deaths ) &&
            this.checkValueValid(this.new_recovered ) &&
            this.checkValueValid(this.total_recovered) &&
            this.checkValueValid(this.total_deaths)
          );
          if(isValidSubmition)
          { 
            let request = await this.postData();
          }
          else{
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
  
 
  
    
    