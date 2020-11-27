<template>
    <div class="container">
        <div class="title">Chat</div>
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">body</th>
                <th scope="col">create_at</th>
                <th scope="col">削除する</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="message in messages">
                    <th scope="row">{{ message.id }}</th>
                    <td>{{ message.body }}</td>
                    <td>{{ message.created_at }}</td>
                    <td><button class="btn btn-danger" v-on:click="deleteChat(message.id)">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <form v-on:submit.prevent="submit">
            <div class="form-group row">
                <input type="text" class="col-sm-9 form-control" id="body" v-model="chat.body">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<style>
.title{
    font-size: 40px;
    margin: 10px;
    text-align: center;
}
</style>

<script>
export default {
    data: function () {
        return {
            messages: [],
            chat: {}
        }
    },
    methods: {
        getMessages() {
            axios.get('/api/chat')
                .then((res) => {
                    this.messages = res.data;
                });
        },
        submit() {
            if(this.chat.body != null){
                axios.post('/api/chat', this.chat);
                // .then((res) => {
                //     this.$router.push({name: 'task.chat.create'}); // このnameのpathに移行
                // });
                this.chat = {};
                this.getMessages();
            }
        },
        deleteChat(id) {
            axios.delete('/api/chat/' + id)
                .then((res) => {
                    this.getMessages();
                });
        },
    },
    mounted() {
        this.getMessages();
        Echo.channel('chat')
            .listen('MessageCreated', (e) => {
                this.getMessages(); // 全メッセージを再読込
            });

    },
}
</script>