<template>
    <div :id="'reply-'+id" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + data.owner.name"
                       v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>

                <div v-if="signedIn">
                   <favourite :reply="data"></favourite>
<!--                    <hello-world msg="this is app"></hello-world>-->
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>

                    <button class="btn btn-xs btn-primary">Update</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>
        </div>

        <div class="panel-footer level" v-if="canUpdate">
            <div>
                <button class="btn btn-xs mr-1" @click="editing = true" v-if="! editing">Edit</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
            </div>
        </div>
    </div>
</template>


    <script>
    import Favourite from './Favourite.vue';
    import  Helloworld from './HelloWorld';
    import moment from "moment";
export default {
    props :['data'],
    components:{"favourite":Favourite},
    data(){
        return {
            editing:false,
            body:this.data.body,
            id:this.data.id
        };
    },
    computed:{
        ago(){
            return moment(this.data.created_at).fromNow();
        },
        signedIn(){
            return window.App.signedIn;
        },
        canUpdate(){
            //return this.data.id==window.App.user.id;
            console.log(this.data.user_id);
            return this.authorise(user=> this.data.user_id == user.id)
        }
    },
        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
                this.editing = false;
                flash('Updated!');
            },
            destroy() {
                //alert("doe");
                axios.delete('/replies/' + this.data.id);
                this.$emit('deleted', this.data.id);
            }

    }
}


</script>