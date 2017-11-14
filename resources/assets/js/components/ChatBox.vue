<template>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body users-list">
                    <button type="button" class="list-group-item" v-for="user in users" :key="user.id" @click="showConversationFor(user)">{{ user.name }}</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Send a message</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 messages">
                            <div class="bubble" :class="{ 'bubble--own': message.from === auth.id }" v-for="message in messages" v-if="messages">
                                {{ message.content }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <form accept-charset="utf-8" @submit.prevent="send">
                                <div class="input-group">
                                        <input type="text" v-model="message" class="form-control" placeholder="Write something nice...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Send</button>
                                        </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['users', 'auth'],
        data() {
            return {
                currentUser: null,
                messages: null,
                loading: false,
                message: '',
            }
        },
        methods: {
            showConversationFor(user) {
                this.currentUser = user

                this.getMessagesFor(user)
            },
            getMessagesFor(user) {
                this.loading = true
                this.messages = []

                window.axios.get(`/api/messages/${this.currentUser.id}`, {
                    headers: {
                        'Authorization': `Bearer ${this.auth.api_token}`,
                    },
                })
                .then(response => {
                    this.messages = response.data
                })
                .catch(error => console.error(error))
                .then(() => this.loading = false)
            },
            send() {
                if (! this.loading) {
                    this.loading = true

                    window.axios.post(`/api/messages`, {
                        content: this.message,
                        to: this.currentUser.id,
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.auth.api_token}`,
                        },
                    })
                    .then(response => {
                        this.message = ''
                        this.getMessagesFor(this.currentUser)
                    })
                    .catch(error => console.error(error))
                    .then(() => this.loading = false)
                }
            },
        },
        mounted() {
            this.showConversationFor(this.users[0])
        },
    }
</script>
