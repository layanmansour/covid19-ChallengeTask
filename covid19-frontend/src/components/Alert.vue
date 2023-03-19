<template>
  <br/>
  {{ messages.hasOwnProperty('errors') }} <br/>
  {{ messages }} <br/>
  {{ messages instanceof Array}} <br/>
  {{ messages instanceof Object}} <br/>
  
  <br/>
  <div class="alert" :class="alertClass" >
    <button type="button" class="close" @click="$emit('close')">&times;</button>
      <div v-if=" messages instanceof Array && messages.hasOwnProperty('errors')" v-for="(message, index) in messages?.errors" :key="index" >
         {{ message[0] }} 
      </div>
      <div v-if="messages instanceof Array && !messages.hasOwnProperty('errors')" v-for="(message, index) in messages" :key="msg-`${index}`" >
         {{ message }}
      </div>
      <div v-if="messages instanceof Object || false"> {{ messages.errors }} </div>
  </div>
  </template>
  
  <script>
  export default {
    props: {
      messages: {
        type: [Object, Array],
        required: true,
      },
      type: {
        type: String,
        default: "info",
      },
    },
    mounted(){
      console.log('alert component mounted')
      this.show = this.showAlert;
      console.log('show alert:',this.show,this.showAlert)
    },
    data() {
      return {
        //show: this.showAlert,
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
    watch: {
      showAlert() {
        // This method will be called whenever the childValue prop changes
        this.$forceUpdate();
      },
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