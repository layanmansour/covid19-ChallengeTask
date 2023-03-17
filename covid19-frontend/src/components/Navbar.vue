<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <h4 class="text1">
            COVID-19
      </h4>
      </a>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
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

<style>
 
  .nav-link {
    color: #9a1e1e;  }
  .navbar-brand{
    color: #9a1e1e;  }
  .text1{
    color: white;
  }
  
  
  

</style>
