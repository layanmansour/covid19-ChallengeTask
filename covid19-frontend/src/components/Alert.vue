<template>
    <div class="alert" :class="alertClass" v-if="show">
      <button type="button" class="close" @click="hide">&times;</button>
      <div v-for="(message, index) in messages" :key="index">{{ message }}</div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      messages: {
        type: Array,
        required: true,
      },
      type: {
        type: String,
        default: "info",
      },
    },
    data() {
      return {
        show: true,
      };
    },
    computed: {
      alertClass() {
        return ["alert", `alert-${this.type}`];
      },
    },
    methods: {
      hide() {
        this.show = false;
      },
    },
    mounted() {
      setTimeout(() => {
        this.show = false;
      }, 10000);
    },
  };
  </script>
  
  <style>
  .alert {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 9999;
    width: 300px;
  }
  </style>
  