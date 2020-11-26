<template>
    <div class="container">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">body</th>
                <th scope="col">create_at</th>
                <th scope="col">削除</th>
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
            axios.post('/api/chat', this.chat)
                .then((res) => {
                    this.$router.push({name: 'task.chat.create'});
                });
            this.getMessages();
        },
        deleteChat(id) {
            axios.delete('/api/chat/' + id)
                .then((res) => {
                    this.getMessages();
                });
        }
    },
    mounted() {
        this.getMessages();
    },
}
</script>