import NotFound from '../vues/NotFound.vue';
import CountriesList from '../vues/CountriesList.vue';
import Home from '../vues/Home.vue';
import CountriesSearch from '../vues/CountriesSearch.vue';
import CountryAdd from '../vues/CountryAdd.vue';
import CountryEdit from '../vues/CountryEdit.vue';
import {createRouter,createWebHistory} from 'vue-router'
const routes =[
    {
        path:'/',
        name:'landing_page',
        component:Home,
    },
    {
        path:'/countries/:page?',
        name:'countries_list',
        component:CountriesList,
    },
    {
        path:'/country/search/:search/:page?',
        name:'countries_search',
        component:CountriesSearch,
    },
    {
        path:"/country/add",
        name: 'country_add',
        component:CountryAdd,
    },
    {
        path:"/country/edit/:slug",
        name: 'country_edit',
        component:CountryEdit,
    },
    
    
    {
        path:
        "/404",
        name: '404_page',
        component: NotFound
    },
   
];

const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router;