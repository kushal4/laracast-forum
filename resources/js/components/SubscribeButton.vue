<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props:["active"],
        data(){
            return{
                copyactive:this.active
            }
        },
        computed:{
          classes(){
              return ["btn",this.copyactive?"btn-primary":"btn-light"];
          }
        },
        methods:{
            subscribe(){
                axios[this.copyactive?"delete":"post"](location.pathname + "/subscriptions");
                this.copyactive=!this.copyactive;

            }
        }
    }
</script>

<style scoped>

</style>