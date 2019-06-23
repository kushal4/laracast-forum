<template>
    <li class="dropdown"  v-if="notifications.length">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-bell"></span>
        </a>

        <ul class="dropdown-menu">
            <li v-for="notification in notifications">
                <a :href="notification.data.link" v-text="notification.data.message" @click="markAsRead(notification)"></a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        name: "UserNotifications",
        data(){
            return{
                notifications:false
            }
        },
        created(){
            axios.get("/profiles/" +window.App.user.name+"/notifications").
            then((response)=>{
                console.log("notification to show");
                this.notifications=response.data;
                console.log(this.notifications);

            });
        },
        methods:{
            markAsRead(notification){
               // "/profiles/{$user->name}/notifications/" . $user->unreadNotifications->first()->id);
                axios.delete("/profiles/"+window.App.user.name+"/notifications/" +notification.id).
                    then((response)=>{

                });
            }
        }
    }
</script>

<style scoped>

</style>