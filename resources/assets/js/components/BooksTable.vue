<template>
    <div>
        <div class="row">
            <div class="alert alert-error" v-if="error">
                {{ error }}
            </div>
            <div v-if="books" class="table-wrapper">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th style="width: 110px">Release Date</th>
                            <th style="width: 150px">Extras</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(book, index) in books" :key="book.id" class="visible-on-hover">
                            <td>{{ index }}</td>
                            <td>{{ book.title }}</td>
                            <td>{{ book.author }}</td>
                            <td>{{ book.publisher.name }}</td>
                            <td>{{ book.release_date }}</td>
                            <td>
                                <a href="#" class="should-appear" title="" style="margin-right: 1rem"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                <a href="#" class="should-appear" title=""><span class="glyphicon glyphicon-trash"></span> Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <loading-spinner></loading-spinner>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                error: null,
                books: null,
            }
        },
        mounted() {
            window.axios.get('/api/books')
                .then(response => {
                    this.books = response.data.data
                })
                .catch(error => {
                    this.error = 'We encountered a problem with connecting into out API.'
                })
        }
    }
</script>
