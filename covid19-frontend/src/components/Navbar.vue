<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <h4>
        COVID-19
      </h4>
      </a>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link :to="{ name: 'landing_page'}" class="nav-link">
              Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{name:'countries_list'}" class="nav-link">Countries List</router-link>
          </li>
        
        </ul>
      </div>
    </div>
  </nav>
</template>

<style>
  .navbar-nav .nav-link:hover {
    color: #fffcfc;
  }
  .nav-link {
    color: white;
  }
  .navbar-brand{
    color: white;

  }
</style>
