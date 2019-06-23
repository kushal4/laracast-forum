<script>
console.log("threads component");
    import Replies from '../components/Replies';
    import SubscribeButton from '../components/SubscribeButton';
    export default {
        name: 'thread-view',
        props: ['thread'],
        components: {
            "replies":Replies,
            "subscribe-button":SubscribeButton
        },
        data(){
            return{
                repliesCount: this.thread.replies_count,
                title: this.thread.title,
                body: this.thread.body,
            }
        }
    }

</script>
