<template>
    <div>
        <div class="row">
            <div class="alert alert-error" v-if="error">
                {{ error }}
            </div>
            <div v-if="response" class="table-wrapper">
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
                        <tr v-for="(book, index) in response.data.books" :key="book.id" class="visible-on-hover">
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
                <!-- <div class="paginator">
                    <ul class="pagination" v-if="range.length > 1">
                        <a :href="response.meta.prev_page_url" rel="prev">&laquo;</a>
                        <li v-for="index in range" :key="index">
                            <li><a :href="`http://library.dev/api/books?page=${index}`">{{ index }}</a></li>
                        </li>
                        <a :href="response.meta.next_page_url" rel="next">&raquo;</a>
                        <li><a href="http://library.dev/api/books?page=1">1</a></li>
                        <li class="active"><span>2</span></li>
                        <li><a href="http://library.dev/api/books?page=3">3</a></li>
                        <li><a href="http://library.dev/api/books?page=4">4</a></li>
                        <li><a href="http://library.dev/api/books?page=5">5</a></li>
                        <li><a href="http://library.dev/api/books?page=6">6</a></li>
                        <li><a href="http://library.dev/api/books?page=7">7</a></li>
                        <li><a href="http://library.dev/api/books?page=8">8</a></li>
                        <li class="disabled"><span>...</span></li>
                        <li><a href="http://library.dev/api/books?page=49">49</a></li>
                        <li><a href="http://library.dev/api/books?page=50">50</a></li>
                        <li><a href="http://library.dev/api/books?page=3" rel="next">&raquo;</a></li>
                    </ul>
                </div> -->
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
                response: null,
                range: [],
            }
        },
        mounted() {
            window.axios.get('/api/books')
                .then(response => {
                    this.response = response.data
                    for (let i = 0; i < this.response.meta.last_page; i++) {
                        this.range[i] = i + 1
                    }
                })
                .catch(error => {
                    this.error = 'We encountered a problem with connecting into out API.'
                })
        }
    }
</script>
