<template>
    <table class="table table-striped table-dark">
      <thead>
        <tr>
          <th>Slug</th>
          <th>Country</th>
          <th>Country Code</th>
          <th>New Confirmed</th>
          <th>Total Confirmed</th>
          <th>New Deaths</th>
          <th>New Recovered</th>
          <th>Total Recovered</th>
          <th>Total Death</th>
          <th>Edit item</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td>{{ item.slug }}</td>
          <td>{{ item.country }}</td>
          <td>{{ item.country_code }}</td>
          <td>{{ item.new_confirmed }}</td>
          <td>{{ item.total_confirmed }}</td>
          <td>{{ item.new_deaths }}</td>
          <td>{{ item.new_recovered }}</td>
          <td>{{ item.total_recovered }}</td>
          <td>{{ item.total_deaths }}</td>
          <td>
            Edit
          </td>
        </tr>
      </tbody>
    </table>
    </template>
    
    <script>
    import {useRouter, useRoute} from 'vue-router';
    export default {
      name:"Countries",
      props: {
        data: {
          type: Array,
          required: true,
        },
      },
    };
    </script>