const ENDPOINTS = {
    COUNTRIES_LIST :`${import.meta.env.VITE_API_BASE_URL}/countries`,
    FILL_DATA :`${import.meta.env.VITE_API_BASE_URL}/fill_data`,
    ADD_NEW_COUNTRY :`${import.meta.env.VITE_API_BASE_URL}/country/add`,
    EDIT_COUNTRY :`${import.meta.env.VITE_API_BASE_URL}/country/edit` ,
    COUNTRIES_DETTAIL :`${import.meta.env.VITE_API_BASE_URL}/country/details` 
    
}

export default ENDPOINTS;