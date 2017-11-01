<template>
    <div class="bg-white books-table-wrapper">
        <table class="table" id="books-table">
            <thead>
                <tr>
                    <th @click="sortBy('title')">
                        <div>
                            <span class="heading-text">Title</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'title', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('author')" style="width: 190px">
                        <div>
                            <span class="heading-text">Author</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'author', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('publisher')">
                        <div>
                            <span class="heading-text">Publisher</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'publisher', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('release_date')" style="width: 130px">
                        <div>
                            <span class="heading-text">Release Date</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'release_date', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('is_available')">
                        <div>
                            <span class="heading-text">Available?</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'is_available', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th v-if="canUpdateBooks || canDeleteBooks || canLendBooks" style="width: 210px"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="visible-on-hover" v-for="book in sortedBooks" :key="book.id">
                    <td>{{ book.title }}</td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.publisher.name }}</td>
                    <td class="text-center">{{ book.release_date }}</td>
                    <td class="text-center"><span :class="(book.is_available) ? 'text-success glyphicon glyphicon-ok' : 'text-danger glyphicon glyphicon-remove'"></span></td>
                    <td class="books-controls" v-if="canUpdateBooks || canDeleteBooks || canLendBooks">
                        <a
                            v-if="canLendBooks"
                            :href="`http://library.dev/checkout/${book.id}`"
                            class="should-appear"
                            style="margin-right: 1rem"
                        ><span class="glyphicon glyphicon-bookmark"></span> Lend</a>
                        <a
                            v-if="canUpdateBooks"
                            :href="`http://library.dev/books/${book.id}/edit`"
                            class="should-appear"
                            style="margin-right: 1rem"
                        ><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        <form
                            v-if="canDeleteBooks"
                            :action="`http://library.dev/books/${book.id}`"
                            method="post"
                            accept-charset="utf-8"
                        >
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" :value="csrfToken">

                            <button type="submit" class="should-appear btn btn-link text-danger inline">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center paginator">
            <ul class="pagination">
                <li :class="{ 'disabled': page === 1 }" @click="prev"><span>«</span></li>

                <li
                    v-for="i in pages"
                    :class="{ 'active': page === i, 'disabled': i === '...' }"
                    @click="(i !== '...') ? page = i : ''"
                    :key="i"
                ><span>{{ i }}</span></li>

                <li :class="{ 'disabled': page === lastPage() }" @click="next"><span>»</span></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'books',
            'canLendBooks',
            'canUpdateBooks',
            'canDeleteBooks',
            'search',
        ],
        data() {
            return {
                sort: null,
                order: null,
                limit: 20,
                page: 1,
                pages: [],
            }
        },
        computed: {
            csrfToken() {
                return window.csrf_token
            },
            filteredBooks() {
                if (this.search) {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().includes(this.search.toLowerCase())
                            || book.author.toLowerCase().includes(this.search.toLowerCase())
                            || book.publisher.name.toLowerCase().includes(this.search.toLowerCase())
                    })
                } else {
                    return JSON.parse(JSON.stringify(this.books))
                }
            },
            sortedBooks() {
                if (this.sort === null) {
                    return JSON.parse(JSON.stringify(this.filteredBooks)).slice((this.page - 1) * this.limit, this.page * this.limit + 1)
                } else if (['title', 'author', 'release_date'].includes(this.sort)) {
                    return JSON.parse(JSON.stringify(this.filteredBooks)).sort((a, b) => {
                        const fieldA = a[this.sort].toLowerCase()
                        const fieldB = b[this.sort].toLowerCase()

                        if (this.order === 'asc')  {
                            return (fieldA < fieldB) ? -1 : 1
                        } else {
                            return (fieldA > fieldB) ? -1 : 1
                        }
                    }).slice((this.page - 1) * this.limit, this.page * this.limit + 1)
                } else if (this.sort === 'publisher') {
                    return JSON.parse(JSON.stringify(this.filteredBooks)).sort((a, b) => {
                        const fieldA = a.publisher.name.toLowerCase()
                        const fieldB = b.publisher.name.toLowerCase()

                        if (this.order === 'asc')  {
                            return (fieldA < fieldB) ? -1 : 1
                        } else {
                            return (fieldA > fieldB) ? -1 : 1
                        }
                    }).slice((this.page - 1) * this.limit, this.page * this.limit + 1)
                }
            },
        },
        methods: {
            sortBy(field) {
                if (this.sort === field && this.order === 'asc') {
                    this.order = 'desc'
                } else if (this.sort === field && this.order === 'desc') {
                    this.sort = null
                    this.order = null
                } else {
                    this.sort = field
                    this.order = 'asc'
                }
            },
            prev() {
                if (this.page > 1) {
                    this.page--
                }
            },
            next() {
                if (this.page < this.lastPage()) {
                    this.page++
                }
            },
            lastPage() {
                return Math.ceil(this.filteredBooks.length / this.limit)
            },
            displayPages() {
                this.pages = []

                if (this.page > 5) {
                    this.pages.push(1)
                    this.pages.push(2)
                    this.pages.push('...')
                }
                for (let i = 0; i < this.lastPage(); i++) {
                    if (Math.abs(this.page - i) < 5) {
                        this.pages.push(i + 1)
                    }
                }
                if (this.page < this.lastPage() - 5) {
                    this.pages.push('...')
                    this.pages.push(this.lastPage() - 1)
                    this.pages.push(this.lastPage())
                }
            },
        },
        watch: {
            page() {
                this.displayPages()
            },
        },
        mounted() {
            this.displayPages()
        },
    }
</script>
