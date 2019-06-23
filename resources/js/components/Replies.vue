<template>
    <div>
<!--        <h3>{{items}}</h3>-->
        <div v-for="(reply, index) in items" :key="reply.id">

            <reply :data="reply" @deleted="remove(index)"></reply>
            <paginator :dataSet="dataSet" @updated="fetch"></paginator>
        </div>
        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>

</template>

<script>
    import Reply from "./Reply";
    import NewReply from "./NewReply";
    import collection from "../mixins/collection";
    export default {
        components:{"reply":Reply,
           "new-reply":NewReply
        },
        mixins:[collection]
        ,
        props:[""],
        data(){
            return{
                endpoint:location.pathname+"/replies"
            }
        },
        created(){
            console.log("created component");
            console.log(location.pathname);
            this.fetch();
        },
        methods:{
            fetch(page){
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);
                    console.log(location.search);
                    console.log(query);
                    page = query ? query[1] : 1;
                    console.log(page);
                }
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            refresh({data}){
                console.log(data);
                this.dataSet=data;
                this.items=data.data;
                window.scrollTo(0,0);

            },
            url(page){
                return `${location.pathname}/replies?page=`+page;
            }
        }
    }
</script>

<style scoped>

</style>
