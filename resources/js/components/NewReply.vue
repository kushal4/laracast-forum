<template>
<div>
        <div v-if="signedIn">

                 <textarea name="body" id="descrip"
                           class="card w-full mb-4"
                           style="min-height: 200px"
                           placeholder="Anything special that you want to make a note of?"
                           cols="50"
                           v-model="body" required></textarea>

                <button type="submit" class="button" @click="addReply">Post</button>
        </div>
    <p v-else> Please <a href="/login">sign in</a>to participate in discussion</p>



</div>
</template>


<script>
     import 'jquery.caret';
     import 'at.js';
     export default{
         props:["endpoint"],
         data(){
             return{
                 body:''
             }
         },
         computed:{
             signedIn(){
                     return window.App.signedIn;
             }
         },
         mounted(){
             console.log("at new reply");
             $('#descrip').atwho({
                 at: "@",
                 delay:750,
                 callbacks:{
                     remoteFilter: function(query, callback) {
                         console.log("dfd");
                         $.getJSON("/api/users", {name: query}, function(usernames) {
                             callback(usernames);
                         });
                     }
                 }
             });
         },
         methods:{
             addReply(){
                 axios.post(this.endpoint,{body:this.body})
                     .then(response=>{
                         console.log(response);
                        this.body="";
                        flash("Your reply posted");
                        this.$emit("created",response.data)

                     }).catch(error => {
                     flash(error.response.data, 'danger');
                 });
             }
         }

    }
</script>