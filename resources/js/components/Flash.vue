<template>
    <div class="alert alert-flash" :class="'alert-'+level"
         role="alert" v-show="show" v-text="body">

    </div>
</template>

<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
        props:['message'],
        data(){

            return {
                show:false,
                body :this.message,
                level:'success'
            }
        },
        created() {
            if(this.message){
               this.flash(message)
            }
             window.events.$on('flash',data=>{
                    console.log(data);
                 this.flash(data);
             });
        },
        methods:{
            flash(data){
                console.log("flash message");
                this.show=true;
                    this.body=data.message;
                    this.level=data.level;
                this.hide();
            },
            hide(){
                setTimeout(()=>{
                    this.show=false;
                },3000);
            }
        }
    }
</script>

<style>
    .alert-flash{
        position:fixed;
        right:25px;
        bottom: 25px;
    }
</style>
