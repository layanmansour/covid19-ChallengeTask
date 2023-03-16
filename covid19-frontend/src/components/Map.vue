<template>
    <div ref="map" class="map"></div>
    <div ref="popup" id="popup"></div>
  </template>
  
  <script>
  import { createApp } from 'vue';
  import { Map, View } from 'ol';
  import TileLayer from 'ol/layer/Tile';
  import OSM from 'ol/source/OSM';
  import VectorLayer from 'ol/layer/Vector';
  import VectorSource from 'ol/source/Vector';
  import Feature from 'ol/Feature';
  import Point from 'ol/geom/Point';
  import { fromLonLat } from 'ol/proj';
  import Overlay from 'ol/Overlay';
  
  export default {
    async mounted() {
      const map = new Map({
        target: this.$refs.map,
        layers: [
          new TileLayer({
            source: new OSM()
          })
        ],
        view: new View({
          center: fromLonLat([0, 0]),
          zoom: 2
        })
      });
  
      const overlay = new Overlay({
        element: document.getElementById('popup'),
        autoPan: true,
        autoPanAnimation: {
          duration: 250
        }
      });
  
      map.addOverlay(overlay);
  
      const vectorSource = new VectorSource();
  
      const vectorLayer = new VectorLayer({
        source: vectorSource
      });
  
      map.addLayer(vectorLayer);
      
      await fetch('https://restcountries.com/v3.1/all')
      .then(response=>response.json())
      .then(async response => {
          let countries = response;
          let countries_db = await fetch('http://localhost:8000/api/countries/list')
          .then(response=> response.json())
          .catch(err=>'::'+err);
  
          let data = countries.findIndex( country=>country.name.common === "Morocco" );
          let data1 = countries_db.findIndex( country=>country.slug === "morocco" );
          console.log('index1:',data) // 240
          console.log('index:',data1) // 120
          console.log('data:', countries[data])
          console.log('value:',countries_db[data1].slug)
          console.log('///////////////////////////////////////////')
          // find countries list from db
          let countries_list = [];
          let i,j;
          /*console.log('countries db:',countries[240].name.common.toLowerCase() === countries_db[120].slug );
          console.log('countries db:',countries_db[120].slug);
          console.log('******************************');*/
          for(i=0;i<countries_db.length;i++)
          {
            for(j=0;j<countries.length;j++)
            {
              let country = countries[j].name.common;
              country =country.toLowerCase();
              country = country.replaceAll(' ', '-');
              if (countries_db[i].slug === country )
              {
                if (i === 120 && j === 240)
                {
                  console.log('countries db:',countries[j].name.common.toLowerCase() , countries_db[i] );
                  console.log('*************saaa*********************')
                }
                countries_list.push(countries[j]);
                j = (j === countries.length-1 ) ? j: j+1;
                //break;
              }
            }
          }
  
          const features = countries_list?.map(country => {
          const [longitude, latitude] = country.latlng;
          const geometry = new Point(fromLonLat( [ latitude , longitude] ));
          const countryName = country.name.common;
          const feature = new Feature({
            geometry,
            name: country.name.common,
            countryId: country.countryId
          });
          feature.setId(countryName.replaceAll(' ', '-'));
          return feature;
      });
  
    vectorSource.addFeatures(features);
  
          map.on('singleclick', event => {
            map.forEachFeatureAtPixel(event.pixel, feature => {
              const countryId = feature.getId();
              console.log('country_id:',countryId);
              fetch(`http://localhost:8000/api/country/details/${countryId.toLowerCase()}`)
              .then(response => response.json())
              .then( response=>{
                  console.log(response);
                  let data = response;
                  const new_confirmed = data.new_confirmed;
                  const new_deaths = data.new_deaths;
                  const new_recovered = data.new_recovered;
                  const total_deaths = data.total_deaths;
                  const total_recovered = data.total_recovered;
                  const html = `
                    <div>
                      <h4>${countryId}</h4>
                      <p>new confirmed: ${new_confirmed}</p>
                      <p>new deaths: ${new_deaths}</p>
                      <p>total deaths: ${total_deaths}</p>
                      <p>total recobered: ${total_recovered}</p>
                    </div>
                  `;
                  overlay.getElement().innerHTML = html;
                  overlay.setPosition(event.coordinate);
              }).catch(error => {
                console.error(error);
              });
  
              });
          });
        })
        .catch(error => {
          console.error(error);
        });
    }
  };
  </script>
  
  <style>
  .map {
    height: 500px;
    width: 700px;
  }
  #popup
  {
    background:white;
    color:black;
  }
  </style>
  
  
  <style>
  .read-the-docs {
    color: #888;
  }
  body{
    background:'red';
  }
  .card{
    margin-right:2%;
    white-space:nowrap;
  }
  .ol-zoom.ol-unselectable.ol-control {
    margin-right: 85%;
  }
  .ol-rotate.ol-unselectable.ol-control.ol-hidden,.ol-attribution.ol-unselectable.ol-control.ol-uncollapsible.ol-collapsed, .ol-attribution.ol-unselectable.ol-control.ol-uncollapsible ul
  {
    display:none;
  
  }
  </style>
  