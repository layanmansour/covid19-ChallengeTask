<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <h4 class="text1">
            COVID-19
      </h4>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" @click="this.toggleNavBar"></span>
      </button>
      <div :class="this.showNav" id="navbarSupportedContent" >
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link :to="{ name: 'landing_page'}" class="nav-link">
             <p class="text1">Home</p> 
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{name:'countries_list'}" class="nav-link"> <p class="text1">Countries List</p></router-link>
          </li>
        
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default{
  name:"Navbar",
  data:function(){
    return {
      showData:false,
      showNav:"collapse navbar-collapse"
    }
  },
  methods: {
    toggleNavBar()
    {
      this.showData =  !this.showData;
      let data = "collapse navbar-collapse" ;
      //this.showNav = "collapse navbar-collapse" ;
      if (this.showData)
      {
        data += ' d-block';
      }
      console.log(data);
      this.showNav = data;
    }

  }
}
</script>
<style>
 
 
  .text1{
    color: white;
  }

  
  
  

</style>
