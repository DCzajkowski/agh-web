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
                        <div class="col-lg-12">
                            <div class="messages" v-if="messages.length && ! loading" ref="messages">
                                <div class="bubble" :class="{ 'bubble--own': message.from === auth.id }" v-for="message in messages" :title="message.created_at">
                                    {{ message.content }}
                                </div>
                            </div>
                            <div class="messages text-center" v-else-if="! loading">
                                No messages yet
                            </div>
                            <div class="messages text-center" v-else>
                                Loading...
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <form accept-charset="utf-8" @submit.prevent="send">
                                <div class="input-group">
                                    <input type="text" v-model="message" class="form-control" placeholder="Write something nice...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">Send</button>
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
                messages: [],
                loading: false,
                message: '',
            }
        },
        methods: {
            showConversationFor(user) {
                this.currentUser = user

                this.getInitialMessagesFor(user)
            },
            scrollToBottom() {
                this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight
            },
            getMessagesFor(user) {
                return new Promise((resolve, reject) => {
                    window.axios.get(`/api/messages/${this.currentUser.id}`, {
                        headers: {
                            'Authorization': `Bearer ${this.auth.api_token}`,
                        },
                    })
                    .then(response => {
                        this.messages = response.data
                        resolve()
                    })
                    .catch(error => reject(error))
                })
            },
            getInitialMessagesFor(user) {
                this.loading = true
                this.messages = []

                setInterval(() => {
                    this.getMessagesFor(user)
                        .then(() => {})
                        .catch(error => console.error(error))
                        .then(() => {
                            this.loading = false
                            setTimeout(() => this.scrollToBottom(), 100)
                        })
                }, 5000)
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
                        this.messages.push({
                            content: this.message,
                            to: this.currentUser.id,
                            from: this.auth.id,
                            updated_at: new Date().toJSON(),
                            created_at: new Date().toJSON(),
                        })
                        this.message = ''
                    })
                    .catch(error => console.error(error))
                    .then(() => {
                        this.loading = false
                        setTimeout(() => this.scrollToBottom(), 100)
                    })
                }
            },
        },
        mounted() {
            this.showConversationFor(this.users[0])
        },
    }
</script>
