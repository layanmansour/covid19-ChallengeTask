<!-- use fetch api instead of axios in code: -->
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
import axios from 'axios';

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
        // Use fetch API to get data from "https://restcountries.com/v3.1/all"
        await fetch('https://restcountries.com/v3.1/all')
    .then(response=>response.json())
    .then(async response => {
        let countries = response;
        // Use fetch API to get data from "http://localhost:8000/api/countries/list"
        let countries_db = await fetch('http://localhost:8000/api/countries/list')
        .then(response=> response.json())
        .catch(err=>err);

        let countries_list = countries?.filter(country=>{
          let result = countries_db?.filter(country_db=>{
            let country_name = country.name.common;
            country_name = country_name.toLowerCase();
            country_name = country_name.replaceAll(' ','-');
            if(country_db?.slug==='morocco') {
                console.log(country_name,country_db?.slug); 
            }
            return country_name === country_db?.slug;
        });
        console.log(result.length)
        if(result.length) return result[0];
      });
       // Create features from the countries list and add them to the vector source
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
        // When the map is clicked, show a popup with country data
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
                const total_deaths = data.total_deaths;
                const total_confirmed= data.total_confirmed;
                const html = `
                  <div>
                    <h5>${countryId}</h5>
                    <p>New Confirmed: ${new_confirmed}</p>
                    <p>Total Confirmed: ${total_confirmed}</p>
                    <p>New Deaths: ${new_deaths}</p>
                    <p>Total Deaths: ${total_deaths}</p>
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
  height: 600px;
  width: 1200px;
}
#popup
{
  background:white;
  color:black;
  text-align: left;
}
.ol-zoom.ol-unselectable.ol-control {
    margin-left: -91%;
}
.ol-rotate.ol-unselectable.ol-control.ol-hidden {
    display: none;
}
.ol-attribution.ol-unselectable.ol-control.ol-uncollapsible {
    display: none;
}
h5{
  text-align: center;

}
</style>






