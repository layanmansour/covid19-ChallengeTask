<template>
    <form @submit.prevent="this.addCountrySubmitHandler">
       Add new country
      <p v-for="error in this.error">
      {{error}}
      </p>
      <div class="form-group">
        <label>Slug</label> 
        <input type="text" class="form-control" v-model="this.slug"/>
      </div>
    
       <div class="form-group">
        <label>Country</label>
        <input type="text" class="form-control" v-model="this.country" />
      </div>
      <div class="form-group">
        <label>Country code</label>
        <input type="text" class="form-control" v-model="this.country_code" min="0"/>
      </div>
    
      <div class="form-group">
        <label>new confirmed</label>
        <input type="number" class="form-control" v-model="this.new_confirmed" min="0"/>
      </div>
    
      <div class="form-group">
        <label>total confirmed</label>
        <input type="number" class="form-control" v-model="this.total_confirmed" min="0"/>
      </div>
    
      <div class="form-group">
        <label>new deaths</label>
        <input type="number" class="form-control" v-model="this.new_deaths" min="0"/>
      </div>
    
       <div class="form-group">
        <label>new recovered</label>
        <input type="number" class="form-control" v-model="this.new_recovered" min="0"/>
       </div>
    
       <div class="form-group">
        <label>total recovered</label>
        <input type="number" class="form-control" v-model="this.total_recovered" min="0"/>
       </div>
    
       <div class="form-group">
        <label>total death</label>
        <input type="number" class="form-control" v-model="this.total_deaths" min="0"/>
       </div>
    
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
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
          let request = await fetch('http://localhost:8082/api/country/add',requestOptions);
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
          if (this.slug === '')
          {
            this.error.push('do not leave slug empty');
          }
          if (this.country === '')
          {
            this.error.push('do not leave country empty');
          }
          if (this.country_code === '')
          {
            this.error.push('do not leave country_code empty');
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
    
    